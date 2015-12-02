<?php


// Register Custom Post Type
function slider_post_type() {

	$labels = array(
		'name'                => 'Слайдер',
		'singular_name'       => 'Слайд',
		'menu_name'           => 'Слайдер',
		'name_admin_bar'      => 'Слайдер',
		'parent_item_colon'   => 'Parent Item:',
		'all_items'           => 'Все слайды',
		'add_new_item'        => 'Добавить слайд',
		'add_new'             => 'Добавить',
		'new_item'            => 'Новая позиция',
		'edit_item'           => 'Редактировать слайд',
		'update_item'         => 'Обновить слайд',
		'view_item'           => 'Просмотреть слайд',
		'search_items'        => 'Найти слайд',
		'not_found'           => 'Не нашлось',
		'not_found_in_trash'  => 'В удаленных не нашлось',
	);
	$rewrite = array(
		'slug'                => '',
		'with_front'          => true,
		'pages'               => true,
		'feeds'               => true,
	);
	$args = array(
		'label'               => 'Слайд',
		'description'         => 'Слайдер',
		'labels'              => $labels,
		'supports'            => array( 'title', 'thumbnail' ),
		'hierarchical'        => false,
		'public'              => false,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'menu_position'       => 5,
		'menu_icon'           => 'dashicons-images-alt2',
		'show_in_admin_bar'   => true,
		'show_in_nav_menus'   => true,
		'can_export'          => true,
		'has_archive'         => '',
		'exclude_from_search' => true,
		'publicly_queryable'  => false,
		'rewrite'             => $rewrite,
		'capability_type'     => 'page',
	);
	register_post_type( 'slider', $args );

}
add_action( 'init', 'slider_post_type', 0 );

add_action( 'cmb2_admin_init', 'cmb2_sample_metaboxes' );
/**
 * Define the metabox and field configurations.
 */
function cmb2_sample_metaboxes() {

    // Start with an underscore to hide fields from custom fields list
    $prefix = '_slider_';

    /**
     * Initiate the metabox
     */
    $cmb = new_cmb2_box( array(
        'id'            => 'test_metabox',
        'title'         => __( 'Ссылка', 'cmb2' ),
        'object_types'  => array( 'slider', ), // Post type
        'context'       => 'normal',
        'priority'      => 'high',
        'show_names'    => false, // Show field names on the left
        // 'cmb_styles' => false, // false to disable the CMB stylesheet
        // 'closed'     => true, // Keep the metabox closed by default
    ) );

    // URL text field
    $cmb->add_field( array(
        'name' => __( 'Website URL', 'cmb2' ),
        'id'   => $prefix . 'url',
        'type' => 'text',
    ) );

}


?>
