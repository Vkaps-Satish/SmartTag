<?php 
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

?>

<div class="table-wrapper content">
    <h3><?php _e('Main Content', 'cmp-coming-soon-maintenance');?></h3>
    <table class="content">
        <tbody>
        <tr class="body-title">
            <th><?php _e('Heading', 'cmp-coming-soon-maintenance');?></th>
            <td>
                <fieldset>
                    <input type="text" name="niteoCS_body_title" id="niteoCS_body_title" value="<?php echo esc_attr( $niteoCS_body_title ); ?>" class="regular-text code" placeholder="<?php _e('Leave empty to disable', 'cmp-coming-soon-maintenance');?>">
                </fieldset>
            </td>
        </tr>

        <tr>
            <th><?php _e('Message', 'cmp-coming-soon-maintenance');?></th>
            <td>
                <?php wp_editor( $this->niteo_sanitize_html( $niteoCS_body ), 'niteoCS_body', $settings = array('textarea_name'=>'niteoCS_body', 'editor_height'=>'300') ); ?>
                <span class="cmp-hint">* <?php _e('WordPress embeds are fully supported. You can also add any custom HTML. No 3rd party shortcodes are currently supported.', 'cmp-coming-soon-maintenance');?></span>
            </td>
        </tr>

        <?php echo $this->render_settings->submit(); ?>

        </tbody>
    </table>

</div>