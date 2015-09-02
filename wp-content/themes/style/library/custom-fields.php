<?php
/**
 * Include and setup custom metaboxes and fields. (make sure you copy this file to outside the CMB2 directory)
 *
 * Be sure to replace all instances of 'yourprefix_' with your project's prefix.
 * http://nacin.com/2010/05/11/in-wordpress-prefix-everything/
 *
 * @category YourThemeOrPlugin
 * @package  Demo_CMB2
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     https://github.com/WebDevStudios/CMB2
 */

/**
 * Get the bootstrap! If using the plugin from wordpress.org, REMOVE THIS!
 */

// if ( file_exists( dirname( __FILE__ ) . '/cmb2/init.php' ) ) {
// 	require_once dirname( __FILE__ ) . '/cmb2/init.php';
// } elseif ( file_exists( dirname( __FILE__ ) . '/CMB2/init.php' ) ) {
// 	require_once dirname( __FILE__ ) . '/CMB2/init.php';
// }

/**
 * Conditionally displays a metabox when used as a callback in the 'show_on_cb' cmb2_box parameter
 *
 * @param  CMB2 object $cmb CMB2 object
 *
 * @return bool             True if metabox should show
 */
function style_show_if_front_page( $cmb ) {
	// Don't show this metabox if it's not the front page template
	if ( $cmb->object_id !== get_option( 'page_on_front' ) ) {
		return false;
	}
	return true;
}

/**
 * Conditionally displays a field when used as a callback in the 'show_on_cb' field parameter
 *
 * @param  CMB2_Field object $field Field object
 *
 * @return bool                     True if metabox should show
 */
function style_hide_if_no_cats( $field ) {
	// Don't show this field if not in the cats category
	if ( ! has_tag( 'cats', $field->object_id ) ) {
		return false;
	}
	return true;
}

/**
 * Conditionally displays a message if the $post_id is 2
 *
 * @param  array             $field_args Array of field parameters
 * @param  CMB2_Field object $field      Field object
 */
function style_before_row_if_2( $field_args, $field ) {
	if ( 2 == $field->object_id ) {
		echo '<p>Testing <b>"before_row"</b> parameter (on $post_id 2)</p>';
	} else {
		echo '<p>Testing <b>"before_row"</b> parameter (<b>NOT</b> on $post_id 2)</p>';
	}
}



add_action( 'cmb2_render_taxonomy_multilevel', 'cmb2_render_taxonomy_multilevel', 10, 5 );

function cmb2_render_taxonomy_multilevel($field, $escaped_value, $object_id, $object_type, $field_type_object) {

		$names       = $field_type_object->get_object_terms();
		$saved_terms = is_wp_error( $names ) || empty( $names )
			? $field_type_object->field->args( 'default' )
			: wp_list_pluck( $names, 'slug' );
		$terms       = get_terms( $field_type_object->field->args( 'taxonomy' ), array( 'orderby' => 'term_group','hide_empty' => 0 ));
		$name        = $field_type_object->_name() . '[]';
		$options     = ''; $i = 1;

		if ( ! $terms ) {
			$options .= sprintf( '<li><label>%s</label></li>', esc_html( $field_type_object->_text( 'no_terms_text', __( 'No terms', 'cmb2' ) ) ) );
		} else {

			foreach ( $terms as $term ) {
				$class = $term->parent > 0 ? 'child' : 'parent';
				$args = array(
					'value' => $term->slug,
					'label' => $term->name,
					'type' => 'checkbox',
					'name' => $name,
					'class' => $class,

				);

				if ( is_array( $saved_terms ) && in_array( $term->slug, $saved_terms ) ) {
					$args['checked'] = 'checked';
				}
				$options .= $field_type_object->list_input( $args, $i );
				$i++;
			}
		}

		$classes = false === $field_type_object->field->args( 'select_all_button' )
			? 'cmb2-checkbox-list no-select-all cmb2-list'
			: 'cmb2-checkbox-list cmb2-list';

		return $field_type_object->radio( array( 'class' => $classes, 'options' => $options ), 'taxonomy_multilevel' );
}


function prefix_set_field_data_attr( $args, $field) {
    $field->args['attributes']['data-postid'] = $i;
}


//By Daniele Mte90 Scasciafratte
// render multicheck-posttype
add_action( 'cmb2_render_multicheck_posttype', 'cmb_render_multicheck_posttype', 10, 5 );

function cmb_render_multicheck_posttype( $field, $escaped_value, $object_id, $object_type, $field_type_object ) {
    $cpts = get_post_types();
    unset( $cpts[ 'nav_menu_item' ] );
    unset( $cpts[ 'revision' ] );
    $options = '';
    $i = 1;
    $values = (array) $escaped_value;

    if ( $cpts ) {
        foreach ( $cpts as $cpt ) {
            $args = array(
                'value' => $cpt,
                'label' => $cpt,
                'type' => 'checkbox',
                'name' => $field->args['_name'] . '[]',
            );

            if ( in_array( $cpt, $values ) ) {
                $args[ 'checked' ] = 'checked';
            }
            $options .= $field_type_object->list_input( $args, $i );
            $i++;
        }
    }

    $classes = false === $field->args( 'select_all_button' ) ? 'cmb2-checkbox-list no-select-all cmb2-list' : 'cmb2-checkbox-list cmb2-list';
    echo $field_type_object->radio( array( 'class' => $classes, 'options' => $options ), 'multicheck_posttype' );
}


function cmb2_get_term_options( $taxonomy = 'accessories', $args = array() ) {

    $args['taxonomy'] = $taxonomy;
    // $defaults = array( 'taxonomy' => 'category' );
    $args = wp_parse_args( $args, array( 'taxonomy' => 'category' ) );

    $taxonomy = $args['taxonomy'];

    $terms = (array) get_terms( $taxonomy, $args );

    // Initate an empty array
    $term_options = array();
    if ( ! empty( $terms ) ) {
        foreach ( $terms as $term ) {
            $term_options[ $term->term_id ] = $term->name;
        }
    }

    return $term_options;
}





add_action( 'cmb2_init', 'style_register_demo_metabox' );
/**
 * Hook in and add a demo metabox. Can only happen on the 'cmb2_init' hook.
 */
function style_register_demo_metabox() {

	// Start with an underscore to hide fields from custom fields list
	$prefix = '_style_demo_';

	/**
	 * Sample metabox to demonstrate each field type included
	 */
	$cmb_demo = new_cmb2_box( array(
		'id'            => $prefix . 'metabox',
		'title'         => __( 'Test Metabox', 'cmb2' ),
		'object_types'  => array( 'catalog', ), // Post type
		// 'show_on_cb' => 'style_show_if_front_page', // function should return a bool value
		// 'context'    => 'normal',
		// 'priority'   => 'high',
		// 'show_names' => true, // Show field names on the left
		// 'cmb_styles' => false, // false to disable the CMB stylesheet
		// 'closed'     => true, // true to keep the metabox closed by default
	) );

	// $cmb_demo->add_field( array(
	// 	'name'     => __( 'Выберете совместимые комплектующие', 'cmb2' ),
	// 	// 'desc'     => __( 'field description (optional)', 'cmb2' ),
	// 	'id'       => $prefix . 'taxonomy_accessories',
	// 	'type'     => 'taxonomy_multilevel',
	// 	'taxonomy' => 'accessories', // Taxonomy Slug
	// ) );

	$cmb_demo->add_field( array(
    'name'    => 'Выберете совместимые комплектующие',
    // 'desc'    => 'Set a featured term for this post.',
    'id'      => $prefix . 'taxonomy_accessories',
    'type'    => 'multicheck',
    'options' => cmb2_get_term_options('accessories',array( 'orderby' => 'term_group','hide_empty' => 0 )),
) );

	$cmb_demo->add_field( array(
		'name'     => __( 'Выберете совместимые материалы' ),
		// 'desc'     => __( 'field description (optional)', 'cmb2' ),
		'id'       => $prefix . 'materials',
		'type'     => 'multicheck',
		// 'taxonomy' => 'materials', // Taxonomy Slug
		'options' => cmb2_get_term_options('materials',array( 'orderby' => 'term_group','hide_empty' => 0 )),
		'before'  => 'prefix_set_field_data_attr',
		// 'inline'  => true, // Toggles display to inline
	) );



	// $cmb_demo->add_field( array(
	// 	'name'       => __( 'Test Text', 'cmb2' ),
	// 	'desc'       => __( 'field description (optional)', 'cmb2' ),
	// 	'id'         => $prefix . 'text',
	// 	'type'       => 'text',
	// 	'show_on_cb' => 'style_hide_if_no_cats', // function should return a bool value
	// 	// 'sanitization_cb' => 'my_custom_sanitization', // custom sanitization callback parameter
	// 	// 'escape_cb'       => 'my_custom_escaping',  // custom escaping callback parameter
	// 	// 'on_front'        => false, // Optionally designate a field to wp-admin only
	// 	// 'repeatable'      => true,
	// ) );

	// $cmb_demo->add_field( array(
	// 	'name' => __( 'Test Text Small', 'cmb2' ),
	// 	'desc' => __( 'field description (optional)', 'cmb2' ),
	// 	'id'   => $prefix . 'textsmall',
	// 	'type' => 'text_small',
	// 	// 'repeatable' => true,
	// ) );

	// $cmb_demo->add_field( array(
	// 	'name' => __( 'Test Text Medium', 'cmb2' ),
	// 	'desc' => __( 'field description (optional)', 'cmb2' ),
	// 	'id'   => $prefix . 'textmedium',
	// 	'type' => 'text_medium',
	// 	// 'repeatable' => true,
	// ) );

	// $cmb_demo->add_field( array(
	// 	'name' => __( 'Website URL', 'cmb2' ),
	// 	'desc' => __( 'field description (optional)', 'cmb2' ),
	// 	'id'   => $prefix . 'url',
	// 	'type' => 'text_url',
	// 	// 'protocols' => array('http', 'https', 'ftp', 'ftps', 'mailto', 'news', 'irc', 'gopher', 'nntp', 'feed', 'telnet'), // Array of allowed protocols
	// 	// 'repeatable' => true,
	// ) );

	// $cmb_demo->add_field( array(
	// 	'name' => __( 'Test Text Email', 'cmb2' ),
	// 	'desc' => __( 'field description (optional)', 'cmb2' ),
	// 	'id'   => $prefix . 'email',
	// 	'type' => 'text_email',
	// 	// 'repeatable' => true,
	// ) );

	// $cmb_demo->add_field( array(
	// 	'name' => __( 'Test Time', 'cmb2' ),
	// 	'desc' => __( 'field description (optional)', 'cmb2' ),
	// 	'id'   => $prefix . 'time',
	// 	'type' => 'text_time',
	// ) );

	// $cmb_demo->add_field( array(
	// 	'name' => __( 'Time zone', 'cmb2' ),
	// 	'desc' => __( 'Time zone', 'cmb2' ),
	// 	'id'   => $prefix . 'timezone',
	// 	'type' => 'select_timezone',
	// ) );

	// $cmb_demo->add_field( array(
	// 	'name' => __( 'Test Date Picker', 'cmb2' ),
	// 	'desc' => __( 'field description (optional)', 'cmb2' ),
	// 	'id'   => $prefix . 'textdate',
	// 	'type' => 'text_date',
	// ) );

	// $cmb_demo->add_field( array(
	// 	'name' => __( 'Test Date Picker (UNIX timestamp)', 'cmb2' ),
	// 	'desc' => __( 'field description (optional)', 'cmb2' ),
	// 	'id'   => $prefix . 'textdate_timestamp',
	// 	'type' => 'text_date_timestamp',
	// 	// 'timezone_meta_key' => $prefix . 'timezone', // Optionally make this field honor the timezone selected in the select_timezone specified above
	// ) );

	// $cmb_demo->add_field( array(
	// 	'name' => __( 'Test Date/Time Picker Combo (UNIX timestamp)', 'cmb2' ),
	// 	'desc' => __( 'field description (optional)', 'cmb2' ),
	// 	'id'   => $prefix . 'datetime_timestamp',
	// 	'type' => 'text_datetime_timestamp',
	// ) );

	// // This text_datetime_timestamp_timezone field type
	// // is only compatible with PHP versions 5.3 or above.
	// // Feel free to uncomment and use if your server meets the requirement
	// // $cmb_demo->add_field( array(
	// // 	'name' => __( 'Test Date/Time Picker/Time zone Combo (serialized DateTime object)', 'cmb2' ),
	// // 	'desc' => __( 'field description (optional)', 'cmb2' ),
	// // 	'id'   => $prefix . 'datetime_timestamp_timezone',
	// // 	'type' => 'text_datetime_timestamp_timezone',
	// // ) );

	// $cmb_demo->add_field( array(
	// 	'name' => __( 'Test Money', 'cmb2' ),
	// 	'desc' => __( 'field description (optional)', 'cmb2' ),
	// 	'id'   => $prefix . 'textmoney',
	// 	'type' => 'text_money',
	// 	// 'before_field' => '£', // override '$' symbol if needed
	// 	// 'repeatable' => true,
	// ) );

	// $cmb_demo->add_field( array(
	// 	'name'    => __( 'Test Color Picker', 'cmb2' ),
	// 	'desc'    => __( 'field description (optional)', 'cmb2' ),
	// 	'id'      => $prefix . 'colorpicker',
	// 	'type'    => 'colorpicker',
	// 	'default' => '#ffffff',
	// ) );

	// $cmb_demo->add_field( array(
	// 	'name' => __( 'Test Text Area', 'cmb2' ),
	// 	'desc' => __( 'field description (optional)', 'cmb2' ),
	// 	'id'   => $prefix . 'textarea',
	// 	'type' => 'textarea',
	// ) );

	// $cmb_demo->add_field( array(
	// 	'name' => __( 'Test Text Area Small', 'cmb2' ),
	// 	'desc' => __( 'field description (optional)', 'cmb2' ),
	// 	'id'   => $prefix . 'textareasmall',
	// 	'type' => 'textarea_small',
	// ) );

	// $cmb_demo->add_field( array(
	// 	'name' => __( 'Test Text Area for Code', 'cmb2' ),
	// 	'desc' => __( 'field description (optional)', 'cmb2' ),
	// 	'id'   => $prefix . 'textarea_code',
	// 	'type' => 'textarea_code',
	// ) );

	// $cmb_demo->add_field( array(
	// 	'name' => __( 'Test Title Weeeee', 'cmb2' ),
	// 	'desc' => __( 'This is a title description', 'cmb2' ),
	// 	'id'   => $prefix . 'title',
	// 	'type' => 'title',
	// ) );

	// $cmb_demo->add_field( array(
	// 	'name'             => __( 'Test Select', 'cmb2' ),
	// 	'desc'             => __( 'field description (optional)', 'cmb2' ),
	// 	'id'               => $prefix . 'select',
	// 	'type'             => 'select',
	// 	'show_option_none' => true,
	// 	'options'          => array(
	// 		'standard' => __( 'Option One', 'cmb2' ),
	// 		'custom'   => __( 'Option Two', 'cmb2' ),
	// 		'none'     => __( 'Option Three', 'cmb2' ),
	// 	),
	// ) );

	// $cmb_demo->add_field( array(
	// 	'name'             => __( 'Test Radio inline', 'cmb2' ),
	// 	'desc'             => __( 'field description (optional)', 'cmb2' ),
	// 	'id'               => $prefix . 'radio_inline',
	// 	'type'             => 'radio_inline',
	// 	'show_option_none' => 'No Selection',
	// 	'options'          => array(
	// 		'standard' => __( 'Option One', 'cmb2' ),
	// 		'custom'   => __( 'Option Two', 'cmb2' ),
	// 		'none'     => __( 'Option Three', 'cmb2' ),
	// 	),
	// ) );

	// $cmb_demo->add_field( array(
	// 	'name'    => __( 'Test Radio', 'cmb2' ),
	// 	'desc'    => __( 'field description (optional)', 'cmb2' ),
	// 	'id'      => $prefix . 'radio',
	// 	'type'    => 'radio',
	// 	'options' => array(
	// 		'option1' => __( 'Option One', 'cmb2' ),
	// 		'option2' => __( 'Option Two', 'cmb2' ),
	// 		'option3' => __( 'Option Three', 'cmb2' ),
	// 	),
	// ) );

	// $cmb_demo->add_field( array(
	// 	'name'     => __( 'Test Taxonomy Radio', 'cmb2' ),
	// 	'desc'     => __( 'field description (optional)', 'cmb2' ),
	// 	'id'       => $prefix . 'text_taxonomy_radio',
	// 	'type'     => 'taxonomy_radio',
	// 	'taxonomy' => 'category', // Taxonomy Slug
	// 	// 'inline'  => true, // Toggles display to inline
	// ) );

	// $cmb_demo->add_field( array(
	// 	'name'     => __( 'Test Taxonomy Select', 'cmb2' ),
	// 	'desc'     => __( 'field description (optional)', 'cmb2' ),
	// 	'id'       => $prefix . 'taxonomy_select',
	// 	'type'     => 'taxonomy_select',
	// 	'taxonomy' => 'accessories', // Taxonomy Slug
	// ) );



	// $cmb_demo->add_field( array(
	// 	'name' => __( 'Test Checkbox', 'cmb2' ),
	// 	'desc' => __( 'field description (optional)', 'cmb2' ),
	// 	'id'   => $prefix . 'checkbox',
	// 	'type' => 'checkbox',
	// ) );

	// $cmb_demo->add_field( array(
	// 	'name'    => __( 'Test Multi Checkbox', 'cmb2' ),
	// 	'desc'    => __( 'field description (optional)', 'cmb2' ),
	// 	'id'      => $prefix . 'multicheckbox',
	// 	'type'    => 'multicheck',
	// 	// 'multiple' => true, // Store values in individual rows
	// 	'options' => array(
	// 		'check1' => __( 'Check One', 'cmb2' ),
	// 		'check2' => __( 'Check Two', 'cmb2' ),
	// 		'check3' => __( 'Check Three', 'cmb2' ),
	// 	),
	// 	// 'inline'  => true, // Toggles display to inline
	// ) );

	// $cmb_demo->add_field( array(
	// 	'name'    => __( 'Test wysiwyg', 'cmb2' ),
	// 	'desc'    => __( 'field description (optional)', 'cmb2' ),
	// 	'id'      => $prefix . 'wysiwyg',
	// 	'type'    => 'wysiwyg',
	// 	'options' => array( 'textarea_rows' => 5, ),
	// ) );

	// $cmb_demo->add_field( array(
	// 	'name' => __( 'Test Image', 'cmb2' ),
	// 	'desc' => __( 'Upload an image or enter a URL.', 'cmb2' ),
	// 	'id'   => $prefix . 'image',
	// 	'type' => 'file',
	// ) );

	// $cmb_demo->add_field( array(
	// 	'name'         => __( 'Multiple Files', 'cmb2' ),
	// 	'desc'         => __( 'Upload or add multiple images/attachments.', 'cmb2' ),
	// 	'id'           => $prefix . 'file_list',
	// 	'type'         => 'file_list',
	// 	'preview_size' => array( 100, 100 ), // Default: array( 50, 50 )
	// ) );

	// $cmb_demo->add_field( array(
	// 	'name' => __( 'oEmbed', 'cmb2' ),
	// 	'desc' => __( 'Enter a youtube, twitter, or instagram URL. Supports services listed at <a href="http://codex.wordpress.org/Embeds">http://codex.wordpress.org/Embeds</a>.', 'cmb2' ),
	// 	'id'   => $prefix . 'embed',
	// 	'type' => 'oembed',
	// ) );

	// $cmb_demo->add_field( array(
	// 	'name'         => 'Testing Field Parameters',
	// 	'id'           => $prefix . 'parameters',
	// 	'type'         => 'text',
	// 	'before_row'   => 'style_before_row_if_2', // callback
	// 	'before'       => '<p>Testing <b>"before"</b> parameter</p>',
	// 	'before_field' => '<p>Testing <b>"before_field"</b> parameter</p>',
	// 	'after_field'  => '<p>Testing <b>"after_field"</b> parameter</p>',
	// 	'after'        => '<p>Testing <b>"after"</b> parameter</p>',
	// 	'after_row'    => '<p>Testing <b>"after_row"</b> parameter</p>',
	// ) );

}

// add_action( 'cmb2_init', 'style_register_about_page_metabox' );
// /**
//  * Hook in and add a metabox that only appears on the 'About' page
//  */
// function style_register_about_page_metabox() {

// 	// Start with an underscore to hide fields from custom fields list
// 	$prefix = '_style_about_';

// 	/**
// 	 * Metabox to be displayed on a single page ID
// 	 */
// 	$cmb_about_page = new_cmb2_box( array(
// 		'id'           => $prefix . 'metabox',
// 		'title'        => __( 'About Page Metabox', 'cmb2' ),
// 		'object_types' => array( 'catalog', ), // Post type
// 		'context'      => 'normal',
// 		'priority'     => 'high',
// 		'show_names'   => true, // Show field names on the left
// 		'show_on'      => array( 'id' => array( 2, ) ), // Specific post IDs to display this metabox
// 	) );

// 	$cmb_about_page->add_field( array(
// 		'name' => __( 'Test Text', 'cmb2' ),
// 		'desc' => __( 'field description (optional)', 'cmb2' ),
// 		'id'   => $prefix . 'text',
// 		'type' => 'text',
// 	) );

// }

add_action( 'cmb2_init', 'style_register_repeatable_group_field_metabox' );
/**
 * Hook in and add a metabox to demonstrate repeatable grouped fields
 */
function style_register_repeatable_group_field_metabox() {

	// Start with an underscore to hide fields from custom fields list
	$prefix = '_style_group_';

	/**
	 * Repeatable Field Groups
	 */
	$cmb_group = new_cmb2_box( array(
		'id'           => $prefix . 'metabox',
		'title'        => __( 'Комплектации' ),
		'object_types' => array( 'catalog', ),
	) );

	// $group_field_id is the field id string, so in this case: $prefix . 'demo'
	$group_field_id = $cmb_group->add_field( array(
		'id'          => $prefix . 'demo',
		'type'        => 'group',
		'options'     => array(
			'group_title'   => __( 'Комплектация {#}' ), // {#} gets replaced by row number
			'add_button'    => __( 'Добавить еще' ),
			'remove_button' => __( 'Удалить комплектацию' ),
			'sortable'      => true, // beta
			// 'closed'     => true, // true to have the groups closed by default
		),
	) );

	$cmb_group->add_group_field( $group_field_id, array(
		'name' => __( 'Фото комплектации' ),
		'id'   => 'image',
		'type' => 'file',
	) );

	$cmb_group->add_group_field( $group_field_id, array(
		'name'        => __( 'В этой комплектации:' ),
		// 'description' => __( 'Write a short description for this entry', 'cmb2' ),
		'id'          => 'description',
		'type'        => 'textarea',
	) );

}


// add_action( 'cmb2_init', 'style_register_user_profile_metabox' );
// *
//  * Hook in and add a metabox to add fields to the user profile pages

// function style_register_user_profile_metabox() {

// 	// Start with an underscore to hide fields from custom fields list
// 	$prefix = '_style_user_';

// 	/**
// 	 * Metabox for the user profile screen
// 	 */
// 	$cmb_user = new_cmb2_box( array(
// 		'id'               => $prefix . 'edit',
// 		'title'            => __( 'User Profile Metabox', 'cmb2' ),
// 		'object_types'     => array( 'user' ), // Tells CMB2 to use user_meta vs post_meta
// 		'show_names'       => true,
// 		'new_user_section' => 'add-new-user', // where form will show on new user page. 'add-existing-user' is only other valid option.
// 	) );

// 	$cmb_user->add_field( array(
// 		'name'     => __( 'Extra Info', 'cmb2' ),
// 		'desc'     => __( 'field description (optional)', 'cmb2' ),
// 		'id'       => $prefix . 'extra_info',
// 		'type'     => 'title',
// 		'on_front' => false,
// 	) );

// 	$cmb_user->add_field( array(
// 		'name'    => __( 'Avatar', 'cmb2' ),
// 		'desc'    => __( 'field description (optional)', 'cmb2' ),
// 		'id'      => $prefix . 'avatar',
// 		'type'    => 'file',
// 	) );

// 	$cmb_user->add_field( array(
// 		'name' => __( 'Facebook URL', 'cmb2' ),
// 		'desc' => __( 'field description (optional)', 'cmb2' ),
// 		'id'   => $prefix . 'facebookurl',
// 		'type' => 'text_url',
// 	) );

// 	$cmb_user->add_field( array(
// 		'name' => __( 'Twitter URL', 'cmb2' ),
// 		'desc' => __( 'field description (optional)', 'cmb2' ),
// 		'id'   => $prefix . 'twitterurl',
// 		'type' => 'text_url',
// 	) );

// 	$cmb_user->add_field( array(
// 		'name' => __( 'Google+ URL', 'cmb2' ),
// 		'desc' => __( 'field description (optional)', 'cmb2' ),
// 		'id'   => $prefix . 'googleplusurl',
// 		'type' => 'text_url',
// 	) );

// 	$cmb_user->add_field( array(
// 		'name' => __( 'Linkedin URL', 'cmb2' ),
// 		'desc' => __( 'field description (optional)', 'cmb2' ),
// 		'id'   => $prefix . 'linkedinurl',
// 		'type' => 'text_url',
// 	) );

// 	$cmb_user->add_field( array(
// 		'name' => __( 'User Field', 'cmb2' ),
// 		'desc' => __( 'field description (optional)', 'cmb2' ),
// 		'id'   => $prefix . 'user_text_field',
// 		'type' => 'text',
// 	) );

// }

// add_action( 'cmb2_init', 'style_register_theme_options_metabox' );
// /**
//  * Hook in and register a metabox to handle a theme options page
//  */
// function style_register_theme_options_metabox() {

// 	// Start with an underscore to hide fields from custom fields list
// 	$option_key = '_style_theme_options';

// 	/**
// 	 * Metabox for an options page. Will not be added automatically, but needs to be called with
// 	 * the `cmb2_metabox_form` helper function. See wiki for more info.
// 	 */
// 	$cmb_options = new_cmb2_box( array(
// 		'id'      => $option_key . 'page',
// 		'title'   => __( 'Theme Options Metabox', 'cmb2' ),
// 		'hookup'  => false, // Do not need the normal user/post hookup
// 		'show_on' => array(
// 			// These are important, don't remove
// 			'key'   => 'options-page',
// 			'value' => array( $option_key )
// 		),
// 	) );

// 	/**
// 	 * Options fields ids only need
// 	 * to be unique within this option group.
// 	 * Prefix is not needed.
// 	 */
// 	$cmb_options->add_field( array(
// 		'name'    => __( 'Site Background Color', 'cmb2' ),
// 		'desc'    => __( 'field description (optional)', 'cmb2' ),
// 		'id'      => 'bg_color',
// 		'type'    => 'colorpicker',
// 		'default' => '#ffffff',
// 	) );

// }