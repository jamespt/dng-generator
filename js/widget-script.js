jQuery("#ch_form").submit(function(event) {

  /* stop form from submitting normally */
  event.preventDefault();

 /* get the action attribute from the form element */
 var url = jQuery( this ).attr( 'action' );

 /* Send the data using post */
 jQuery.ajax({
   type: 'POST',
   url: url,
   data: {
       action: jQuery('#dng_action').val(),
       female: jQuery('#dng_female').val(),
       male: jQuery('#dng_male').val(),  
       nonce: jQuery('#dng_nonce_field').val()
   },
   success: function (data, textStatus, XMLHttpRequest) {
    jQuery('#dng-message').html("Successfully added "+data+" names");

    setTimeout(function(){
      jQuery('#dng-message').html("");
    }, 4000);
   },
   error: function (XMLHttpRequest, textStatus, errorThrown) {
       console.log(textStatus);
   }
 });

});