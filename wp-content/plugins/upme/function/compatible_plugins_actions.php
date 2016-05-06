<?php

add_action('bbp_template_before_replies_loop','upme_bbp_template_before_replies_loop');
function upme_bbp_template_before_replies_loop(){
    global $upme_bbpress_topic_content;
    if($upme_bbpress_topic_content != ''){
        echo $upme_bbpress_topic_content;
    }    
}

add_action( 'woocommerce_single_product_summary', 'upme_woocommerce_template_single_post_buttons', 6 );
function upme_woocommerce_template_single_post_buttons(){
    global $upme_woocommerce_topic_content;
    if($upme_woocommerce_topic_content != ''){
        echo $upme_woocommerce_topic_content;
    }    
}

?>