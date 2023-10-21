<?php


function print_login_register_form(){
    
    
    $user = wp_authenticate($username, $password);
if(!is_wp_error($user)) {
	$first_name = $user->first_name;
	echo "Login credentials are valid. First name is $first_name";
} else {
	echo "Invalid login credentials.";
}
}


 function saksh_form_booking()
 {
   $str  = '';
   
 /*  if ( !is_user_logged_in() ) {
   
  $str  .= '    <form name="loginform" id="loginform"    ><p class="login-username"><br /> ';
  
  
  
	  $str  .= '  			<label for="user_login">Username or Email Address</label><br />  ';
  $str  .= '  				<input type="text" name="log" id="user_login" autocomplete="username" class="input" value="" size="20" /><br />  ';
  $str .= '  			</p><p class="login-password"><br />  ';
  $str  .= '  				<label for="user_pass">Password</label><br />  ';
  $str  .= '  				<input type="password" name="pwd" id="user_pass" autocomplete="current-password" spellcheck="false" class="input" value="" size="20" /><br />  ';
  $str  .= '  			</p><p class="login-remember"><label><input name="rememberme" type="checkbox" id="rememberme" value="forever" /> Remember Me</label></p><p class="login-submit"><br />  ';
  $str  .= '  				<input type="button" name="wp-submit" id="wpsubmit" class="button button-primary" value="Log In" /><br />  ';
  $str  .= '  				<input type="hidden" name="redirect_to" value="https://appointmentbook.sakshstore.com/8-2/" /><br />  ';
  $str  .= '  			</p></form>  ';
			
			return $str;
   }
   */
 $start =$_REQUEST['start'];

 
$time_array=array("10-11 AM","11-12 AM","12-1 PM","1-2 PM","2-3 PM","3-4 PM","4-5 PM" );


 $str  = ' <div id="formID" > <label for="saksh_event_time">Select Time</label>';
 
 
 $str  .= '<select id="saksh_event_time" class="swal2-input"  name="saksh_event_time">' ;
 
 
      
            foreach( $time_array as $time_ar ) {

   
    $str .= ' <option value="'.$time_ar.'">'. $time_ar .'</option>'  ;
     


 }
   
    $str .= '</select>' ;
    
    
 
 
 $str  .= '<input type="hidden" name="start" id="start"  value="'.$start.'" />' ;
 
 
     
     
     $args = array(
    'status'            => array(  'publish' ),
  
   
    'tag'               => array() 
    
);

// Array of product objects
$products = wc_get_products( $args ) ;

  $str  .= '  <label for="saksh_products">Select Product</label>';
 $str  .= '<select id="saksh_products" class="swal2-input"  name="saksh_products">' ;
 
 
      
            foreach( $products as $product ) {

   
    $str .= ' <option value="'.$product->get_id().'">'. $product->get_name() .'</option>'  ;
    
    
  
 }
   
    $str .= '</select>  </div>' ;
    
    
 return $str;
 
 
 }
 
 /*
 
 function get_form_data()
 {
     
          
$time_array=array("10-11 AM","11-12 AM","12-1 PM","1-2 PM","2-3 PM","3-4 PM","4-5 PM" );

$ar=array();

$ar['time_array']=$time_array;

 
     
     $args = array(
    'status'            => array( 'draft', 'pending', 'private', 'publish' ),
    'type'              => array_merge( array_keys( wc_get_product_types() ) ),
    'parent'            => null,
    'sku'               => '',
    'category'          => array(),
    'tag'               => array(),
    'limit'             => get_option( 'posts_per_page' ),  // -1 for unlimited
    'offset'            => null,
    'page'              => 1,
    'include'           => array(),
    'exclude'           => array(),
    'orderby'           => 'date',
    'order'             => 'DESC',
    'return'            => 'objects',
    'paginate'          => false,
    'shipping_class'    => array(),
);

// Array of product objects
$products = wc_get_products( $args ) ;

$product_ar=array();
$i=0;
    foreach( $products as $product ) {

   $a=array();
   
   $a[$product->get_id()]= $product->get_name();
 
    
array_push($product_ar,$a);

 }
 
 
 
 
 
$ar['products']=$product_ar;

echo json_encode($ar);
 
    die();
     
 }
 */
function saksh_delete_events() {
    
    


  
$jsonStr = file_get_contents('php://input'); 
$jsonObj = json_decode($jsonStr); 
  $event_id = $jsonObj->event_id; 
    
    
 global $wpdb;
 
 $table_name= $wpdb->prefix ."events";
 
 
 
$result=$wpdb->query(
	$wpdb->prepare(
		" DELETE FROM  $table_name
			WHERE id = %d ",
	         ($event_id )  
        )
);

echo json_encode($result); 

 
    die();

}

 
function saksh_get_events() {
    
    
 global $wpdb;
 
 $table_name= $wpdb->prefix ."events";
 
 
    $results= $wpdb->get_results(
	"
		SELECT *
		FROM $table_name
		 
	"
);




echo json_encode($results); 

 
    die();

}



function saksh_post_events() {
  
 
$jsonStr = file_get_contents('php://input'); 

 
$jsonObj = json_decode($jsonStr); 
 
 
 
 global $wpdb;
 
 $table_name= $wpdb->prefix ."events";
 
 
  
    $start = $_REQUEST['start'];//$jsonObj->start; 
    $end ="";// $jsonObj->end; 
 
   // $event_data = $jsonObj->event_data; 
    
    
  
  
    $saksh_event_time =  $_REQUEST['saksh_event_time'];//$jsonObj->saksh_event_time;
    $saksh_products=$_REQUEST['saksh_products'];// $jsonObj->saksh_products;
 
     
    if(!empty($saksh_event_time)){ 
        
        
      $res=  $wpdb->insert(
 $table_name,
	array(
		'title' => $saksh_event_time,
		'description' => $saksh_products,
		'start'=>$start,
		'end' => $end
	),
	array(
		'%s',
		'%s',
			'%s',
		'%s'
	)
);


if($res==false)
{
    echo json_encode(['error' => 'Event Add request failed!']); 
    die();
}
        
 else
 {
     
//	WC()->cart->empty_cart();
     
     $product_id = $saksh_products; // product ID to add to cart
     
       $cart_item_data = array( 'saksh_event_time' => $saksh_event_time , "start"=>$start);
	 
	  
	  
	WC()->cart->add_to_cart( $product_id , 1, '', array(), $cart_item_data);
	 
	  
	  
	  
	
	
 echo json_encode([  'status' =>true  ]); 
     die();
     
    
    
 }
 

}
 
}

 





 function saksh_get_form_data()
 {
     
     echo saksh_form_booking();
     
     die();
 }
 
 
$ajax_actions=array("saksh_form_booking","saksh_get_form_data","saksh_post_events","saksh_delete_events","saksh_get_events","get_time_list");

foreach($ajax_actions as $ajax_action)
{

add_action( 'wp_ajax_'.$ajax_action, $ajax_action );
add_action( 'wp_ajax_nopriv_'.$ajax_action, $ajax_action );

} 