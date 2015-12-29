<?php


// Register Custom Post Type
function materials_post_type() {

	$labels = array(
		'name'                => 'Материалы',
		'singular_name'       => 'Материал',
		'menu_name'           => 'Материалы',
		'name_admin_bar'      => 'Материалы',
		'parent_item_colon'   => 'Parent Item:',
		'all_items'           => 'Все материалы',
		'add_new_item'        => 'Добавить материал',
		'add_new'             => 'Добавить',
		'new_item'            => 'Новая позиция',
		'edit_item'           => 'Редактировать материал',
		'update_item'         => 'Обновить материал',
		'view_item'           => 'Просмотреть материал',
		'search_items'        => 'Найти материал',
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
		'label'               => 'Материал',
		'description'         => 'Материалы',
		'labels'              => $labels,
		'supports'            => array( 'title', 'thumbnail', ),
		'taxonomies'          => array( 'materials' ),
		'hierarchical'        => false,
		'public'              => false,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'menu_position'       => 5,
		'menu_icon'           => 'dashicons-art',
		'show_in_admin_bar'   => true,
		'show_in_nav_menus'   => true,
		'can_export'          => true,
		'has_archive'         => '',
		'exclude_from_search' => true,
		'publicly_queryable'  => false,
		'rewrite'             => $rewrite,
		'capability_type'     => 'page',
	);
	register_post_type( 'materials', $args );

}
add_action( 'init', 'materials_post_type', 0 );


// Register Custom Taxonomy
function materials_category() {

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
	register_taxonomy( 'materials', array( 'materials' ), $args );

}
add_action( 'init', 'materials_category', 0 );



function get_materials_connections($materials_raw){

	$materials_arr = array();
	$materials_cats = array();
	foreach ($materials_raw as $material) {
	 	$curr_cat = get_term_by('id', $material, 'materials');
		// print "<pre>"; print_r($material); print "</pre>";
	 	$items = [];
	 	$items_raw = get_posts(array(
		  'post_type' => 'materials',
		  'numberposts' => -1,
		  'orderby' => 'menu_order',
		  'order' => 'ASC',
		  'tax_query' => array(
		    array(
		      'taxonomy' => 'materials',
		      'field' => 'id',
		      'terms' => $curr_cat->term_id,
		    )
		  )
	  ));
	 	foreach ($items_raw as $item) {
			$thumb = wp_get_attachment_image_src( get_post_thumbnail_id($item->ID ), 'square' );
	 		// print_r($item);
	 		// print "<pre>"; print_r($item); print "</pre>";
	 		$items[] = array(
	 			'name' => $item->post_title,
	 			'cat' => $curr_cat->term_id,
	 			'thumb' => $thumb[0]
	 		);
	 	}

	 	$materials_arr[$curr_cat->parent][] = array(
				'id' => $curr_cat->term_id,
				'name' => $curr_cat->name,
				'slug' => $curr_cat->slug,
				'items' => $items
	 	);
	}

	foreach ($materials_arr as $materials_cat => $key) {
		$materials_top_cat_obj = get_term_by( 'id', $materials_cat , 'materials' );
		$materials_cats[] = array(
			'id' => $materials_cat,
			'name' => $materials_top_cat_obj->name,
			'sub_cat' => $materials_arr[$materials_cat],
		);
	}
	return $materials_cats;

}


?>
