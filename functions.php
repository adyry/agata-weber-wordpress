<?php

/**
* Theme support features.
*
* @since 1.0.0
*/
function aweber_setup() {

	global $content_width;

	load_theme_textdomain('aweber', get_template_directory() . '/languages');
	add_theme_support( 'custom-logo', array( 'height' => 149, 'width' => 149, 'flex-height' => true, 'flex-width' => true ) );
	register_nav_menu( 'header-menu', __( 'Header Menu', 'aweber' ) );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( "title-tag" );
	add_theme_support( 'post-formats', array( 'video' ) );
	add_theme_support( 'custom-background', array('default-color' => 'FFFFFF') );

	if ( ! isset( $content_width ) ) $content_width = 900;

}
add_action( 'after_setup_theme', 'aweber_setup' );

function remove_menus(){
	remove_menu_page( 'jetpack' );                    //Jetpack*
	remove_menu_page( 'index.php' );                  //Dashboard
	remove_menu_page( 'edit.php' );                   //Posts
	remove_menu_page( 'edit.php?post_type=page' );    //Pages
	remove_menu_page( 'tools.php' );                  //Tools
}
add_action( 'admin_menu', 'remove_menus',999);

function my_theme_archive_title( $title ) {
	if ( is_category() ) {
		$title = single_cat_title( '', false );
	} elseif ( is_tag() ) {
		$title = single_tag_title( '', false );
	} elseif ( is_author() ) {
		$title = '<span class="vcard">' . get_the_author() . '</span>';
	} elseif ( is_post_type_archive() ) {
		$title = post_type_archive_title( '', false );
	} elseif ( is_tax() ) {
		$title = single_term_title( '', false );
	}

	return $title;
}

add_filter( 'get_the_archive_title', 'my_theme_archive_title' );


/**
* Editor custom style
*
* @since 1.0.0
*/
function aweber_add_editor_styles() {
	add_editor_style( 'css/editor-style.css' );
}
add_action( 'admin_init', 'aweber_add_editor_styles' );


/**
* Enqueue of theme styles and scripts.
*
* @since 1.0.0
*/
function aweber_theme_imports(){
	wp_enqueue_style( 'fontawesome', get_stylesheet_directory_uri().'/css/font-awesome.min.css' );
	wp_enqueue_style( 'slitslider', get_stylesheet_directory_uri().'/css/slitslider.css' );
	wp_enqueue_style( 'aweber', get_stylesheet_uri(),999 );
	wp_enqueue_script( 'slicknav', get_stylesheet_directory_uri() . '/js/jquery.slicknav.min.js', array('jquery') );
	wp_enqueue_script( 'slitslider', get_stylesheet_directory_uri() . '/js/jquery.slitslider.js', array('jquery') );
	wp_enqueue_script( 'aweber', get_stylesheet_directory_uri() . '/js/scripts.js', array('jquery') );
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action('wp_enqueue_scripts', 'aweber_theme_imports');

require_once get_template_directory().'/customizer.php';

/**
* Video iframe.
* This is used to parse content to find video URLs from youtube or vimeo.
*
* @since 1.0.0
* @param int $post_id the post ID
* @return string The embed code of the video.
*/
function aweber_get_video( $post_id ) {

	$post = get_post($post_id);
	$content = do_shortcode( apply_filters( 'the_content', $post->post_content ) );
	$embeds = get_media_embedded_in_content( $content );
	if( !empty($embeds) ) {
		//check what is the first embed containg video tag, youtube or vimeo
		foreach( $embeds as $embed ) {
			if( strpos( $embed, 'video' ) || strpos( $embed, 'youtube' ) || strpos( $embed, 'vimeo' ) ) {
				return $embed;
			}
		}
	} else {
		//No video embedded found
		return false;
	}

}

/**
* Filter for the_category function
* Filter for the_category function
*
* @since 1.0.0
* @param string the return string
* @return string the string that separates each category
*/

function aweber_the_category_filter($return,$separator=' ') {

	if( is_home() || is_front_page() ) {

		//list the category names to exclude
		$exclude = array('featured','slide');

		$cats = explode($separator,$return);
		$newlist = array();
		foreach($cats as $cat) {
			$catname = trim(strip_tags($cat));
			if(!in_array($catname,$exclude))
			$newlist[] = $cat;
		}
		return implode($separator,$newlist);
	} else
	return $return;
}

add_filter('the_category','aweber_the_category_filter',10,2);
