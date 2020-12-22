<?php
/* 
 * Pluginn Name:	Restrict reviews
 * Description:		Customers can leave a review only once for each product.
 * Version:		1.1
 * Author:		MBPF
		 * PluginURI:		https://github.com/mbpf1090/WooCommerce_Restrict_Comments
*/
 
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

function has_reviewed() {
    //get user
    $user = wp_get_current_user();
    $user_id = $user->ID;
    //get product
    $product = get_product();
    $product_id = $product->id;
    //get user comments
    $comments = get_comments( array( 'user_id' => array($user_id), 'post_type' => 'product', 'post_id' => $product_id, ));
    //check length of comments array
    if (count($comments) > 0) {
        return true;
    }
    return false;
    
}

function remove_submit_button($submit_button) {
    if (has_reviewed() == true) {
        unset($submit_button);
    }
    return $submit_button;
}

function replace_comments_form($fields) {
    if (has_reviewed() == true) {
        unset($fields);
        $fields = array('comment' => '<p>Sie haben dieses Produkt schon bewertet</p>');
        return $fields;
    } else {
        return $fields;
    }
}

add_filter('comment_form_submit_button', 'remove_submit_button' );
add_filter('comment_form_fields', 'replace_comments_form' );
