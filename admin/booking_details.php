<?php

 
add_action('admin_menu', 'saksh_booking_details_setup_menu');
 
function saksh_booking_details_setup_menu(){
    add_menu_page( 'Saksh booking details', 'Saksh booking details', 'manage_options', 'saksh_booking_details', 'saksh_booking_details_func' );
    
 // remove_menu_page('saksh_booking_details');
}
 
function saksh_booking_details_func(){
    
    
      $id=$_REQUEST['id'];
      
      
 global $wpdb;
 
 $table_name= $wpdb->prefix ."events";
 
 
    $results= $wpdb->get_results(
	"
		SELECT *
		FROM $table_name
		 
	"
);

$result = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $table_name WHERE id = %d",$id) );


echo json_encode($result); 

?>

<button type="button" onclick="saksh_cancel_bookings('<?php echo $result->id; ?>')">Cancel Bookings</button>


<hr />



 <form id="reschedule_booking" action="process.php" method="POST">
        <div id="name-group" class="form-group">
          <label for="name">New Date</label>
          <input
            type="date"
            class="form-control"
            id="new_date"
            name="new_date" 
          />
        </div>
        <input type="hidden" id="id" value="<?php echo $result->id; ?>" name="id" />

        <div id="email-group" class="form-group">
          <label for="email">New Time</label>
          <input
            type="time"
            class="form-control"
            id="new_time"
            name="new_time" 
          />
        </div>

        
        <button type="submit" class="btn btn-success">
          Submit
        </button>
      </form>
      
      



<?php
 
}
 
 
 
 
 
 
 
 add_action( 'admin_footer', 'my_action_javascript' ); // Write our JS below here

function my_action_javascript() { ?>
	<script type="text/javascript" >
	
	


 






	jQuery(document).ready(function($) {
	    
	     jQuery("form#reschedule_booking").submit(function (event) {
     
     
    event.preventDefault();
    
    
    var formData = {
        'action': 'saksh_reschedule_booking',
      'id':jQuery("#id").val(),
            'new_date':jQuery("#new_date").val(),
      'new_time': jQuery("#new_time").val() 
    };
 
	 
		jQuery.post(ajaxurl, formData, function(response) {
			alert('Got this from the server: ' + response);
		});
		
		
		
 
});


	    
	    	  jQuery( ".saksh_cancel_btn_click" ).on( "click", "saksh_cancel_bookings" );
	  
	  
	    
	});
	
	
	    
	  function saksh_cancel_bookings(id)
	  {
	    
	    

		var data = {
			'action': 'saksh_booking_cancel',
			'id': id
		};

		// since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
		jQuery.post(ajaxurl, data, function(response) {
			alert('Got this from the server: ' + response);
		});
		
		
	  }
	  
	  

	</script> <?php
}




function saksh_reschedule_booking() {
	global $wpdb; // this is how you get access to the database

	$id = intval( $_POST['id'] );

 echo $id;
 


 $start=$_POST['new_date'] ;
 $table_name= $wpdb->prefix ."events";
 
 
 $res= $wpdb->query(
	$wpdb->prepare(
		"
                	update $table_name 
                	set start ='%s'
			WHERE id = %d 	",
	       $start, 	$id 
        )
);
 



        echo $res;

	wp_die(); // this is required to terminate immediately and return a proper response
}


 
 
 
add_action( 'wp_ajax_saksh_reschedule_booking', 'saksh_reschedule_booking' );
 
//add_action( 'wp_ajax_saksh_booking_cancel', 'saksh_booking_cancel' );

add_action( 'wp_ajax_saksh_booking_cancel', 'saksh_booking_cancel' );

function saksh_booking_cancel() {
	global $wpdb; // this is how you get access to the database

	$id = intval( $_POST['id'] );
echo $id;
       
 
 $table_name= $wpdb->prefix ."events";
 
 
 $res= $wpdb->query(
	$wpdb->prepare(
		"
                	update $table_name 
                	set status ='cancelled'
			WHERE id = %d 	",
	        	$id 
        )
);
 



        echo $res;

	wp_die(); // this is required to terminate immediately and return a proper response
}


 