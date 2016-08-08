<?php

/**
 * 引入主题后台框架
 */
if (!function_exists('optionsframework_init')){
	define('OPTIONS_FRAMEWORK_DIRECTORY', get_template_directory_uri().'/inc/');
	require_once dirname(__FILE__).'/inc/options-framework.php';
}

/**
 * 去除登录后顶部状态栏
 */
add_filter( 'show_admin_bar', '__return_false' );

/**
 * 改造img标签 懒加载
 */
add_filter ('the_content', 'lazyload');
function lazyload($content) {
    $url = get_theme_root_uri();
    if(!is_feed()||!is_robots) {
        $content=preg_replace('/<img(.+)src=[\'"]([^\'"]+)[\'"](.*)>/i',"<img\$1data-original=\"\$2\" src=\"$url/M-feather/images/loading.jpg\"\$3>\n<noscript>\$0</noscript>",$content);
    }
    return $content;
}

/**
 * 引入ajax评论
 */
require get_template_directory() . '/ajax-comment/do.php';

//添加文章形式
add_theme_support( 'post-formats', array(  'aside', 'image', 'link', 'quote', 'status','video','chat')); //增加文章形式


function exclude_category_home( $query ) {
    if ( $query->is_home ) {
        $query->set( 'cat', '-29' );
    }
    return $query;
}
 
add_filter( 'pre_get_posts', 'exclude_category_home' );


/**
 * 获得ssl头像
 */

function get_ssl_avatar($avatar) {
   $avatar = preg_replace('/.*\/avatar\/(.*)\?s=([\d]+)&.*/','<img src="https://secure.gravatar.com/avatar/$1?s=$2" class="avatar avatar-$2" height="$2" width="$2" alt="user-gravatar">',$avatar);
   return $avatar;
}
add_filter('get_avatar', 'get_ssl_avatar');



/**
 * 引用百度jquery 提高缓存命中率
 * @return [type] [description]
 */
add_action('wp_enqueue_scripts', 'no_more_jquery');
function no_more_jquery(){
    wp_deregister_script('jquery');
    wp_register_script('jquery', "http://apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js", false, null);
    wp_enqueue_script('jquery');
}


/**
 * 获取当前文章的评论数量
 */
function comment_count($postid=0,$which=0) {
    $comments = get_comments('status=approve&type=comment&post_id='.$postid); //获取文章的所有评论
    if ($comments) {
        $i=0; $j=0; $commentusers=array();
        foreach ($comments as $comment) {
            ++$i;
            if ($i==1) { $commentusers[] = $comment->comment_author_email; ++$j; }
            if ( !in_array($comment->comment_author_email, $commentusers) ) {
                $commentusers[] = $comment->comment_author_email;
                ++$j;
            }
        }
        $output = array($j,$i);
        $which = ($which == 0) ? 0 : 1;
        return $output[$which].' comments'; //返回评论人数
    }
    return 'No comment'; //没有评论返回0
}









/**
 * 加载样式
 * @return [type] [description]
 */
function load_resourse(){
	//wp_enqueue_style( 'a', get_template_directory_uri() . '/lib_css/amazeui.min.css');
	wp_enqueue_style( 'b', get_stylesheet_uri());
	wp_register_script('my_amazing_script', get_template_directory_uri().'js/jquery.min.js', array('jquery'),'1.1', true);
	wp_enqueue_script( 's', get_template_directory_uri() . '/js/main.js', array('jquery'), '1.0.0', true );

}
add_action('wp_enqueue_scripts', 'load_resourse' );


/**
 * 注册菜单
 * @return [type] [description]
 */
function register_my_menu(){
	register_nav_menus(
		array(
			'primary' => __( 'Index Navigation' , 'Index Menu'),
			'second'  => __( 'Category Navigation' , 'Category Menu')
			)
	);
}
add_action('init', 'register_my_menu' );


/**
 * 设置菜单html
 */
class ik_walker extends Walker_Nav_Menu{
	//add the description to the menu item output
	function start_el(&$output, $item, $depth=0, $args=array() ,$id=0) {//&$output, $object, $depth = 0, $args = array(), $current_object_id = 0
		static $i = 0;
		$icon = array( '<i class="am-icon-code"></i>' , '<i class="am-icon-sticky-note-o"></i>', '<i class="am-icon-wordpress"></i>');
		global $wp_query;
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
 
		$class_names = $value = '';
 
		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
 
		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );
		$class_names = ' class="' . esc_attr( $class_names ) . '"';
 
		// $output .= $indent . '<li id="menu-item-'. $item->ID . '"' . $value . $class_names .'>';
		$output .= $indent . '<li' . $value . $class_names .'>';
 
		$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
		$attributes .= ! empty( $item->target )	    ? ' target="' . esc_attr( $item->target ) .'"' : '';
		$attributes .= ! empty( $item->xfn )		? ' rel="'	. esc_attr( $item->xfn ) .'"' : '';
		$attributes .= ! empty( $item->url )		? ' href="'   . esc_attr( $item->url ) .'"' : '';
 
		$item_output = $args->before;
		$item_output .= '<a'. $attributes .'>'.$icon[$i];
		$i++;
		$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
		if(strlen($item->description)>2){ $item_output .= '<br /><span class="sub">' . $item->description . '</span>'; }
		$item_output .= '</a>';
		$item_output .= $args->after;
 		
 		// echo count($item_output).'heee';
		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args,$id );
	}
}
add_filter('nav_menu_css_class', 'my_css_attributes_filter', 100, 1);
add_filter('nav_menu_item_id', 'my_css_attributes_filter', 100, 1);
add_filter('page_css_class', 'my_css_attributes_filter', 100, 1);
function my_css_attributes_filter($var) {
  return is_array($var) ? array_intersect($var, array('current-menu-item')) : '';
}


/**
 * 支持外链缩略图
 */
if ( function_exists('add_theme_support') )
 	add_theme_support('post-thumbnails');
	function catch_first_image() {
		global $post, $posts;
		$first_img = '';
		ob_start();
		ob_end_clean();
		$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
		$first_img = $matches [1][0];
		if(empty($first_img)){
            $random = mt_rand(1, 1);
            return get_bloginfo ( 'stylesheet_directory' ).'/images/random/'.$random.'.jpg';
		}
	  return $first_img;
	}



/**
 * 控制摘要长度
 */
function new_excerpt_length($length) {
    return 55;
}
add_filter('excerpt_length', 'new_excerpt_length');
function new_excerpt_more($more) {
    return '...';
}
add_filter('excerpt_more', 'new_excerpt_more');


/**
 * 获取热门文章 按评论数
 */
function get_most_reply_post() {
	$post_num = 5; // 设置调用条数
	// $post->ID = $postID;
	// $array = array($post->ID);
	// 
	// array( ‘ignore_sticky_posts’ => 1, ‘posts_per_page’ => 3, ‘cat’ => 6
	$args = array( 
		'ignore_sticky_posts' => 1,
		'post_password' => '', 
		'post_status' => 'publish', // 只选公开的文章. 
		'post__not_in' => array($post->ID),//排除当前文章 
		// 'caller_get_posts' => 1, // 排除置顶文章. 
		'orderby' => 'comment_count', // 依评论数排序. 
		'posts_per_page' => $post_num 
		); 
	$query_posts = new WP_Query($args); 
	// $query_posts->query($args);
	$i = 1;
	while( $query_posts->have_posts() ) { 
		$query_posts->the_post();
		$d_post = '<li><div class="hot-article-thumb"><img width="74px" height="74px" data-original="'.catch_first_image().'" alt=""></div>';
		$d_post .= '<div class="list-item-info">';
		$d_post .= '<h4><a href="'.get_the_permalink().'">'.get_the_title().'</a></h4>';

		$d_post .= '<p class="list-itemDescription">'.get_post(get_the_ID())->comment_count.' 則留言, '.get_post_meta(get_the_ID(),'specs_zan',true).' 個喜歡</p></div></li>';
		$i++;
		echo $d_post;
	} 
	wp_reset_query();





}


/**
 * widget注册
 */
//function Widgetinit() {
//	register_sidebar( array(
//		'name' => 'Sidebar',
//		'id'   => 'left_sidebar',
//		'before_widget' => '<div id="%1$s2" class="hot-articles %2$s">',
//        'after_widget'  =>  '</div></div>',
//        'after_widget'  => '',
//        'before_title'  => '<header class="sidebar-title">',
//        'after_title'   => '</header>'
//	));
//
//	register_sidebar( array(
//		'name' => 'Footer Area',
//		'id'   => 'footer1',
//		'before_widget' => '',
//        'after_widget'  =>  '',
//        'after_widget'  => '',
//        'before_title'  => '',
//        'after_title'   => ''
//	));
//}
//add_action('widgets_init','Widgetinit');



/*
 Plugin Name: WP No Category Base
 Plugin URI: http://blinger.org/wordpress-plugins/no-category-base/
 Description: Removes '/category' from your category permalinks.
 Version: 1.1.1
 Author: iDope
 Author URI: http://efextra.com/
 */

/*  Copyright 2008  Saurabh Gupta  (email : saurabh0@gmail.com)

 This program is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation; either version 2 of the License, or
 (at your option) any later version.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License
 along with this program; if not, write to the Free Software
 Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */

// Refresh rules on activation/deactivation/category changes
register_activation_hook(__FILE__, 'no_category_base_refresh_rules');
add_action('created_category', 'no_category_base_refresh_rules');
add_action('edited_category', 'no_category_base_refresh_rules');
add_action('delete_category', 'no_category_base_refresh_rules');
function no_category_base_refresh_rules() {
    global $wp_rewrite;
    $wp_rewrite -> flush_rules();
}

register_deactivation_hook(__FILE__, 'no_category_base_deactivate');
function no_category_base_deactivate() {
    remove_filter('category_rewrite_rules', 'no_category_base_rewrite_rules');
    // We don't want to insert our custom rules again
    no_category_base_refresh_rules();
}

// Remove category base
add_action('init', 'no_category_base_permastruct');
function no_category_base_permastruct() {
    global $wp_rewrite, $wp_version;
    if (version_compare($wp_version, '3.4', '<')) {
        // For pre-3.4 support
        $wp_rewrite -> extra_permastructs['category'][0] = '%category%';
    } else {
        $wp_rewrite -> extra_permastructs['category']['struct'] = '%category%';
    }
}

// Add our custom category rewrite rules
add_filter('category_rewrite_rules', 'no_category_base_rewrite_rules');
function no_category_base_rewrite_rules($category_rewrite) {
    //var_dump($category_rewrite); // For Debugging

    $category_rewrite = array();
    $categories = get_categories(array('hide_empty' => false));
    foreach ($categories as $category) {
        $category_nicename = $category -> slug;
        if ($category -> parent == $category -> cat_ID)// recursive recursion
            $category -> parent = 0;
        elseif ($category -> parent != 0)
            $category_nicename = get_category_parents($category -> parent, false, '/', true) . $category_nicename;
        $category_rewrite['(' . $category_nicename . ')/(?:feed/)?(feed|rdf|rss|rss2|atom)/?$'] = 'index.php?category_name=$matches[1]&feed=$matches[2]';
        $category_rewrite['(' . $category_nicename . ')/page/?([0-9]{1,})/?$'] = 'index.php?category_name=$matches[1]&paged=$matches[2]';
        $category_rewrite['(' . $category_nicename . ')/?$'] = 'index.php?category_name=$matches[1]';
    }
    // Redirect support from Old Category Base
    global $wp_rewrite;
    $old_category_base = get_option('category_base') ? get_option('category_base') : 'category';
    $old_category_base = trim($old_category_base, '/');
    $category_rewrite[$old_category_base . '/(.*)$'] = 'index.php?category_redirect=$matches[1]';

    //var_dump($category_rewrite); // For Debugging
    return $category_rewrite;
}

// For Debugging
//add_filter('rewrite_rules_array', 'no_category_base_rewrite_rules_array');
//function no_category_base_rewrite_rules_array($category_rewrite) {
//	var_dump($category_rewrite); // For Debugging
//}

// Add 'category_redirect' query variable
add_filter('query_vars', 'no_category_base_query_vars');
function no_category_base_query_vars($public_query_vars) {
    $public_query_vars[] = 'category_redirect';
    return $public_query_vars;
}

// Redirect if 'category_redirect' is set
add_filter('request', 'no_category_base_request');
function no_category_base_request($query_vars) {
    //print_r($query_vars); // For Debugging
    if (isset($query_vars['category_redirect'])) {
        $catlink = trailingslashit(get_option('home')) . user_trailingslashit($query_vars['category_redirect'], 'category');
        status_header(301);
        header("Location: $catlink");
        exit();
    }
    return $query_vars;
}




/**
 * The Disable Google Fonts Plugin
 *
 * Disable enqueuing of Open Sans and other fonts used by WordPress from Google.
 *
 * @package Disable_Google_Fonts
 * @subpackage Main
 */

/**
 * Plugin Name: Disable Google Fonts
 * Plugin URI:  http://blog.milandinic.com/wordpress/plugins/disable-google-fonts/
 * Description: Disable enqueuing of Open Sans and other fonts used by WordPress from Google.
 * Author:      Milan Dinić
 * Author URI:  http://blog.milandinic.com/
 * Version:     1.2
 * Text Domain: disable-google-fonts
 * Domain Path: /languages/
 * License:     GPL
 */

/* Exit if accessed directly */
if ( ! defined( 'ABSPATH' ) ) exit;

class Disable_Google_Fonts {
    /**
     * Hook actions and filters.
     *
     * @since 1.0
     * @access public
     */
    public function __construct() {
        add_filter( 'gettext_with_context', array( $this, 'disable_open_sans'             ), 888, 4 );
        add_action( 'after_setup_theme',    array( $this, 'register_theme_fonts_disabler' ), 1      );

        // Register plugins action links filter
        add_filter( 'plugin_action_links',               array( $this, 'action_links' ), 10, 2 );
        add_filter( 'network_admin_plugin_action_links', array( $this, 'action_links' ), 10, 2 );
    }

    /**
     * Add action links to plugins page.
     *
     * @since 1.2
     * @access public
     *
     * @param array  $links       Existing plugin's action links.
     * @param string $plugin_file Path to the plugin file.
     * @return array $links New plugin's action links.
     */
    public function action_links( $links, $plugin_file ) {
        // Set basename
        $basename = plugin_basename( __FILE__ );

        // Check if it is for this plugin
        if ( $basename != $plugin_file ) {
            return $links;
        }

        // Load translations
        load_plugin_textdomain( 'disable-google-fonts', false, dirname( $basename ) . '/languages' );
    }

    /**
     * Force 'off' as a result of Open Sans font toggler string translation.
     *
     * @since 1.0
     * @access public
     *
     * @param  string $translations Translated text.
     * @param  string $text         Text to translate.
     * @param  string $context      Context information for the translators.
     * @param  string $domain       Text domain. Unique identifier for retrieving translated strings.
     * @return string $translations Translated text.
     */
    public function disable_open_sans( $translations, $text, $context, $domain ) {
        if ( 'Open Sans font: on or off' == $context && 'on' == $text ) {
            $translations = 'off';
        }

        return $translations;
    }

    /**
     * Force 'off' as a result of Lato font toggler string translation.
     *
     * @since 1.0
     * @access public
     *
     * @param  string $translations Translated text.
     * @param  string $text         Text to translate.
     * @param  string $context      Context information for the translators.
     * @param  string $domain       Text domain. Unique identifier for retrieving translated strings.
     * @return string $translations Translated text.
     */
    public function disable_lato( $translations, $text, $context, $domain ) {
        if ( 'Lato font: on or off' == $context && 'on' == $text ) {
            $translations = 'off';
        }

        return $translations;
    }

    /**
     * Force 'off' as a result of Source Sans Pro font toggler string translation.
     *
     * @since 1.0
     * @access public
     *
     * @param  string $translations Translated text.
     * @param  string $text         Text to translate.
     * @param  string $context      Context information for the translators.
     * @param  string $domain       Text domain. Unique identifier for retrieving translated strings.
     * @return string $translations Translated text.
     */
    public function disable_source_sans_pro( $translations, $text, $context, $domain ) {
        if ( 'Source Sans Pro font: on or off' == $context && 'on' == $text ) {
            $translations = 'off';
        }

        return $translations;
    }

    /**
     * Force 'off' as a result of Bitter font toggler string translation.
     *
     * @since 1.0
     * @access public
     *
     * @param  string $translations Translated text.
     * @param  string $text         Text to translate.
     * @param  string $context      Context information for the translators.
     * @param  string $domain       Text domain. Unique identifier for retrieving translated strings.
     * @return string $translations Translated text.
     */
    public function disable_bitter( $translations, $text, $context, $domain ) {
        if ( 'Bitter font: on or off' == $context && 'on' == $text ) {
            $translations = 'off';
        }

        return $translations;
    }

    /**
     * Force 'off' as a result of Noto Sans font toggler string translation.
     *
     * @since 1.1
     * @access public
     *
     * @param  string $translations Translated text.
     * @param  string $text         Text to translate.
     * @param  string $context      Context information for the translators.
     * @param  string $domain       Text domain. Unique identifier for retrieving translated strings.
     * @return string $translations Translated text.
     */
    public function disable_noto_sans( $translations, $text, $context, $domain ) {
        if ( 'Noto Sans font: on or off' == $context && 'on' == $text ) {
            $translations = 'off';
        }

        return $translations;
    }

    /**
     * Force 'off' as a result of Noto Serif font toggler string translation.
     *
     * @since 1.1
     * @access public
     *
     * @param  string $translations Translated text.
     * @param  string $text         Text to translate.
     * @param  string $context      Context information for the translators.
     * @param  string $domain       Text domain. Unique identifier for retrieving translated strings.
     * @return string $translations Translated text.
     */
    public function disable_noto_serif( $translations, $text, $context, $domain ) {
        if ( 'Noto Serif font: on or off' == $context && 'on' == $text ) {
            $translations = 'off';
        }

        return $translations;
    }

    /**
     * Force 'off' as a result of Inconsolata font toggler string translation.
     *
     * @since 1.1
     * @access public
     *
     * @param  string $translations Translated text.
     * @param  string $text         Text to translate.
     * @param  string $context      Context information for the translators.
     * @param  string $domain       Text domain. Unique identifier for retrieving translated strings.
     * @return string $translations Translated text.
     */
    public function disable_inconsolata( $translations, $text, $context, $domain ) {
        if ( 'Inconsolata font: on or off' == $context && 'on' == $text ) {
            $translations = 'off';
        }

        return $translations;
    }

    /**
     * Force 'off' as a result of Merriweather font toggler string translation.
     *
     * @since 1.2
     * @access public
     *
     * @param  string $translations Translated text.
     * @param  string $text         Text to translate.
     * @param  string $context      Context information for the translators.
     * @param  string $domain       Text domain. Unique identifier for retrieving translated strings.
     * @return string $translations Translated text.
     */
    public function disable_merriweather( $translations, $text, $context, $domain ) {
        if ( 'Merriweather font: on or off' == $context && 'on' == $text ) {
            $translations = 'off';
        }

        return $translations;
    }

    /**
     * Force 'off' as a result of Montserrat font toggler string translation.
     *
     * @since 1.2
     * @access public
     *
     * @param  string $translations Translated text.
     * @param  string $text         Text to translate.
     * @param  string $context      Context information for the translators.
     * @param  string $domain       Text domain. Unique identifier for retrieving translated strings.
     * @return string $translations Translated text.
     */
    public function disable_montserrat( $translations, $text, $context, $domain ) {
        if ( 'Montserrat font: on or off' == $context && 'on' == $text ) {
            $translations = 'off';
        }

        return $translations;
    }

    /**
     * Register filters that disable fonts for bundled themes.
     *
     * This filters can be directly hooked as Disable_Google_Fonts::disable_open_sans()
     * but that would mean that comparison is done on each string
     * for each font which creates performance issues.
     *
     * Instead we check active template's name very late and just once
     * and hook appropriate filters.
     *
     * Note that Open Sans disabler is used for both WordPress core
     * and for Twenty Twelve theme.
     *
     * @since 1.0
     * @access public
     *
     * @uses get_template() To get name of the active parent theme.
     * @uses add_filter()   To hook theme specific fonts disablers.
     */
    public function register_theme_fonts_disabler() {
        $template = get_template();

        switch ( $template ) {
            case 'twentysixteen' :
                add_filter( 'gettext_with_context', array( $this, 'disable_merriweather'    ), 888, 4 );
                add_filter( 'gettext_with_context', array( $this, 'disable_montserrat'      ), 888, 4 );
                add_filter( 'gettext_with_context', array( $this, 'disable_inconsolata'     ), 888, 4 );
                break;
            case 'twentyfifteen' :
                add_filter( 'gettext_with_context', array( $this, 'disable_noto_sans'       ), 888, 4 );
                add_filter( 'gettext_with_context', array( $this, 'disable_noto_serif'      ), 888, 4 );
                add_filter( 'gettext_with_context', array( $this, 'disable_inconsolata'     ), 888, 4 );
                break;
            case 'twentyfourteen' :
                add_filter( 'gettext_with_context', array( $this, 'disable_lato'            ), 888, 4 );
                break;
            case 'twentythirteen' :
                add_filter( 'gettext_with_context', array( $this, 'disable_source_sans_pro' ), 888, 4 );
                add_filter( 'gettext_with_context', array( $this, 'disable_bitter'          ), 888, 4 );
                break;
        }
    }
}

/* Although it would be preferred to do this on hook,
 * load early to make sure Open Sans is removed
 */
$disable_google_fonts = new Disable_Google_Fonts;


















/**
 * 获取分类
 */
function echo_the_Category() {
	foreach((get_the_category()) as $category) { 
	    echo '<a href="'.get_category_link($category->cat_ID).'" title="'.$category->name.'" rel="category tag">'.$category->name.'</a>';
	}
}


function search_form( $form ) {

    $form = '<form name="search_at" role="search" method="get" id="searchform" action="'. home_url('/').'" class="Search-form">
        <div class="Search-inner">
            <input placeholder="善用键盘和搜索" type="search" value="' . get_search_query() . '" name="s" id="SearchInput" onkeydown= "if(event.keyCode==13)search_at.submit()" />
            <label type="submit" id="searchsubmit" class="Label" for="SearchInput"></label>
        </div>
    </form>';
    return $form;
}

add_filter( 'get_search_form', 'search_form' );

/**
 * 增加editor 样式
 */
add_editor_style();


/**
 * 获取相关文章如果没有tags根据category
 */

function joints_related_posts() {
    global $post;
    $tag_arr="";
    $tags = wp_get_post_tags( $post->ID );
    // var_dump( $tags);
    if($tags) {
        foreach( $tags as $tag ) {
            $tag_arr .= $tag->slug . ',';
        }
        $args = array(
            'tag' => $tag_arr,
            'numberposts' => 6, /* You can change this to show more */
            'post__not_in' => array($post->ID)
        );
        $related_posts = get_posts( $args );
        if($related_posts) {
            foreach ( $related_posts as $post ) : setup_postdata( $post ); ?>
                <li class="related_post">
                    <a class="entry-unrelated" href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php echo mb_substr(get_the_title(), 0, 28, 'utf-8'); ?></a>
                </li>
            <?php endforeach; }
     }else{ ?>
     <?php
		$args = array( 'posts_per_page' => 6, 'orderby' => 'rand' );
		$rand_posts = get_posts( $args );
		foreach ( $rand_posts as $post ) : 
		  setup_postdata( $post ); ?>
			<li class="related_post">
                    <a class="entry-unrelated" href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php echo mb_substr(get_the_title(), 0, 28, 'utf-8'); ?></a>
                </li>
		<?php endforeach; 
     }
    wp_reset_postdata();
}


/**
 * 修改评论结构
 */
function custome_comments( $comment, $args ,$depth ) {
	$GLOBALS['comment'] = $comment; ?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<div id="comment-<?php comment_ID(); ?>" class="comment-body">
			<div class="comment-author vcard">
				<?php echo get_avatar($comment,$size='35'); ?>
				<cite class="fn">
					<?php printf(__('%s'),get_comment_author_link()); ?> <span class="say">说道：</span>
					<?php if($comment->comment_approved=='0') : ?>
						<em><?php _e('等待审核！' ); ?></em>
					<?php endif; ?>
				</cite>
                <time class="comment-time"><?php printf(__('%1$s at %2$s'), get_comment_date('Y-m-d'),''); ?></time>
			</div>
			<div class="comment-meta comment-meta-data">
				<?php edit_comment_link(__('(编辑)'),'','' ); ?>
			</div>
			<!-- <div class="comment-content"> -->
				<?php comment_text(); ?>
			<!-- </div> -->
			<div class="reply">
				<?php comment_reply_link(array_merge($args,array('depth'=>$depth,'max_depth'=>$args['max_depth'])) ); ?>
			</div>
		</div>	
	</li>
	<?php
}



remove_action( 'wp_head', 'feed_links_extra', 3 ); //去除评论feed
remove_action( 'wp_head', 'feed_links', 2 ); //去除文章feed
remove_action( 'wp_head', 'rsd_link' ); //针对Blog的远程离线编辑器接口
remove_action( 'wp_head', 'wlwmanifest_link' ); //Windows Live Writer接口
remove_action( 'wp_head', 'index_rel_link' ); //移除当前页面的索引
remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 ); //移除后面文章的url
remove_action( 'wp_head', 'start_post_rel_link', 10, 0 ); //移除最开始文章的url
remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0 );//自动生成的短链接
remove_action( 'wp_head', 'adjacent_posts_rel_link', 10, 0 ); ///移除相邻文章的url
remove_action( 'wp_head', 'wp_generator' ); // 移除版本号



/**
 * Disable the emoji's
 */
 function disable_emojis() {
	 remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	 remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	 remove_action( 'wp_print_styles', 'print_emoji_styles' );
	 remove_action( 'admin_print_styles', 'print_emoji_styles' );
	 remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	 remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
	 remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
	 add_filter( 'tiny_mce_plugins', 'disable_emojis_tinymce' );
 }
 add_action( 'init', 'disable_emojis' );

/**
 * Filter function used to remove the tinymce emoji plugin.
 */
 function disable_emojis_tinymce( $plugins ) {
	 if ( is_array( $plugins ) ) {
	 	return array_diff( $plugins, array( 'wpemoji' ) );
	 } else {
		return array();
	 }
 }



function disable_embeds_init() {
    /* @var WP $wp */
    global $wp;

    // Remove the embed query var.
    $wp->public_query_vars = array_diff( $wp->public_query_vars, array(
        'embed',
    ) );

    // Remove the REST API endpoint.
    remove_action( 'rest_api_init', 'wp_oembed_register_route' );

    // Turn off
    add_filter( 'embed_oembed_discover', '__return_false' );

    // Don't filter oEmbed results.
    remove_filter( 'oembed_dataparse', 'wp_filter_oembed_result', 10 );

    // Remove oEmbed discovery links.
    remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );

    // Remove oEmbed-specific JavaScript from the front-end and back-end.
    remove_action( 'wp_head', 'wp_oembed_add_host_js' );
    add_filter( 'tiny_mce_plugins', 'disable_embeds_tiny_mce_plugin' );

    // Remove all embeds rewrite rules.
    add_filter( 'rewrite_rules_array', 'disable_embeds_rewrites' );
}

add_action( 'init', 'disable_embeds_init', 9999 );

/**
 * Removes the 'wpembed' TinyMCE plugin.
 *
 * @since 1.0.0
 *
 * @param array $plugins List of TinyMCE plugins.
 * @return array The modified list.
 */
function disable_embeds_tiny_mce_plugin( $plugins ) {
    return array_diff( $plugins, array( 'wpembed' ) );
}

/**
 * Remove all rewrite rules related to embeds.
 *
 * @since 1.2.0
 *
 * @param array $rules WordPress rewrite rules.
 * @return array Rewrite rules without embeds rules.
 */
function disable_embeds_rewrites( $rules ) {
    foreach ( $rules as $rule => $rewrite ) {
        if ( false !== strpos( $rewrite, 'embed=true' ) ) {
            unset( $rules[ $rule ] );
        }
    }

    return $rules;
}

/**
 * Remove embeds rewrite rules on plugin activation.
 *
 * @since 1.2.0
 */
function disable_embeds_remove_rewrite_rules() {
    add_filter( 'rewrite_rules_array', 'disable_embeds_rewrites' );
    flush_rewrite_rules();
}

register_activation_hook( __FILE__, 'disable_embeds_remove_rewrite_rules' );

/**
 * Flush rewrite rules on plugin deactivation.
 *
 * @since 1.2.0
 */
function disable_embeds_flush_rewrite_rules() {
    remove_filter( 'rewrite_rules_array', 'disable_embeds_rewrites' );
    flush_rewrite_rules();
}

register_deactivation_hook( __FILE__, 'disable_embeds_flush_rewrite_rules' );







/**
 * 取消分类描述 html过滤
 */
remove_filter('pre_term_description', 'wp_filter_kses');
//===========================================================
/**
 * 添加编辑按钮
 */
if ( ! function_exists( 'elegent_posted_on' ) ) :
/**
* Prints HTML with meta information for the current post-date/time and author.
*/
function elegent_posted_on() {
	edit_post_link(
		esc_html__('- [Edit]', 'hacker'),
		'<span class="edit-link">',
		'</span>'
	);
}
endif;


// 评论添加@
function comment_add_at( $comment_text, $comment = '') {
  if( $comment->comment_parent > 0) {
    $comment_text = '@<a href="#comment-' . $comment->comment_parent . '">'.get_comment_author( $comment->comment_parent ) . '</a> ' . $comment_text;
  }

  return $comment_text;
}
add_filter( 'comment_text' , 'comment_add_at', 20, 2);
//=========================================================================


function comment_mail_notify($comment_id) {
     $comment = get_comment($comment_id);//根据id获取这条评论相关数据
     $content=$comment->comment_content;
     //对评论内容进行匹配
     $match_count=preg_match_all('/<a href="#comment-([0-9]+)?" rel="nofollow">/si',$content,$matchs);
     if($match_count>0){//如果匹配到了
         foreach($matchs[1] as $parent_id){//对每个子匹配都进行邮件发送操作
             SimPaled_send_email($parent_id,$comment);
         }
     }elseif($comment->comment_parent!='0'){//以防万一，有人故意删了@回复，还可以通过查找父级评论id来确定邮件发送对象
         $parent_id=$comment->comment_parent;
         SimPaled_send_email($parent_id,$comment);
     }else return;
 }
 add_action('comment_post', 'comment_mail_notify');
 function SimPaled_send_email($parent_id,$comment){//发送邮件的函数 by Qiqiboy.com
     $admin_email = get_bloginfo ('admin_email');//管理员邮箱
     $parent_comment=get_comment($parent_id);//获取被回复人（或叫父级评论）相关信息
     $author_email=$comment->comment_author_email;//评论人邮箱
     $to = trim($parent_comment->comment_author_email);//被回复人邮箱
     $spam_confirmed = $comment->comment_approved;
     if ($spam_confirmed != 'spam' && $to != $admin_email && $to != $author_email) {
         $wp_email = 'no-reply@' . preg_replace('#^www\.#', '', strtolower($_SERVER['SERVER_NAME'])); // e-mail 發出點, no-reply 可改為可用的 e-mail.
         $subject = '您在 [' . get_option("blogname") . '] 的留言有了新的回复';
         $message = '<div style="background-color:#eef2fa;border:1px solid #333;color:#111;-moz-border-radius:5px;-webkit-border-radius:5px;-khtml-border-radius:5px;font-family:MicroSoft YaHei;font-size:14px;">
				<p style="background-color: #333333;color: #fff;padding: 10px 0 10px 20px;margin: 0;border-radius: 5px 5px 0 0;"><span style="color: #71B033;font-size: 16px;font-weight: 300;">'.get_option("blogname").'</span> 上有新的回复</p>
				<div style="padding: 10px 20px;">
	    		<p><span>' . trim(get_comment($parent_id)->comment_author) . '</span>,你好!</p>
	            <p>您曾在 <a href="">《' . get_the_title($comment->comment_post_ID) . '》</a>的留言:woshuonishisheileme 有新的回复:</p>
	            <p>' . trim($comment->comment_author) . '给你的回复:<br /></p>
	            <p style="background-color: #ddd;padding: 12px;color: #464646;">'. trim($comment->comment_content) . '<br /></p>
	            <p>您可以点击 <a style="color:#709A17" href="' . htmlspecialchars(get_comment_link($parent_id,array("type" => "all"))) . '">查看回复的完整內容</a></p>
	            <p>(此邮件有系统自动发出, 请勿回复.)</p>
	            <p>欢迎再度爆踩 <a style="color:#709A17" href="' . get_option('home') . '">'. get_option('blogname') . ' </a></p>
	    	</div>
		</div>';
         $from = "From: \"" . get_option('blogname') . "\" <$wp_email>";
         $headers = "$from\nContent-Type: text/html; charset=" . get_option('blog_charset') . "\n";
         wp_mail( $to, $subject, $message, $headers );
     }
 }
//======================================================================================





add_filter('pre_site_transient_update_core',    create_function('$a', "return null;")); // 关闭核心提示
add_filter('pre_site_transient_update_plugins', create_function('$a', "return null;")); // 关闭插件提示
add_filter('pre_site_transient_update_themes',  create_function('$a', "return null;")); // 关闭主题提示
remove_action('admin_init', '_maybe_update_core');    // 禁止 WordPress 检查更新
remove_action('admin_init', '_maybe_update_plugins'); // 禁止 WordPress 更新插件
remove_action('admin_init', '_maybe_update_themes');  // 禁止 WordPress 更新主题


/**
 * 添加图片表情
 */
add_filter('smilies_src','custom_smilies_src',1,10);
function custom_smilies_src ($img_src, $img, $siteurl){
    return get_bloginfo('template_directory').'/images/smilies/'.$img;
}

/**
 * 插入表情
 */
function add_smile() {
    include(TEMPLATEPATH . '/smiley.php');
}
add_filter('comment_form_after_fields',add_smile);


/**
 * 点赞功能
 */
add_action('wp_ajax_nopriv_specs_zan', 'specs_zan');
add_action('wp_ajax_specs_zan', 'specs_zan');
function specs_zan(){
    global $wpdb,$post;
    $id = $_POST["um_id"];
    $action = $_POST["um_action"];
    if ( $action == 'ding'){
        $specs_raters = get_post_meta($id,'specs_zan',true);
        $expire = time() + 99999999;
        $domain = ($_SERVER['HTTP_HOST'] != 'localhost') ? $_SERVER['HTTP_HOST'] : false; // make cookies work with localhost
        setcookie('specs_zan_'.$id,$id,$expire,'/',$domain,false);
        if (!$specs_raters || !is_numeric($specs_raters)) {
            update_post_meta($id, 'specs_zan', 1);
        }
        else {
            update_post_meta($id, 'specs_zan', ($specs_raters + 1));
        }
        echo get_post_meta($id,'specs_zan',true);
    }
    die;
}


?>

