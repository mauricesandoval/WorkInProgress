<?php
add_action( 'vc_before_init', 'voisen_vc_shortcodes' );
function voisen_get_allCategory(){
	$args = array(
		'type' => 'post',
		'child_of' => 0,
		'parent' => '',
		'orderby' => 'id',
		'order' => 'ASC',
		'hide_empty' => false,
		'hierarchical' => 1,
		'exclude' => '',
		'include' => '',
		'number' => '',
		'taxonomy' => 'product_cat', 
		'pad_counts' => false,
	);
	$categories = get_categories( $args );
	$product_categories_dropdown = array();
	voisen_getCategoryChildsFull( 0, 0, $categories, 0, $product_categories_dropdown );
	return $product_categories_dropdown;
}
function voisen_getCategoryChildsFull( $parent_id, $pos, $array, $level, &$dropdown ) {
	for ( $i = $pos; $i < count( $array ); $i ++ ) {
		if ( isset($array[ $i ]->category_parent) && $array[ $i ]->category_parent == $parent_id ) {
			$name = str_repeat( "- ", $level ) . $array[ $i ]->name;
			$value = $array[ $i ]->slug;
			$dropdown[] = array( 'label' => $name, 'value' => $value );
			voisen_getCategoryChildsFull( $array[ $i ]->term_id, $i, $array, $level + 1, $dropdown );
		}
	}
}
function voisen_vc_shortcodes() {
	vc_add_param( 'vc_row', array(
	         "type" => "checkbox",
	         "heading" => esc_html__("Full Width",'voisen'),
	         "param_name" => "fullwidth",
	         "value" => array(
	         				'Yes, please' => true
	         			)
	    ));
	//Brand logos
	vc_map( array(
		'name' => esc_html__( 'Brand Logos', 'voisen' ),
		'base' => 'ourbrands',
		'class' => '',
		'category' => esc_html__( 'Voisen Theme', 'voisen'),
		'params' => array(
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Title', 'voisen' ),
				'param_name' => 'title',
				'value' => '',
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Number of columns', 'voisen' ),
				'param_name' => 'colsnumber',
				'value' => array(
						'1'	=> '1',
						'2'	=> '2',
						'3'	=> '3',
						'4'	=> '4',
						'5'	=> '5',
						'6'	=> '6',
					),
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Number of rows', 'voisen' ),
				'param_name' => 'rows',
				'value' => array(
						'1'	=> '1',
						'2'	=> '2',
						'3'	=> '3',
						'4'	=> '4',
					),
				'description' => esc_html__( 'This option only apply for Carousel Stype.', 'voisen' )
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Style', 'voisen' ),
				'param_name' => 'style',
				'value' => array(
						esc_html__( 'Grid', 'voisen' )	 	=> 'grid',
						esc_html__( 'Carousel', 'voisen' ) 	=> 'carousel',
					),
			),
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Extra class name', 'voisen' ),
				'param_name' => 'el_class',
				'value' => '',
				'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'voisen' )
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Columns count desktop small', 'voisen' ),
				'param_name' => 'desksmall',
				'value' => array(
						'1'	=> '1',
						'2'	=> '2',
						'3'	=> '3',
						'4'	=> '4',
						'5'	=> '5',
					),
				'description' => esc_html__( 'This option only apply for Carousel Stype.', 'voisen' )
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Columns count tablet', 'voisen' ),
				'param_name' => 'tablet_count',
				'value' => array(
						'1'	=> '1',
						'2'	=> '2',
						'3'	=> '3',
						'4'	=> '4',
						'5'	=> '5',
					),
				'description' => esc_html__( 'This option only apply for Carousel Stype.', 'voisen' )
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Columns count tablet small', 'voisen' ),
				'param_name' => 'tabletsmall',
				'value' => array(
						'1'	=> '1',
						'2'	=> '2',
						'3'	=> '3',
						'4'	=> '4',
						'5'	=> '5',
					),
				'description' => esc_html__( 'This option only apply for Carousel Stype.', 'voisen' )
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Columns count mobile', 'voisen' ),
				'param_name' => 'mobile_count',
				'value' => array(
						'1'	=> '1',
						'2'	=> '2',
						'3'	=> '3',
						'4'	=> '4',
						'5'	=> '5',
					),
				'description' => esc_html__( 'This option only apply for Carousel Stype.', 'voisen' )
			),
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Margin', 'voisen' ),
				'param_name' => 'margin',
				'value' => '30',
				'description' => esc_html__( 'This option only apply for Carousel Stype.', 'voisen' )
			),
		)
	) );
	
	//Specify Products
	vc_map( array(
		'name' => esc_html__( 'Specify Products', 'voisen' ),
		'base' => 'specifyproducts',
		'class' => '',
		'category' => esc_html__( 'Voisen Theme', 'voisen'),
		'params' => array(
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Title', 'voisen' ),
				'param_name' => 'title',
				'value' => '',
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Type', 'voisen' ),
				'param_name' => 'type',
				'value' => array(
						esc_html__( 'Best Selling', 'voisen' )		=> 'best_selling',
						esc_html__( 'Featured Products', 'voisen' ) => 'featured_product',
						esc_html__( 'Top Rate', 'voisen' ) 			=> 'top_rate',
						esc_html__( 'Recent Products', 'voisen' ) 	=> 'recent_product',
						esc_html__( 'On Sale', 'voisen' ) 			=> 'on_sale',
						esc_html__( 'Recent Review', 'voisen' ) 	=> 'recent_review',
						esc_html__( 'Product Deals', 'voisen' )		 => 'deals'
					),
			),
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Number of products to show', 'voisen' ),
				'param_name' => 'number',
				'value' => '10',
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Style', 'voisen' ),
				'param_name' => 'style',
				'value' => array(
						esc_html__( 'Grid', 'voisen' )	 	=> 'grid',
						esc_html__( 'List', 'voisen' ) 		=> 'list',
						esc_html__( 'Carousel', 'voisen' ) 	=> 'carousel',
					),
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Number of rows', 'voisen' ),
				'param_name' => 'rows',
				'value' => array(
						'1'	=> '1',
						'2'	=> '2',
						'3'	=> '3',
						'4'	=> '4',
					),
				'description' => esc_html__( 'This option only apply for Carousel Stype.', 'voisen' )
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Columns', 'voisen' ),
				'param_name' => 'columns',
				'value' => array(
						'1'	=> '1',
						'2'	=> '2',
						'3'	=> '3',
						'4'	=> '4',
						'5'	=> '5',
					),
			),
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Extra class name', 'voisen' ),
				'param_name' => 'el_class',
				'value' => '',
				'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'voisen' )
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Columns count desktop small', 'voisen' ),
				'param_name' => 'desksmall',
				'value' => array(
						'1'	=> '1',
						'2'	=> '2',
						'3'	=> '3',
						'4'	=> '4',
						'5'	=> '5',
					),
				'description' => esc_html__( 'This option only apply for Carousel Stype.', 'voisen' )
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Columns count tablet', 'voisen' ),
				'param_name' => 'tablet_count',
				'value' => array(
						'1'	=> '1',
						'2'	=> '2',
						'3'	=> '3',
						'4'	=> '4',
						'5'	=> '5',
					),
				'description' => esc_html__( 'This option only apply for Carousel Stype.', 'voisen' )
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Columns count tablet small', 'voisen' ),
				'param_name' => 'tabletsmall',
				'value' => array(
						'1'	=> '1',
						'2'	=> '2',
						'3'	=> '3',
						'4'	=> '4',
						'5'	=> '5',
					),
				'description' => esc_html__( 'This option only apply for Carousel Stype.', 'voisen' )
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Columns count mobile', 'voisen' ),
				'param_name' => 'mobile_count',
				'value' => array(
						'1'	=> '1',
						'2'	=> '2',
						'3'	=> '3',
						'4'	=> '4',
						'5'	=> '5',
					),
				'description' => esc_html__( 'This option only apply for Carousel Stype.', 'voisen' )
			),
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Margin', 'voisen' ),
				'param_name' => 'margin',
				'value' => '30',
				'description' => esc_html__( 'This option only apply for Carousel Stype.', 'voisen' )
			),
		)
	) );
	//Products Category
	vc_map( array(
		'name' => esc_html__( 'Products Category', 'voisen' ),
		'base' => 'productscategory',
		'class' => '',
		'category' => esc_html__( 'Voisen Theme', 'voisen'),
		'params' => array(
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Title', 'voisen' ),
				'param_name' => 'title',
				'value' => '',
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Category', 'voisen' ),
				'param_name' => 'category',
				'value' => voisen_get_allCategory(),
			),
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Number of products to show', 'voisen' ),
				'param_name' => 'number',
				'value' => '10',
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Style', 'voisen' ),
				'param_name' => 'style',
				'value' => array(
						esc_html__( 'Grid', 'voisen' )	 	=> 'grid',
						esc_html__( 'List', 'voisen' ) 		=> 'list',
						esc_html__( 'Carousel', 'voisen' ) 	=> 'carousel',
					),
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Number of rows', 'voisen' ),
				'param_name' => 'rows',
				'value' => array(
						'1'	=> '1',
						'2'	=> '2',
						'3'	=> '3',
						'4'	=> '4',
					),
				'description' => esc_html__( 'This option only apply for Carousel Stype.', 'voisen' )
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Columns', 'voisen' ),
				'param_name' => 'columns',
				'value' => array(
						'1'	=> '1',
						'2'	=> '2',
						'3'	=> '3',
						'4'	=> '4',
						'5'	=> '5',
					),
			),
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Extra class name', 'voisen' ),
				'param_name' => 'el_class',
				'value' => '',
				'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'voisen' )
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Columns count desktop small', 'voisen' ),
				'param_name' => 'desksmall',
				'value' => array(
						'1'	=> '1',
						'2'	=> '2',
						'3'	=> '3',
						'4'	=> '4',
						'5'	=> '5',
					),
				'description' => esc_html__( 'This option only apply for Carousel Stype.', 'voisen' )
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Columns count tablet', 'voisen' ),
				'param_name' => 'tablet_count',
				'value' => array(
						'1'	=> '1',
						'2'	=> '2',
						'3'	=> '3',
						'4'	=> '4',
						'5'	=> '5',
					),
				'description' => esc_html__( 'This option only apply for Carousel Stype.', 'voisen' )
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Columns count tablet small', 'voisen' ),
				'param_name' => 'tabletsmall',
				'value' => array(
						'1'	=> '1',
						'2'	=> '2',
						'3'	=> '3',
						'4'	=> '4',
						'5'	=> '5',
					),
				'description' => esc_html__( 'This option only apply for Carousel Stype.', 'voisen' )
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Columns count mobile', 'voisen' ),
				'param_name' => 'mobile_count',
				'value' => array(
						'1'	=> '1',
						'2'	=> '2',
						'3'	=> '3',
						'4'	=> '4',
						'5'	=> '5',
					),
				'description' => esc_html__( 'This option only apply for Carousel Stype.', 'voisen' )
			),
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Margin', 'voisen' ),
				'param_name' => 'margin',
				'value' => '30',
				'description' => esc_html__( 'This option only apply for Carousel Stype.', 'voisen' )
			),
		)
	) );
	
	//Testimonials
	vc_map( array(
		'name' => esc_html__( 'Voisen Testimonials', 'voisen' ),
		'base' => 'testimonials',
		'class' => '',
		'category' => esc_html__( 'Voisen Theme', 'voisen'),
		'params' => array(
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Title', 'voisen' ),
				'param_name' => 'title',
				'value' => '',
			),
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Number of products to show', 'voisen' ),
				'param_name' => 'number',
				'value' => '10',
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Style', 'voisen' ),
				'param_name' => 'style',
				'value' => array(
						esc_html__( 'Carousel', 'voisen' ) 	=> 'carousel',
						esc_html__( 'List', 'voisen' ) 		=> 'list',
					),
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Columns', 'voisen' ),
				'param_name' => 'columns',
				'value' => array(
						'1'	=> '1',
						'2'	=> '2',
						'3'	=> '3',
						'4'	=> '4',
						'5'	=> '5',
					),
			),
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Extra class name', 'voisen' ),
				'param_name' => 'el_class',
				'value' => '',
				'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'voisen' )
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Columns count desktop small', 'voisen' ),
				'param_name' => 'desksmall',
				'value' => array(
						'1'	=> '1',
						'2'	=> '2',
						'3'	=> '3',
						'4'	=> '4',
						'5'	=> '5',
					),
				'description' => esc_html__( 'This option only apply for Carousel Stype.', 'voisen' )
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Columns count tablet', 'voisen' ),
				'param_name' => 'tablet_count',
				'value' => array(
						'1'	=> '1',
						'2'	=> '2',
						'3'	=> '3',
						'4'	=> '4',
						'5'	=> '5',
					),
				'description' => esc_html__( 'This option only apply for Carousel Stype.', 'voisen' )
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Columns count tablet small', 'voisen' ),
				'param_name' => 'tabletsmall',
				'value' => array(
						'1'	=> '1',
						'2'	=> '2',
						'3'	=> '3',
						'4'	=> '4',
						'5'	=> '5',
					),
				'description' => esc_html__( 'This option only apply for Carousel Stype.', 'voisen' )
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Columns count mobile', 'voisen' ),
				'param_name' => 'mobile_count',
				'value' => array(
						'1'	=> '1',
						'2'	=> '2',
						'3'	=> '3',
						'4'	=> '4',
						'5'	=> '5',
					),
				'description' => esc_html__( 'This option only apply for Carousel Stype.', 'voisen' )
			),
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Margin', 'voisen' ),
				'param_name' => 'margin',
				'value' => '30',
				'description' => esc_html__( 'This option only apply for Carousel Stype.', 'voisen' )
			),
		)
	) );
	
	//MailPoet Newsletter Form
	vc_map( array(
		'name' => esc_html__( 'Newsletter Form (MailPoet)', 'voisen' ),
		'base' => 'wysija_form',
		'class' => '',
		'category' => esc_html__( 'Voisen Theme', 'voisen'),
		'params' => array(
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Form ID', 'voisen' ),
				'param_name' => 'id',
				'value' => esc_html__( '', 'voisen' ),
				'description' => esc_html__( 'Enter form ID here', 'voisen' ),
			)
		)
	) );
	
	//Latest posts
	vc_map( array(
		'name' => esc_html__( 'Blog posts', 'voisen' ),
		'base' => 'blogposts',
		'class' => '',
		'category' => esc_html__( 'Voisen Theme', 'voisen'),
		'params' => array(
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Title', 'voisen' ),
				'param_name' => 'title',
				'value' => '',
			),
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Number of post to show', 'voisen' ),
				'param_name' => 'number',
				'value' => '5',
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Style', 'voisen' ),
				'param_name' => 'style',
				'value' => array(
						esc_html__( 'Carousel', 'voisen' ) 	=> 'carousel',
						esc_html__( 'List', 'voisen' ) 		=> 'list',
						esc_html__( 'Grid', 'voisen' )	 	=> 'grid',
					),
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Number of rows', 'voisen' ),
				'param_name' => 'rows',
				'value' => array(
						'1'	=> '1',
						'2'	=> '2',
						'3'	=> '3',
						'4'	=> '4',
					),
				'description' => esc_html__( 'This option only apply for Carousel Stype.', 'voisen' )
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Columns', 'voisen' ),
				'param_name' => 'columns',
				'value' => array(
						'1'	=> '1',
						'2'	=> '2',
						'3'	=> '3',
						'4'	=> '4',
						'5'	=> '5',
					),
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Image scale', 'voisen' ),
				'param_name' => 'image',
				'value' => array(
						esc_html__( 'Wide', 'voisen' )	=> 'wide',
						esc_html__( 'Square', 'voisen' ) => 'square',
					),
			),
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Excerpt length', 'voisen' ),
				'param_name' => 'length',
				'value' => '20',
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Order by', 'voisen' ),
				'param_name' => 'orderby',
				'value' => array(
						esc_html__( 'Posted Date', 'voisen' )	=> 'date',
						esc_html__( 'Ordering', 'voisen' ) => 'menu_order',
						esc_html__( 'Random', 'voisen' ) => 'rand',
					),
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Order Direction', 'voisen' ),
				'param_name' => 'order',
				'value' => array(
						esc_html__( 'Descending', 'voisen' )	=> 'DESC',
						esc_html__( 'Ascending', 'voisen' ) => 'ASC',
					),
			),
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Extra class name', 'voisen' ),
				'param_name' => 'el_class',
				'value' => '',
				'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'voisen' )
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Columns count desktop small', 'voisen' ),
				'param_name' => 'desksmall',
				'value' => array(
						'1'	=> '1',
						'2'	=> '2',
						'3'	=> '3',
						'4'	=> '4',
						'5'	=> '5',
					),
				'description' => esc_html__( 'This option only apply for Carousel Stype.', 'voisen' )
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Columns count tablet', 'voisen' ),
				'param_name' => 'tablet_count',
				'value' => array(
						'1'	=> '1',
						'2'	=> '2',
						'3'	=> '3',
						'4'	=> '4',
						'5'	=> '5',
					),
				'description' => esc_html__( 'This option only apply for Carousel Stype.', 'voisen' )
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Columns count tablet small', 'voisen' ),
				'param_name' => 'tabletsmall',
				'value' => array(
						'1'	=> '1',
						'2'	=> '2',
						'3'	=> '3',
						'4'	=> '4',
						'5'	=> '5',
					),
				'description' => esc_html__( 'This option only apply for Carousel Stype.', 'voisen' )
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Columns count mobile', 'voisen' ),
				'param_name' => 'mobile_count',
				'value' => array(
						'1'	=> '1',
						'2'	=> '2',
						'3'	=> '3',
						'4'	=> '4',
						'5'	=> '5',
					),
				'description' => esc_html__( 'This option only apply for Carousel Stype.', 'voisen' )
			),
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Margin', 'voisen' ),
				'param_name' => 'margin',
				'value' => '30',
				'description' => esc_html__( 'This option only apply for Carousel Stype.', 'voisen' )
			),
		)
	) );
}
// Filter to replace default css class names for vc_row shortcode and vc_column
add_filter( 'vc_shortcodes_css_class', 'custom_css_classes_for_vc_row_and_vc_column', 10, 2 );
function custom_css_classes_for_vc_row_and_vc_column( $class_string, $tag ) {
  $class_string = preg_replace( '/vc_col-sm-(\d{1,2})/', 'col-sm-$1', $class_string ); // This will replace "vc_col-sm-%" with "my_col-sm-%"
  $class_string = str_replace('vc_column_container', 'column_container', $class_string);
  return $class_string; // Important: you should always return modified or original $class_string
}
?>