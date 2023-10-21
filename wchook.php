<?php


function iconic_display_engraving_text_cart( $item_data, $cart_item ) {
	if ( empty( $cart_item['saksh_event_time'] ) ) {
	return $item_data;
	}

  

	
		$item_data[] = array(
		'key'     => __( 'Booking time', 'aistore' ),
		'value'   => wc_clean( $cart_item['saksh_event_time'] ),
		'display' => '',
	);
	
		$item_data[] = array(
		'key'     => __( 'Start', 'aistore' ),
		'value'   => wc_clean( $cart_item['start'] ),
		'display' => '',
	);
	
	return $item_data;
}

 add_filter( 'woocommerce_get_item_data', 'iconic_display_engraving_text_cart', 10, 2 );





 add_filter('woocommerce_thankyou_order_received_text', 'woo_change_order_received_text', 10, 2 );
 
 
 
function woo_change_order_received_text( $str, $order ) {
	


	$saksh_event_time="";
	
 foreach ( $order->get_items() as $key => $item ) {
	 
 
         
			 
				
				
    $saksh_event_time = wc_get_order_item_meta( $key, 'saksh_event_time' );
    
    var_dump($saksh_event_time);
   
}  


    $str = 'Booking time.. '.$saksh_event_time ;
    return $str;
}




 	
 add_action( 'woocommerce_order_status_pending', 'processRechargeStep3', 10, 1);
 add_action( 'woocommerce_order_status_failed', 'processRechargeStep3', 10, 1);
 add_action( 'woocommerce_order_status_on-hold', 'processRechargeStep3', 10, 1);
// Note that it's woocommerce_order_status_on-hold, and NOT on_hold.
 add_action( 'woocommerce_order_status_processing', 'processRechargeStep3', 10, 1);
 add_action( 'woocommerce_order_status_completed', 'processRechargeStep3', 10, 1);
 add_action( 'woocommerce_order_status_refunded', 'processRechargeStep3', 10, 1);
 add_action( 'woocommerce_order_status_cancelled', 'processRechargeStep3', 10, 1);	
 
add_action( 'woocommerce_order_status_completed', 'processRechargeStep3', 10, 1);


add_action( 'woocommerce_order_status_completed', 'processRechargeStep3', 10, 1);
 
 
 
 
 function processRechargeStep3($order_id){


 
 
 
    $order = wc_get_order( $order_id );


	 
	
 foreach ( $order->get_items() as $key => $item ) {
    
$product_id = $item->get_product_id();
 
        
        
        


				
   $saksh_event_time = wc_get_order_item_meta( $key, 'saksh_event_time' );
   
   
   $start = wc_get_order_item_meta( $key, 'start' );
   
   
   
   
   
    $user = wp_get_current_user();
    
    $id = $user->ID;
    
 
    global   $wpdb;
    
    $table_name = $wpdb->prefix . 'events';
  
    
     // Create post object
$my_post = array(
  'post_title'    =>  __LINE__ . "--". $saksh_event_time . "--".$start. "--".$product_id,
  'post_content'  =>  "",
  'post_status'   => 'publish',
  'post_author'   => 1 
);

// Insert the post into the database
wp_insert_post( $my_post );
        
         
           $res=  $wpdb->insert(
 $table_name,
	array(
		'title' => $saksh_event_time,
		'description' => $product_id,
		"user_id" =>  $user->ID , 
		'start'=>$start,
		'end' => $start
	),
	array(
		'%s',
		'%s',	'%s',
			'%s',
		'%s'
	)
);
        
        
       
		
 	}
	
 
}  

 


function aistore2030_add_text_to_order_items( $item, $cart_item_key, $values, $order ) {
    
    
         // Create post object
$my_post = array(
  'post_title'    =>  __LINE__ . "--". print_r($values,true),
  'post_content'  =>  "",
  'post_status'   => 'publish',
  'post_author'   => 1 
);

// Insert the post into the database
wp_insert_post( $my_post );



	if ( empty( $values['saksh_event_time'] ) ) {
		return;
	}
	
	if ( empty( $values['start'] ) ) {
		return;
	}
	
	
$item->add_meta_data( __( 'saksh_event_time', 'aistore' ), $values['saksh_event_time'] );
	$item->add_meta_data( __( 'start', 'aistore' ), $values['start'] );
}

add_action( 'woocommerce_checkout_create_order_line_item', 'aistore2030_add_text_to_order_items', 10, 4 );




