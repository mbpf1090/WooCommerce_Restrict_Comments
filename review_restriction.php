<?php
/*
 * Plugin Name:		Restrict reviews
 * Description:		Customers can leave a review only once for each product.
 * Version:		1.1
 * Author:		MBPF
 * Plugin URI:		https://github.com/mbpf1090/WooCommerce_Restrict_Comments
*/
 
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

function remove_form($form_fields) {
    //get user
    $user = wp_get_current_user();
    $user_id = $user->ID;
    //get product
    $product = get_product();
    $product_id = $product->id;
    //get user comments
    $comments = get_comments( array( 'user_id' => array($user_id), 'post_type' => 'product', 'post_id' => $product_id, ));
    //if already commented empty array
    if (count($comments) > 0) {
	return $form_fields['comment'] = array();
    } else {
        return $form_fields;
    }
}

function remove_submit_button($submit_button) {
    //get user
    $user = wp_get_current_user();
    $user_id = $user->ID;
    //get product
    $product = get_product();
    $product_id = $product->id;
    //get user comments
    $comments = get_comments( array( 'user_id' => array($user_id), 'post_type' => 'product', 'post_id' => $product_id, ));
    //if already commented empty array
    if (count($comments) > 0) {
	unset($submit_button);
    } else {
        return $submit_button;
    }
}
//add_filter( 'comment_form_defaults', 'wpse33039_form_defaults' );
function wpse33039_form_defaults( $defaults )
{
	var_dump($defaults);
    $defaults['title_reply'] = 'foo';
    return $defaults;
}
add_filter('comment_form_fields', 'remove_form' );
add_filter('comment_form_submit_button', 'remove_submit_button' );
