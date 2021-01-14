<table class="form-table">
    <?php

    foreach($part['field'] as $k => $field) {
        $attr = '';

        if ( ! empty($field['attr'])) {

            $attr = $field['attr'];
        }

        ?>

        <tr valign="top" style="border-bottom: 1px solid #d5dde4" id="<?php  if ( !empty($field['name'])) print $field['name'].'-field-tr'; ?>" <?php echo isset($field['tr_attr']) ? $field['tr_attr'] : '' ?> >
            <th valign="top" style="vertical-align: top; min-width: 300px;" <?php echo !empty( $field['type']) && $field['type'] == 'title' ? 'colspan="2"' : ''?> >
                <?php

                if ( !empty( $field['type']) && $field['type'] == 'title' ) {

                    print '<h3>' . __( $field['title'], 'login-form' ) .'</h3>';
                }
                else {

                    print __( $field['title'], 'login-form' );

                }
                ?>
            </th>
            <?php if ( !empty( $field['type']) && $field['type'] != 'title' || empty( $field['type']) ) { ?>
                <td  <?php echo isset($field['td_attr']) ? $field['td_attr'] : 'valign="top" class="field_input_box"' ?>>

                    <?php

                    if ( ! empty($field['name'])){

                        if( isset($field['default_value'])) {
                            $value =  get_option( $field['name'], $field['default_value'] );
                        }
                        else {
                            $value =  get_option( $field['name'] );
                        }

                    }

                    if ( empty( $field['type']) or $field['type'] == 'text' ) {


                        ?>
                        <input type="text" name="<?php echo esc_attr( $field['name'] );?>" value="<?php echo esc_attr( $value ) ?>" <?php print $attr?> />
                        <?php
                        echo isset($field['desc_value']) ? $field['desc_value'] : '';
                    }
                    else if($field['type'] == 'file'){

                        ?>
                        <input type="text"  name="<?php echo esc_attr( $field['name'] );?>" value="<?php echo esc_attr( $value ); ?>" />
                        <input type="button" class="file_chooser button" value="<?php _e( 'Upload file', 'login-form')?>" />
                        <input type="button" class="prev_reset button" value="<?php _e( 'Reset', 'login-form')?>" />
                    <?php
                    }
                    else if($field['type'] == 'image'){

                        ?>
                        <input type="text"  name="<?php echo esc_attr( $field['name'] );?>" value="<?php echo esc_attr( $value ); ?>" />
                        <input type="button" class="image_chooser button" value="<?php _e( 'Upload file', 'login-form')?>" />
                        <input type="button" class="prev_reset button" value="<?php _e( 'Reset', 'login-form')?>" />
                    <?php
                    }
                    else if ($field['type'] == 'select') {

                        ?>
                        <select name="<?php echo esc_attr( $field['name'] );?>">

                            <?php

                            if ( ! empty($field['values']) ) {

                                foreach($field['values'] as $f_key => $f_value ){

                                    print '<option value="' . esc_attr( $f_key ).'"';

                                    if($f_key == $value){

                                        print ' selected';
                                    }

                                    print '>'. __( $f_value, 'login-form' ) .'</option>';
                                }
                            }


                            ?>


                        </select>
                    <?php
                    }
                    else if ($field['type'] == 'radio') {


                        if ( ! empty($field['values']) ) {

                            foreach($field['values'] as $f_key => $f_value ){



                                print '<input type="radio" name="'. esc_attr( $field['name'] ) .'" value="'. esc_attr( $f_key ) .'" id="' . esc_attr( $field['name'] . '_' . $f_key ) . '" ' . (isset($field['attr']) ? $field['attr'] : '');
                                if($f_key == $value){

                                    print ' checked';
                                }

                                print ' />';

                                print '<label for="' . esc_attr( $field['name']  . '_' . $f_key ) . '">'. __( $f_value, 'login-form' ) .'</label>';

                                print '<br />';

                            }
                        }
                    }
                    else if($field['type'] == 'custom'){
                        if( $field['show_function'] && function_exists($field['show_function'])){
                            $field['show_function']($field, $value);
                        }
                    }

                    if ( ! empty( $field['description']) ) {
                        print '<p class="description" style="max-width: 300px;">' . __( $field['description'], 'login-form' ) . '</p>';
                    }

                    ?>
                </td>
                <?php if (isset($part['name']) && $part['name'] == 'design' && $k == 0): ?>
                    <td rowspan="<?php echo count($part['field']); ?>" style="vertical-align: top;">
                        <?php

                        // preview

                        $preview_style = 'width:350px';

                        if( get_option('form-orientation') == 'horizontal' ){
                            $preview_style = 'width:640px;';
                        }

                        ?>


                        <div style="position: relative; " id="lf-settings-form-preview">
                            <div style="">
                                <div id="test"></div>
                                <div id="lf_form_cont" style="<?php echo esc_attr( $preview_style ) ;?>;padding:20px; margin-bottom:20px; border:1px solid #d5dde4; background-color: white; ">

                                    <h3 style="margin: 0 0 10px 0;"><?php _e('Preview', 'login-form' )?></h3>

                                    <?php print $wpadm_login->form(true) ?>
                                    <div class="clear"></div>
                                </div>
                            </div>
                        </div>
                    </td>
                <?php endif; ?>


            <?php } ?>
        </tr>
    <?php
    }
    ?>
</table>
