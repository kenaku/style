<?php


// Register Custom Post Type
function accessories_post_type() {

	$labels = array(
		'name'                => 'Комплектующие',
		'singular_name'       => 'Комплектующее',
		'menu_name'           => 'Комплектующие',
		'name_admin_bar'      => 'Комплектующие',
		'parent_item_colon'   => 'Parent Item:',
		'all_items'           => 'Все комплектующие',
		'add_new_item'        => 'Добавить комплектующее',
		'add_new'             => 'Добавить',
		'new_item'            => 'Новая позиция',
		'edit_item'           => 'Редактировать комплектующее',
		'update_item'         => 'Обновить комплектующее',
		'view_item'           => 'Просмотреть комплектующее',
		'search_items'        => 'Найти комплектующее',
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
		'label'               => 'Комплектующее',
		'description'         => 'Комплектующие',
		'labels'              => $labels,
		'supports'            => array( 'title', 'thumbnail' ),
		'taxonomies'          => array( 'accessories' ),
		'hierarchical'        => false,
		'public'              => false,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'menu_position'       => 5,
		'menu_icon'           => 'dashicons-image-filter',
		'show_in_admin_bar'   => true,
		'show_in_nav_menus'   => true,
		'can_export'          => true,
		'has_archive'         => '',
		'exclude_from_search' => true,
		'publicly_queryable'  => false,
		'rewrite'             => $rewrite,
		'capability_type'     => 'page',
	);
	register_post_type( 'accessories', $args );

}
add_action( 'init', 'accessories_post_type', 0 );


// Register Custom Taxonomy
function accessories_category() {

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
	register_taxonomy( 'accessories', array( 'accessories' ), $args );

}
add_action( 'init', 'accessories_category', 0 );

function get_accessories_connections($accessories_raw) {
	$accessories = array();
	foreach ($accessories_raw as $accessory) {
		$thumb = wp_get_attachment_image_src( get_post_thumbnail_id( $accessory->ID ), 'medium' );
		$terms = get_the_terms($accessory, 'accessories' );

		if($terms[0]->parent == 0){
			$accessories[$terms[0]->term_id] = array(
				'cat_id' => $terms[0]->term_id,
				'cat_name' => $terms[0]->name,
			);
			$accessories[$terms[0]->term_id][items][] = array(
				'name' => $accessory->post_title,
				'thumb' => $thumb[0],
			);
		} else {
			$parent = get_term_by( 'id', $terms[0]->parent , 'accessories' );
	  	$accessories[$parent->term_id] = array(
				'cat_id' => $parent->term_id,
				'cat_name' => $parent->name,
			);
			$accessories[$parent->term_id][items][] = array(
				'name' => $accessory->post_title,
				'thumb' => $thumb[0],
				'category' => $terms[0]->name
			);
		}
	}
		// print "<pre>"; print_r($accessories); print "</pre>";
	return $accessories;
}

// function get_accessories_connections($accessories_raw) {
// 	$accessories_cats = array();
// 	foreach ($accessories_raw as $accessory) {
// 		$terms = get_the_terms($accessory, 'accessories' );
// 		if($terms[0]->parent == 0){
// 			$accessories_cats[$terms[0]->term_id] = array(
// 				'id' => $terms[0]->term_id,
// 				'name' => $terms[0]->name,
// 			);
// 		} else {
// 			$parent = get_term_by( 'id', $terms[0]->parent , 'accessories' );
// 	  	$accessories_cats[$parent->term_id] = array(
// 				'id' => $parent->term_id,
// 				'name' => $parent->name,
// 			);
// 	  	$accessories_cats[$parent->term_id]['sub_cat'] = array(
// 				'id' => $terms[0]->term_id,
// 				'name' => $terms[0]->name,
// 			);
// 		}
// 	}
// 		print "<pre>"; print_r($accessories_cats); print "</pre>";
// 	// return $accessories_raw;
// }

?>
