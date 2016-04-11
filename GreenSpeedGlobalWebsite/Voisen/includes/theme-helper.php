<?php
// create table to save user like
add_action( 'init', 'voisen_new_like_post_table' );
function voisen_new_like_post_table(){
	global $wpdb;
	$table_name = $wpdb->prefix.'voisen_user_like_ip';
	if($wpdb->get_var("SHOW TABLES LIKE '{$table_name}'") != $table_name) {
		 //table not in database. Create new table
		 $charset_collate = $wpdb->get_charset_collate();
		 $sql = "CREATE TABLE `{$table_name}` (
			  `post_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
			  `user_ip` VARCHAR(100) NOT NULL DEFAULT '',
			  PRIMARY KEY (`post_id`,`user_ip`)
		 ) {$charset_collate}";
		 require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		 dbDelta( $sql );
	}
}

// All Voisen theme helper functions in here
function voisen_woocommerce_query($type,$post_per_page=-1,$cat=''){
	$args = voisen_woocommerce_query_args($type,$post_per_page,$cat);
	return new WP_Query($args);
}
function voisen_vc_custom_css_class( $param_value, $prefix = '' ) {
	$css_class = preg_match( '/\s*\.([^\{]+)\s*\{\s*([^\}]+)\s*\}\s*/', $param_value ) ? $prefix . preg_replace( '/\s*\.([^\{]+)\s*\{\s*([^\}]+)\s*\}\s*/', '$1', $param_value ) : '';
	return $css_class;
}
function voisen_woocommerce_query_args($type,$post_per_page=-1,$cat=''){
	global $woocommerce;
    remove_filter( 'posts_clauses', array( $woocommerce->query, 'order_by_popularity_post_clauses' ) );
	remove_filter( 'posts_clauses', array( $woocommerce->query, 'order_by_rating_post_clauses' ) );
    $args = array(
        'post_type' => 'product',
        'posts_per_page' => $post_per_page,
        'post_status' => 'publish'
    );
    switch ($type) {
        case 'best_selling':
            $args['meta_key']='total_sales';
            $args['orderby']='meta_value_num';
            $args['ignore_sticky_posts']   = 1;
            $args['meta_query'] = array();
            $args['meta_query'][] = $woocommerce->query->stock_status_meta_query();
            $args['meta_query'][] = $woocommerce->query->visibility_meta_query();
            break;
        case 'featured_product':
            $args['ignore_sticky_posts']=1;
            $args['meta_query'] = array();
            $args['meta_query'][] = $woocommerce->query->stock_status_meta_query();
            $args['meta_query'][] = array(
                         'key' => '_featured',
                         'value' => 'yes'
                     );
            $query_args['meta_query'][] = $woocommerce->query->visibility_meta_query();
            break;
        case 'top_rate':
            add_filter( 'posts_clauses',  array( $woocommerce->query, 'order_by_rating_post_clauses' ) );
            $args['meta_query'] = array();
            $args['meta_query'][] = $woocommerce->query->stock_status_meta_query();
            $args['meta_query'][] = $woocommerce->query->visibility_meta_query();
            break;
        case 'recent_product':
            $args['meta_query'] = array();
            $args['meta_query'][] = $woocommerce->query->stock_status_meta_query();
            break;
        case 'on_sale':
            $args['meta_query'] = array();
            $args['meta_query'][] = $woocommerce->query->stock_status_meta_query();
            $args['meta_query'][] = $woocommerce->query->visibility_meta_query();
            $args['post__in'] = wc_get_product_ids_on_sale();
            break;
        case 'recent_review':
            if($post_per_page == -1) $_limit = 4;
            else $_limit = $post_per_page;
            global $wpdb;
            $query = "SELECT c.comment_post_ID FROM {$wpdb->posts} p, {$wpdb->comments} c WHERE p.ID = c.comment_post_ID AND c.comment_approved > 0 AND p.post_type = 'product' AND p.post_status = 'publish' AND p.comment_count > 0 ORDER BY c.comment_date ASC LIMIT 0, %s";
            $safe_sql = $wpdb->prepare( $query, $_limit );
			$results = $wpdb->get_results($safe_sql, OBJECT);
            $_pids = array();
            foreach ($results as $re) {
                $_pids[] = $re->comment_post_ID;
            }

            $args['meta_query'] = array();
            $args['meta_query'][] = $woocommerce->query->stock_status_meta_query();
            $args['meta_query'][] = $woocommerce->query->visibility_meta_query();
            $args['post__in'] = $_pids;
            break;
        case 'deals':
            $args['meta_query'] = array();
            $args['meta_query'][] = $woocommerce->query->stock_status_meta_query();
            $args['meta_query'][] = $woocommerce->query->visibility_meta_query();
            $args['meta_query'][] = array(
                                 'key' => '_sale_price_dates_to',
                                 'value' => '0',
                                 'compare' => '>');
            $args['post__in'] = wc_get_product_ids_on_sale();
            break;
    }

    if($cat!=''){
        $args['product_cat']= $cat;
    }
    return $args;
}
function voisen_make_id($length = 5){
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}
//Change excerpt length
add_filter( 'excerpt_length', 'voisen_excerpt_length', 999 );
function voisen_excerpt_length( $length ) {
	global $voisen_opt;
	if(isset($voisen_opt['excerpt_length'])){
		return $voisen_opt['excerpt_length'];
	}
	return 22;
}
function voisen_get_the_excerpt($post_id) {
	global $post;
	$temp = $post;
    $post = get_post( $post_id );
    setup_postdata( $post );
    $excerpt = get_the_excerpt();
    wp_reset_postdata();
    $post = $temp;
    return $excerpt;
}

//Add breadcrumbs
function voisen_breadcrumb() {
	global $post, $voisen_opt;
	
	$brseparator = '<span class="separator">/</span>';
	if (!is_home()) {
		echo '<div class="breadcrumbs">';
		
		echo '<a href="';
		echo esc_url( home_url( '/' ) );
		echo '">';
		echo esc_html__('Home', 'voisen');
		echo '</a>'.$brseparator;
		if (is_category() || is_single()) {
			the_category($brseparator);
			if (is_single()) {
				echo ''.$brseparator;
				the_title();
			}
		} elseif (is_page()) {
			if($post->post_parent){
				$anc = get_post_ancestors( $post->ID );
				$title = get_the_title();
				foreach ( $anc as $ancestor ) {
					$output = '<a href="'. esc_url(get_permalink($ancestor)).'" title="'.esc_attr(get_the_title($ancestor)).'">'. esc_html(get_the_title($ancestor)) .'</a>'.$brseparator;
				}
				echo wp_kses($output, array(
						'a'=>array(
							'href' => array(),
							'title' => array()
						),
						'span'=>array(
							'class'=>array()
						)
					)
				);
				echo '<span title="'.esc_attr($title).'"> '.esc_html($title).'</span>';
			} else {
				echo '<span> '. esc_html(get_the_title()).'</span>';
			}
		}
		elseif (is_tag()) {single_tag_title();}
		elseif (is_day()) {echo "<span>" . sprintf(esc_html__('Archive for %s', 'voisen'), the_time('F jS, Y')); echo '</span>';}
		elseif (is_month()) {echo "<span>" . sprintf(esc_html__('Archive for %s', 'voisen'), the_time('F, Y')); echo '</span>';}
		elseif (is_year()) {echo "<span>" . sprintf(esc_html__('Archive for %s', 'voisen'), the_time('Y')); echo '</span>';}
		elseif (is_author()) {echo "<span>" . esc_html__('Author Archive', 'voisen'); echo '</span>';}
		elseif (isset($_GET['paged']) && !empty($_GET['paged'])) {echo "<span>" . esc_html__('Blog Archives', 'voisen'); echo '</span>';}
		elseif (is_search()) {echo "<span>" . esc_html__('Search Results', 'voisen'); echo '</span>';}
		
		echo '</div>';
	} else {
		echo '<div class="breadcrumbs">';
		
		echo '<a href="';
		echo esc_url( home_url( '/' ) );
		echo '">';
		echo esc_html__('Home', 'voisen');
		echo '</a>'.$brseparator;
		
		if(isset($voisen_opt['blog_header_text']) && $voisen_opt['blog_header_text']!=""){
			echo esc_html($voisen_opt['blog_header_text']);
		} else {
			echo esc_html__('Blog', 'voisen');
		}
		
		echo '</div>';
	}
}
//social share products
function voisen_product_sharing() {
	global $voisen_opt;
	
	if(isset($_POST['data'])) { // for the quickview
		$postid = intval( $_POST['data'] );
	} else {
		$postid = get_the_ID();
	}
	
	$share_url = get_permalink( $postid );

	$large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id( $postid ), 'large' );
	$postimg = $large_image_url[0];
	$posttitle = get_the_title( $postid );
	?>
	<div class="widget widget_socialsharing_widget">
		<h3 class="widget-title"><?php if(isset($voisen_opt['product_share_title'])) { echo esc_html($voisen_opt['product_share_title']); } else { esc_html_e('Share this product', 'voisen'); } ?></h3>
		<ul class="social-icons">
			<li><a class="facebook social-icon" href="javascript:void(0)" onclick="javascript:window.open('<?php echo 'https://www.facebook.com/sharer/sharer.php?u='.$share_url; ?>', '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600'); return false;" title="<?php echo esc_attr__('Facebook', 'voisen'); ?>"><i class="fa fa-facebook"></i></a></li>
			<li><a class="twitter social-icon" href="javascript:void(0)" onclick="javascript:window.open('<?php echo 'https://twitter.com/home?status='.$posttitle.'&nbsp;'.$share_url; ?>', '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600'); return false;" title="<?php echo esc_attr__('Twitter', 'voisen'); ?>" ><i class="fa fa-twitter"></i></a></li>
			<li><a class="pinterest social-icon" href="javascript:void(0)" onclick="javascript:window.open('<?php echo 'https://pinterest.com/pin/create/button/?url='.$share_url.'&amp;media='.$postimg.'&amp;description='.$posttitle; ?>', '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600'); return false;" title="<?php echo esc_attr__('Pinterest', 'voisen'); ?>"><i class="fa fa-pinterest"></i></a></li>
			<li><a class="gplus social-icon" href="javascript:void(0)" onclick="javascript:window.open('<?php echo 'https://plus.google.com/share?url='.$share_url; ?>', '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600'); return false;" title="<?php echo esc_attr__('Google +', 'voisen'); ?>"><i class="fa fa-google-plus"></i></a></li>
			<li><a class="linkedin social-icon" href="javascript:void(0)" onclick="javascript:window.open('<?php echo 'https://www.linkedin.com/shareArticle?mini=true&amp;url='.$share_url.'&amp;title='.$posttitle; ?>', '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600'); return false;" title="<?php echo esc_attr__('LinkedIn', 'voisen'); ?>"><i class="fa fa-linkedin"></i></a></li>
		</ul>
	</div>
	<?php
}
//social share blog
function voisen_blog_sharing() {
	global $voisen_opt;
	
	if(isset($_POST['data'])) { // for the quickview
		$postid = intval( $_POST['data'] );
	} else {
		$postid = get_the_ID();
	}
	
	$share_url = get_permalink( $postid );

	$large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id( $postid ), 'large' );
	$postimg = $large_image_url[0];
	$posttitle = get_the_title( $postid );
	?>
	<div class="widget widget_socialsharing_widget">
		<ul class="social-icons">
			<li><a class="facebook social-icon" href="javascript:void(0)" onclick="javascript:window.open('<?php echo 'https://www.facebook.com/sharer/sharer.php?u='.$share_url; ?>', '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600'); return false;" title="<?php echo esc_attr__('Facebook', 'voisen'); ?>"><i class="fa fa-facebook"></i></a></li>
			<li><a class="twitter social-icon" href="javascript:void(0)" onclick="javascript:window.open('<?php echo 'https://twitter.com/home?status='.$posttitle.'&nbsp;'.$share_url; ?>', '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600'); return false;" title="<?php echo esc_attr__('Twitter', 'voisen'); ?>"><i class="fa fa-twitter"></i></a></li>
			<li><a class="pinterest social-icon" href="javascript:void(0)" onclick="javascript:window.open('<?php echo 'https://pinterest.com/pin/create/button/?url='.$share_url.'&amp;media='.$postimg.'&amp;description='.$posttitle; ?>', '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600'); return false;" title="<?php echo esc_attr__('Pinterest', 'voisen'); ?>"><i class="fa fa-pinterest"></i></a></li>
			<li><a class="gplus social-icon" href="javascript:void(0)" onclick="javascript:window.open('<?php echo 'https://plus.google.com/share?url='.$share_url; ?>', '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600'); return false;" title="<?php echo esc_attr__('Google +', 'voisen'); ?>"><i class="fa fa-google-plus"></i></a></li>
			<li><a class="linkedin social-icon" href="javascript:void(0)" onclick="javascript:window.open('<?php echo 'https://www.linkedin.com/shareArticle?mini=true&amp;url='.$share_url.'&amp;title='.$posttitle; ?>', '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600'); return false;" title="<?php echo esc_attr__('LinkedIn', 'voisen'); ?>"><i class="fa fa-linkedin"></i></a></li>
		</ul>
	</div>
	<?php
}
// function display number view of posts.
function voisen_get_post_viewed($postID){
    $count_key = 'post_views_count';
	delete_post_meta($postID, 'post_like_count');
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
        return 0;
    }
    return $count;
}
// function to count views.
function voisen_set_post_view($postID){
    $count_key = 'post_views_count';
    $count = (int)get_post_meta($postID, $count_key, true);
    if(!$count){
        $count = 1;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, $count);
    }else{
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}
// function display number like of posts.
function voisen_get_liked($postID){
    global $wpdb;
    $table_name = $wpdb->prefix . 'voisen_user_like_ip';
	$safe_sql = $wpdb->prepare("SELECT COUNT(*) FROM {$table_name} WHERE post_id = %s", $postID);
    $results = $wpdb->get_var( $safe_sql );
    return $results;
}
//ajax like count
add_action( 'wp_footer', 'voisen_add_js_like_post');
function voisen_add_js_like_post(){ ?>
    <script type="text/javascript">
    jQuery(document).on('click', 'a.voisen_like_post', function(e){
		var like_title;
		if(jQuery(this).hasClass('liked')){
			jQuery(this).removeClass('liked');
			like_title = jQuery(this).data('unliked_title');
		}else{
			jQuery(this).addClass('liked');
			like_title = jQuery(this).data('liked_title');
		}
        var post_id = jQuery(this).data("post_id");
		var me = jQuery(this);
        jQuery.ajax({
            type: 'POST',
            dataType: 'json',
            url: ajaxurl,
            data: 'action=voisen_update_like&post_id=' + post_id, 
			success: function(data){
				me.children('.number').text(data);
				me.parent('.likes-counter').attr('title', '').attr('data-original-title', like_title);
            }
        });
		e.preventDefault();
        return false;
    });
    </script>
<?php } 
add_action( 'wp_ajax_voisen_update_like', 'voisen_update_like' );
add_action( 'wp_ajax_nopriv_voisen_update_like', 'voisen_update_like' );
function voisen_get_the_user_ip(){
	if ( ! empty( $_SERVER['HTTP_CLIENT_IP'] ) ) {
		$ip = $_SERVER['HTTP_CLIENT_IP'];
	} elseif ( ! empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
		$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	} else {
		$ip = $_SERVER['REMOTE_ADDR'];
	}
	return $ip;
}
function voisen_check_liked_post($postID){
	global $wpdb;
    $table_name = $wpdb->prefix . 'voisen_user_like_ip';
	$user_ip = voisen_get_the_user_ip();
	$safe_sql = $wpdb->prepare("SELECT COUNT(*) FROM {$table_name} WHERE post_id = %s AND user_ip = %s", $postID, $user_ip);
    $results = $wpdb->get_var( $safe_sql );
	return $results;
}
function voisen_update_like(){
	$count_key = 'post_like_count';
	if(empty($_POST['post_id'])){
	   die('0');
	}else{
		global $wpdb;
		$table_name = $wpdb->prefix . 'voisen_user_like_ip';
		$postID = intval($_POST['post_id']);
		$check = voisen_check_liked_post($postID);
		$ip = voisen_get_the_user_ip();
		$data = array('post_id' => $postID, 'user_ip' => $ip);
		if($check){
			//remove like record
			$wpdb->delete( $table_name, $data ); 
		}else{
			//add new like record
			$wpdb->insert( $table_name, $data );
		}
		echo voisen_get_liked($postID);
		die();
	}
}

?>