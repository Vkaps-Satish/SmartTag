<?php

namespace WPDesk\ShopMagic\Action\Builtin;

use WPDesk\ShopMagic\Action\BasicAction;
use WPDesk\ShopMagic\Automation\Automation;
use WPDesk\ShopMagic\Event\Event;

/**
 * ShopMagic Send Email Action class
 *
 * @package ShopMagic
 * @since   1.0.0
 */
final class SendMail extends BasicAction {
	const PARAM_TEMPLATE_TYPE = 'template_type';
	const PARAM_TO = 'to_value';
	const PARAM_SUBJECT = 'subject_value';
	const PARAM_MESSAGE_TEXT = 'message_text';

	static protected $slug = "shopmagic_sendemail_action";
	static protected $data_domains = array( 'user' );

	public static function get_required_data_domains() {
		return [ \WP_User::class ];
	}

	public static function get_name() {
		return __( 'Send Email', 'shopmagic-for-woocommerce' );
	}

	/**
	 * Creates a template class of a given type.
	 *
	 * @param string $template_type Type to create.
	 *
	 * @return \ShopMagic_Template
	 */
	private function create_template( $template_type ) {
		switch ( $template_type ) {
			case \ShopMagic_Template_WooCommerce_Mail::NAME:
				return new \ShopMagic_Template_WooCommerce_Mail();
		}

		return new \ShopMagic_Template_Plain();
	}

	public function execute( Automation $automation, Event $event ) {

		$subject = $this->placeholder_processor->process( isset( $this->data[ self::PARAM_SUBJECT ] ) ? $this->data[ self::PARAM_SUBJECT ] : '' );
		$to      = $this->placeholder_processor->process( isset( $this->data[ self::PARAM_TO ] ) ? $this->data[ self::PARAM_TO ] : '' );

		//$message = apply_filters('shopmagic_render_email_template',$this->automation_id.'%'.$key.'%message_text', $event->get_placeholders_values());
		$raw_message = wpautop( $this->placeholder_processor->process( isset( $this->data[ self::PARAM_MESSAGE_TEXT ] ) ? $this->data[ self::PARAM_MESSAGE_TEXT ] : '' ) );

		$template_type = $this->placeholder_processor->process( isset( $this->data[ self::PARAM_TEMPLATE_TYPE ] ) ? $this->data[ self::PARAM_TEMPLATE_TYPE ] : '' );
		$message       = $this->create_template( $template_type )->wrap_content( $raw_message );

		add_filter( 'wp_mail_content_type', array( $this, 'set_mail_content_type' ) );

		//Set From and To to match WooCommerce Settings
		add_filter( 'wp_mail_from', function ( $email ) {
			return get_option( 'woocommerce_email_from_address' );
		} );
		add_filter( 'wp_mail_from_name', function ( $name ) {
			return get_option( 'woocommerce_email_from_name' );
		} );

		$headers = $headers = [
			'Content-Type: ' . $this->set_mail_content_type(),
		];

		wp_mail( $to, $subject, $message, $headers );

		remove_filter( 'wp_mail_content_type', array( $this, 'set_mail_content_type' ) );

	}

	/**
	 * Action callback to set more complex context type for sending email
	 *
	 * @return string content type for email
	 */
	public function set_mail_content_type() {
		return "text/html";
	}

	/**
	 * Show parameters window in an admin side widget
	 *
	 * @param $automation_id integer called automation id
	 * @param $data array current action settings to set default values
	 * @param $name_prefix string prefix for form control name attributes
	 *
	 * @since   1.0.0
	 */
	public static function show_parameters( $automation_id, $data, $name_prefix ) {
		$editor_initialized = false;
		if ( $data['editor_initialized'] === true ) {
			$editor_initialized = true;
		}

		if ( ! isset( $data['_action'] ) || $data['_action'] !== self::$slug ) { // if data are from other class type then cleanup data array
			$data = array( // default values
				self::PARAM_TO => '{{ customer.email }}',
			);
		}

		$editor_id = str_replace( '[', '_', $name_prefix . '[message_text]' );
		$editor_id = str_replace( ']', '_', $editor_id );

		wp_print_styles( 'media-views' );

		//get list of available templates
		$dir_list          = scandir( SHOPMAGIC_BASE_DIR . '/templates/emails/' );
		$list_of_templates = array();
		foreach ( $dir_list as $file ) {
			if ( strpos( $file, '.tmpl' ) !== false ) {
				// extract template title from file
				$fh   = fopen( SHOPMAGIC_BASE_DIR . '/templates/emails/' . $file, 'r' );
				$line = fgets( $fh );
				fclose( $fh );
				preg_match( '/\/\*\*(.*?)\*\*\//', $line, $res );
				array_push( $list_of_templates,
					'<option value="' . str_replace( '.tmpl', '', $file ) . '">' . trim( $res[1] ) . '</option>' );
			}
		}

		?>
		<script>
			window.SM_EditorInitialized = true;
		</script>
		<table class="shopmagic-table">
			<tr class="shopmagic-field">
				<td class="shopmagic-label">
					<label for="subject_value"><?php _e( 'Subject', 'shopmagic-for-woocommerce' ); ?></label>
				</td>

				<td class="shopmagic-input">
					<input type="text" name="<?php echo $name_prefix; ?>[<?php echo self::PARAM_SUBJECT; ?>]"
					       id="subject_value"
					       value="<?php echo isset( $data[ self::PARAM_SUBJECT ] ) ? $data[ self::PARAM_SUBJECT ] : ''; ?>"/>
				</td>
			</tr>

			<tr class="shopmagic-field">
				<td class="shopmagic-label">
					<label for="to_value"><?php _e( 'To', 'shopmagic-for-woocommerce' ); ?></label><br/>
				</td>

				<td class="shopmagic-input">
					<input type="text" name="<?php echo $name_prefix; ?>[to_value]" id="<?php echo self::PARAM_TO; ?>"
					       value="<?php echo isset( $data[ self::PARAM_TO ] ) ? $data[ self::PARAM_TO ] : ''; ?>"/>
				</td>
			</tr>

			<tr class="shopmagic-field">
				<td class="shopmagic-label">
					<label for="<?php echo $name_prefix; ?>template"><?php _e( 'Template',
							'shopmagic-for-woocommerce' ); ?></label>
				</td>

				<td class="shopmagic-input">
					<select id="<?php echo $name_prefix; ?>template"
					        name="<?php echo $name_prefix; ?>[<?php echo self::PARAM_TEMPLATE_TYPE; ?>]">
						<option
							value="<?php echo \ShopMagic_Template_WooCommerce_Mail::NAME; ?>" <?php if ( isset( $data[ self::PARAM_TEMPLATE_TYPE ] ) && $data[ self::PARAM_TEMPLATE_TYPE ] === \ShopMagic_Template_WooCommerce_Mail::NAME ): ?> selected="selected"<?php endif; ?>><?php _e( 'WooCommerce Template',
								'shopmagic-for-woocommerce' ); ?></option>
						<option
							value="<?php echo \ShopMagic_Template_Plain::NAME; ?>" <?php if ( ( isset( $data[ self::PARAM_TEMPLATE_TYPE ] ) && $data[ self::PARAM_TEMPLATE_TYPE ] === \ShopMagic_Template_Plain::NAME ) || ( empty( $data[ self::PARAM_TEMPLATE_TYPE ] ) && isset( $data[ self::PARAM_SUBJECT ] ) ) ): ?> selected="selected"<?php endif; ?>><?php _e( 'None',
								'shopmagic-for-woocommerce' ); ?></option>
					</select>
				</td>
			</tr>

			<tr class="shopmagic-field email_templates_<?php echo $editor_id; ?> email_templates">
				<td class="shopmagic-label">
					<label for="predefined_block_<?php echo $editor_id; ?>"><?php _e( 'Content blocks',
							'shopmagic-for-woocommerce' ); ?></label>

					<p class="content"><?php _e( 'Add a predefined content to speed up your automation creation.',
							'shopmagic-for-woocommerce' ); ?><?php _e( 'Please use visual editor to insert blocks.',
							'shopmagic-for-woocommerce' ); ?></p>
				</td>

				<td class="shopmagic-input">
					<div class="shopmagic-input-wrap">
						<select type="text" id="predefined_block_<?php echo $editor_id; ?>">
							<?php echo implode( '', $list_of_templates ); ?>
						</select>
					</div>

					<div class="et_wrapper">
						<div class="button button-default"
						     onclick="loadEmailTemplate('<?php echo $editor_id; ?>')"><?php _e( '+ Insert block',
								'shopmagic-for-woocommerce' ); ?></div>
						<div class="error-icon"><span class="dashicons dashicons-warning"></span>
							<div class="error-icon-tooltip"><?php _e( 'Network connection error',
									'shopmagic-for-woocommerce' ); ?></div>
						</div>
						<div class="spinner"></div>
					</div>
				</td>
			</tr>

			<tr class="shopmagic-field">
				<td class="shopmagic-label">
					<label for="message_text"><?php _e( 'Message', 'shopmagic-for-woocommerce' ); ?></label>

					<p class="content"><?php _e( 'Copy and paste placeholders (including double brackets) from the metabox on the right to personalize.',
							'shopmagic-for-woocommerce' ); ?></p>
				</td>

				<td class="shopmagic-input">
					<?php

					$id              = uniqid();
					$editor_settings = array(
						'textarea_name' => $name_prefix . '[message_text]'
					);

					wp_editor( isset( $data[ self::PARAM_MESSAGE_TEXT ] ) ? $data[ self::PARAM_MESSAGE_TEXT ] : '', $id,
						$editor_settings );

					?>
					<script type="text/javascript">
						(function () {
							ShopMagic.wyswig.init('<?php echo $id; ?>');
						}());
					</script>

				</td>
			</tr>
		</table>

		<?php

	}

	/**
	 * Save parameters from POST request, called from an admin side widget
	 *
	 * in this method we should analyse $post array and store data accordingly in $data array
	 *
	 * @param $automation_id integer called automation id
	 * @param $data array pointer to an array which is will be stored in meta for an automation
	 * @param $post array part from $_POST array, which is belongs for a current action
	 *
	 * @since   1.0.0
	 */
	public static function save_parameters( $automation_id, &$data, $post ) {
		$data[ self::PARAM_SUBJECT ]       = sanitize_text_field( $post[ self::PARAM_SUBJECT ] );
		$data[ self::PARAM_TO ]            = sanitize_text_field( $post[ self::PARAM_TO ] );
		$data[ self::PARAM_TEMPLATE_TYPE ] = sanitize_text_field( $post[ self::PARAM_TEMPLATE_TYPE ] );
		$data[ self::PARAM_MESSAGE_TEXT ]  = $post[ self::PARAM_MESSAGE_TEXT ];
	}

}
