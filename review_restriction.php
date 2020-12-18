<?php
/*
 * Plugin Name:       Restrict reviews
 * Description:       Customers can leave a review only once for each product.
 * Version:           1.0
 * Author:            MBPF
*/
 
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

function restrict_review($submit_button) {
    //get user
    $user = wp_get_current_user();
    $user_id = $user->ID;
    //get product
    $product = get_product();
    $product_id = $product->id;
    //get user comments
    $comments = get_comments( array( 'user_id' => array($user_id), 'post_type' => 'product', 'post_id' => $product_id, ));
    
    //Debug
    //print("<pre>".print_r($comments, true)."</pre>");
    //print("<pre>".print_r($user_id, true)."</pre>");
    //print("<pre>".print_r($user_id, true)."</pre>");
    //print("<pre>".print_r($product_id, true)."</pre>");
    //echo 'test' . var_dump($comments);
    
    //if already commented empty array
    if (count($comments) > 0) {
        unset($submit_button);
    } else {
        return $submit_button;
    }
}

add_filter('comment_form_submit_button', 'restrict_review' );