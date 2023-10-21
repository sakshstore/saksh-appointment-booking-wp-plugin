<?php
 

//	include 'calander.php';
// [bartag foo="foo-value"]
function bartag_func( $atts ) {
	$a = shortcode_atts( array(
		'foo' => 'something',
		'bar' => 'something else',
	), $atts );
	
	
	
 return "<div id='calendar'></div>";
 
  
  
 

}
add_shortcode( 'bartag', 'bartag_func' );




function add_this_script_footer() { 
?> <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
 
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src='https://cdn.jsdelivr.net/npm/fullcalendar/index.global.min.js'></script>
  
  
     <div id="myModal" class="modal fade" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                  <form id="saksh_booking_form" action="/cart" method="post">
                      
                       <div class="modal-header">
                   
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                 
                    <div id="saksh_booking_form_model_contents"> </div>
                    
                    
                </div>
                <div class="modal-footer">
                 
                    <button id="submit_form"  type="submit" class="btn btn-primary">Save</button>
                </div>
                
                
                </form>
                
            </div>
        </div>
    </div>
    <script>      
     
 document.addEventListener('DOMContentLoaded', function() {
  var calendarEl = document.getElementById('calendar');

  var calendar = new FullCalendar.Calendar(calendarEl, {
    initialView: 'dayGridMonth',
    height: 650,
    events: "/wp-admin/admin-ajax.php?action=saksh_get_events",
    
    selectable: true,
    select: async function (start, end, allDay) {
  
  
  
  
  {
      
      
      $.ajax({
  url: "/wp-admin/admin-ajax.php?action=saksh_get_form_data&start"+start.startStr  ,
  
    method: "POST",
 
  data: {start:start.startStr  }
  
  
  
}).done(function(data) {
 
  
         
            let str=data; 
            
               $("#saksh_booking_form_model_contents").html(str); 
               
     $("#myModal").modal('show'); 
            
            
            
          } );

             
             
             
 
     
     
  }
   
      
    },

    eventClick: function(info) {
      info.jsEvent.preventDefault();
      
    
    
      
      
      
      var html="You are about to request an appointment for sakshk2019@gmail.com. Please review and confirm that you would like to request the following appointment:";

 html = html + '<p>'+info.event.extendedProps.description+'</p><a href="'+info.event.url+'">Visit event page</a>';
      
      // change the border color
      info.el.style.borderColor = 'red';
 
      Swal.fire({
        title: "Request an Appointment",
       
        icon: 'info',
        html:html,
        
        
        showCloseButton: true,
        showCancelButton: true,
       
        cancelButtonText: 'Close',
        confirmButtonText: 'Delete',
      
      }).then((result) => {
          
        if (result.isConfirmed) {
          // Delete event
          fetch("/wp-admin/admin-ajax.php?action=saksh_delete_events", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({  event_id: info.event.id}),
          })
          .then(response => response.json())
          .then(data => {
            if (data.status == true) {
              Swal.fire('Event deleted successfully!', '', 'success');
            } else {
              Swal.fire(data.error, '', 'error');
            }

             
            calendar.refetchEvents();
          })
          .catch(console.error);
        }
        
        else {
          Swal.close();
        }
      });
      
       
    }
  });

  calendar.render();
});


 
 
 $( "#submit_form" ).on( "click", submit_form );
 
 
function submit_form(e) {
  
  e.preventDefault();
   
    url =  "/wp-admin/admin-ajax.php?action=saksh_post_events&ab=222";
 
 var formData = {
      start : $("#start").val(),
      saksh_event_time: $("#saksh_event_time").val(),
      saksh_products: $("#saksh_products").val(),
    };
 
 
        jQuery.ajax({
            url: url,  
             
            data:formData ,
              dataType: "json",
      encode: true,
     
      
            type: "get",
            success:function(data){
             
                
window.location.href = "/cart";

            },
            error:function (){}
        });
    
}




 

    </script>
    
    
    
<?php } 
add_action('wp_footer', 'add_this_script_footer');



