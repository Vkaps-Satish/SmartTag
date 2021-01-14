<?php

/**
 * WooCommerce mail template.
 *
 * @package ShopMagic
 */
class ShopMagic_Template_WooCommerce_Mail extends ShopMagic_Template {
	const NAME = 'woocommerce';

	/**
	 * Wrap given content in a WooCommerce mail template.
	 *
	 * @param string $html_content
	 * @param array $args
	 *
	 * @return string
	 */
	public function wrap_content( $html_content, array $args = [] ) {
		$html_content = $this->wrap_html( $html_content );
		$css          = $this->render_css();

		$html_content = $this->encode_inline_css( $html_content, $css );

		return apply_filters( 'woocommerce_mail_content', $html_content );
	}

	/**
	 * Wrap html into WC template.
	 *
	 * @param string $html
	 *
	 * @return string
	 */
	private function wrap_html( $html ) {
		ob_start();
		$this->print_template_part( 'email-header.php', [
			'email_heading' => ''
		] );
		echo $html;
		$this->print_template_part( 'email-footer.php' );

		return ob_get_clean();
	}

	/**
	 * Prints given WooCommerce template.
	 *
	 * @param string $file
	 * @param array $args
	 */
	private function print_template_part( $file, array $args = [] ) {

		extract( $args, EXTR_SKIP );

		$template_name = 'emails/' . $file;
		$template_path = '';

		$located = wc_locate_template( 'emails/' . $file, $template_path );

		$located = apply_filters( 'wc_get_template', $located, $template_name, $args, $template_path, '' );
		do_action( 'woocommerce_before_template_part', $template_name, $template_path, $located, $args );

		include $located;

		do_action( 'woocommerce_after_template_part', $template_name, $template_path, $located, $args );
	}

	/**
	 * Renders WC css.
	 *
	 * @return string
	 */
	private function render_css() {
		ob_start();
		$this->print_template_part( 'email-styles.php' );

		return apply_filters( 'woocommerce_email_styles', ob_get_clean() );
	}

	/**
	 * Insert css into html in a best way possible.
	 *
	 * @param string $html
	 * @param string $css
	 *
	 * @return string HTML with encoded inline css.
	 */
	private function encode_inline_css( $html, $css ) {
		try {
			$emogrifier = ShopMagic_Emogrifier_Factory::create_Emogrifier( $html, $css );

			return $emogrifier->emogrify();
		} catch ( \ShopMagic_Emogrifier_Factory_NotFound_Exception $e ) {
			error_log( "Emogrifier error: {$e->getMessage()} code: {$e->getCode()}" );

			return '<style type="text/css">' . $css . '</style>' . $html;
		}
	}

}