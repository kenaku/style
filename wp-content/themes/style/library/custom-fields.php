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
	) );

	$cmb_demo->add_field( array(
		'name'     => __( 'Выберете совместимые материалы' ),
		'id'       => $prefix . 'materials',
		'type'     => 'multicheck',
		'options' => cmb2_get_term_options('materials',array( 'orderby' => 'term_group','hide_empty' => 0 )),
		'before'  => 'prefix_set_field_data_attr',
	) );


}

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

