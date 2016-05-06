<?php

add_filter("gform_field_content", "bootstrap_styles_for_gravityforms_fields", 10, 5);

function bootstrap_styles_for_gravityforms_fields($content, $field, $value, $lead_id, $form_id){

    // Currently only applies to most common field types, but could be expanded.

    if($field["type"] != 'hidden' && $field["type"] != 'list' && $field["type"] != 'multiselect' && $field["type"] != 'checkbox' && $field["type"] != 'fileupload' && $field["type"] != 'date' && $field["type"] != 'html' && $field["type"] != 'address') {
        $content = str_replace('class=\'medium', 'class=\'form-control medium', $content);
    }

    if($field["type"] == 'name' || $field["type"] == 'address') {
        $content = str_replace('<input ', '<input class=\'form-control\' ', $content);
    }

    if($field["type"] == 'textarea') {
        $content = str_replace('class=\'textarea', 'class=\'form-control textarea', $content);
    }

    if($field["type"] == 'checkbox') {
        $content = str_replace('li class=\'', 'li class=\'checkbox ', $content);
        $content = str_replace('<input ', '<input style=\'margin-left:1px;\' ', $content);
    }

    if($field["type"] == 'radio') {
        $content = str_replace('li class=\'', 'li class=\'radio ', $content);
        $content = str_replace('<input ', '<input style=\'margin-left:1px;\' ', $content);
    }

	return $content;

	
	
} // End bootstrap_styles_for_gravityforms_fields()



function bootstrap_gform_submit_button( $button, $form ) {
	$button = sprintf(
		'<input type="submit" class="btn btn-primary" id="gform_submit_button_%d" value="%s">',
		absint( $form['id'] ),
		esc_attr( $form['button']['text'] )
	);
	return $button;
}
add_filter( 'gform_submit_button', 'bootstrap_gform_submit_button', 10, 2 );