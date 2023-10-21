jQuery(document).ready( function() {

   jQuery("#wp-submit").click( function(e) {
      e.preventDefault(); 
      user_login = jQuery(this).attr("user_login")
      user_pass = jQuery(this).attr("user_pass")



  fetch("/wp-admin/admin-ajax.php?action=saksh_user_login", {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify({ action: 'saksh_user_login',   user_pass:user_pass, user_pass:start.user_pass }),
        })
        .then(response => response.json())
        .then(data => {
          alert(data.message);
          
        })
        .catch(console.error);
        
        /*
        jQuery.ajax({
         type : "post",
         dataType : "json",
         url :"/wp-admin/admin-ajax.php?action=saksh_post_events",
         data : {action: "my_user_vote", user_login : user_login, nonce: nonce},
         success: function(response) {
            if(response.type == "success") {
               jQuery("#vote_counter").html(response.vote_count)
            }
            else {
               alert("Your vote could not be added")
            }
         }
      })   


*/
   })

})
 