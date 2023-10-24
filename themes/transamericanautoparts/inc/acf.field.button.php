<?php

// exit if accessed directly
if( ! defined( 'ABSPATH' ) ) exit;


class gp_acf_button extends acf_field
{
    // vars
    var $settings, // will hold info such as dir / path
        $defaults; // will hold default field options

    /**
     *  __construct
     *
     *  Set name / label needed for actions / filters
     *
     *  @since  3.6
     *  @date   23/01/13
     */

    function __construct( $settings )
    {
        // vars
        $this->name = 'gp_acf_button';
        $this->label = __('Button', 'acf');
        $this->category = __("Content",'acf'); // Basic, Content, Choice, etc
        $this->defaults = array();
        $this->settings = $settings;

        // do not delete!
        parent::__construct();
    }

    /**
     * create_options()
     *
     *  Create extra options for your field. This is rendered when editing a field.
     *  The value of $field['name'] can be used (like bellow) to save extra data to the $field
     *
     *  @type   action
     *  @since  3.6
     *  @date   23/01/13
     *
     *  @param  $field  - an array holding all the field's data
     */

    function render_field_settings( $field ) {
        // We have no field settings
    }

    /*
    *  create_field()
    *
    *  Create the HTML interface for your field
    *
    *  @param   $field - an array holding all the field's data
    *
    *  @type    action
    *  @since   3.6
    *  @date    23/01/13
    */
    function render_field( $field ) {
        // Get colors
        $colors = UI::colors();
        ?>

        <div class="acf-field acf-field-text" style="width:50%;" data-width="50">
            <div class="acf-label">
                <label for="">Button Label</label>
            </div>
            <div class="acf-input">
                <input type="text" name="<?=$field['name']?>[label]" id="<?=$field['id']?>-label" value="<?=$field['value']['label']?>">
            </div>
        </div>

        <div class="acf-field acf-field-text" style="width:50%;" data-width="50">
            <div class="acf-label">
                <label for="">Button URL</label>
            </div>
            <div class="acf-input">
                <input type="text" name="<?=$field['name']?>[url]" id="<?=$field['id']?>-url" value="<?=$field['value']['url']?>">
            </div>
        </div>

        <div class="acf-field acf-field-text" style="width:33%;" data-width="33">
            <div class="acf-label">
                <label for="">Button Color</label>
            </div>
            <div class="acf-input">
                <select name="<?=$field['name']?>[color]" id="<?=$field['id']?>-color" class="<?=$field['class']?>">
                    <option value="0">- Select One -</option>
                    <?php foreach($colors as $slug=>$label) { ?>
                        <option value="<?=$slug?>" <?=($slug == $field['value']['color'] ? 'selected' : '')?>><?=$label?></option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <div class="acf-field acf-field-text" style="width:33%;" data-width="33">
            <div class="acf-label">
                <label for="">Button Size</label>
            </div>
            <div class="acf-input">
                <select name="<?=$field['name']?>[size]" id="<?=$field['id']?>-size" class="<?=$field['class']?>">
                    <option value=""> </option>
                    <option value="xs" <?=("xs" == $field['value']['size'] ? 'selected' : '')?>>XS</option>
                    <option value="sm" <?=("sm" == $field['value']['size'] ? 'selected' : '')?>>SM</option>
                    <option value="md" <?=("md" == $field['value']['size'] ? 'selected' : '')?>>MD</option>
                    <option value="lg" <?=("lg" == $field['value']['size'] ? 'selected' : '')?>>LG</option>
                    <option value="xl" <?=("xl" == $field['value']['size'] ? 'selected' : '')?>>XL</option>
                </select>
            </div>
        </div>

        <div class="acf-field acf-field-text" style="width:33%;" data-width="33">
            <div class="acf-label">
                <label for="">Button Target</label>
            </div>
            <div class="acf-input">
                <input type="checkbox" name="<?=$field['name']?>[new_window]" <?=($field['value']['new_window'] == true) ? 'checked' : ''?>> Check to open in new window
            </div>
        </div>

        <div class="acf-field acf-field-text" style="width:33%;" data-width="33">
            <div class="acf-label">
                <label for="">Button Display</label>
            </div>
            <div class="acf-input">
                <input type="checkbox" name="<?=$field['name']?>[display_block]" <?=($field['value']['display_block'] == true) ? 'checked' : ''?>> Display as block
            </div>
        </div>

        <div class="acf-field acf-field-text" style="width:33%;" data-width="33">
            <div class="acf-label">
                <label for="">Button Uppercase</label>
            </div>
            <div class="acf-input">
                <input type="checkbox" name="<?=$field['name']?>[uppercase]" <?=($field['value']['uppercase'] == true) ? 'checked' : ''?>> Uppercase letters
            </div>
        </div>




        <?php
    }




    function format_value( $value, $post_id, $field ) {


        // Change the `new_window` value
        if($value['new_window'] == "on") {
            $value['new_window'] = true;
        } else {
            $value['new_window'] = false;
        }

        // Output a button
        return UI::button($value['label'],$value['url'],$value);
    }
}
// create field
new gp_acf_button( array() );