<?php


// Register Custom Post Type
function catalog_post_type() {

	$labels = array(
		'name'                => 'Позиции',
		'singular_name'       => 'Позиция',
		'menu_name'           => 'Каталог',
		'name_admin_bar'      => 'Каталог',
		'parent_item_colon'   => 'Parent Item:',
		'all_items'           => 'Все позиции',
		'add_new_item'        => 'Добавить позицию',
		'add_new'             => 'Добавить',
		'new_item'            => 'Новая позиция',
		'edit_item'           => 'Редактировать позицию',
		'update_item'         => 'Обновить позицию',
		'view_item'           => 'Просмотреть позицию',
		'search_items'        => 'Найти позицию',
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
		'label'               => 'Позиция',
		'description'         => 'Каталог',
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor', 'thumbnail', 'revisions', 'custom-fields', ),
		'taxonomies'          => array( 'catalog' ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'menu_position'       => 5,
		'menu_icon'           => 'dashicons-cart',
		'show_in_admin_bar'   => true,
		'show_in_nav_menus'   => true,
		'can_export'          => true,
		'has_archive'         => '',
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'rewrite'             => $rewrite,
		'capability_type'     => 'page',
	);
	register_post_type( 'catalog', $args );

}
add_action( 'init', 'catalog_post_type', 0 );


// Register Custom Taxonomy
function catalog_category() {

	$labels = array(
		'name'                       => 'Категории',
		'singular_name'              => 'Категория',
		'menu_name'                  => 'Категории',
		'all_items'                  => 'Все категории',
		'parent_item'                => 'Текущая категория',
		'parent_item_colon'          => 'Родительская категория',
		'new_item_name'              => 'Новая категория',
		'add_new_item'               => 'Добавить новую категорию',
		'edit_item'                  => 'Редактировать категорию',
		'update_item'                => 'Обновить категорию',
		'view_item'                  => 'Просмотреть категорию',
		'separate_items_with_commas' => 'Разделять категории запятыми',
		'add_or_remove_items'        => 'Добавить или удалить категории',
		'choose_from_most_used'      => 'Выбрать из наиболее используемых',
		'popular_items'              => 'Популярные',
		'search_items'               => 'Искать',
		'not_found'                  => 'Не найдено',
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => false,
	);
	register_taxonomy( 'catalog', array( 'catalog' ), $args );

}
add_action( 'init', 'catalog_category', 0 );



?>