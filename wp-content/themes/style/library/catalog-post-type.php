<?php

global $wp_rewrite;
$projet_structure = '/%catalog_term%';
$wp_rewrite->add_rewrite_tag("%catalog_term%", '([^/]+)', "catalog=");
$wp_rewrite->add_permastruct('catalog', $projet_structure, false);

// Register Custom Post Type
add_action( 'init', 'catalog_post_type' );

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
		'slug' => 'catalog/%catalog_term%',
		'with_front' => false,
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
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'rewrite'             => $rewrite,
		'capability_type'     => 'page',
	);
	register_post_type( 'catalog', $args );

}
function my_rewrite_flush() {
    catalog_post_type();
    flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'my_rewrite_flush' );

add_filter('post_type_link', 'catalog_permalink_structure', 10, 4);
function catalog_permalink_structure($post_link, $post, $leavename, $sample)
{
    if ( false !== strpos( $post_link, '%catalog_term%' ) ) {
        $event_type_term = get_the_terms( $post->ID, 'catalog' );
    		$post_link = str_replace( '%catalog_term%', array_pop( $event_type_term )->slug, $post_link);
    }
    return $post_link;
}

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
