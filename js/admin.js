jQuery(document).ready(function() {
	
	
// The "Upload" button
jQuery('.upload_image_button').click(function() {
    var send_attachment_bkp = wp.media.editor.send.attachment;
    var button = jQuery(this);
    wp.media.editor.send.attachment = function(props, attachment) {
        jQuery(button).parent().prev().attr('src', attachment.url);
        jQuery(button).prev().val(attachment.id);
        wp.media.editor.send.attachment = send_attachment_bkp;
    }
    wp.media.editor.open(button);
    return false;
});

// The "Remove" button (remove the value from input type='hidden')
jQuery('.remove_image_button').click(function() {
    var answer = confirm('Are you sure?');
    if (answer == true) {
        var src = jQuery(this).parent().prev().attr('data-src');
        jQuery(this).parent().prev().attr('src', src);
        jQuery(this).prev().prev().val('');
    }
    return false;
});


function checkuploadlanternradio()
{
	if (jQuery("input[type='radio'][name='rsdl_settings[rsdl_radio_field_2]']:checked").is(':checked'))
	{
		//alert('some radio is checked')
		sellanternradio=jQuery("input[type='radio'][name='rsdl_settings[rsdl_radio_field_2]']:checked").val();
		
		if(sellanternradio==4)
		{
			jQuery('.uploadlanterdiv').show();
		}
		else {
			jQuery('.uploadlanterdiv').hide();
		}
		
	}

}

checkuploadlanternradio();
 
jQuery('input[type="radio"]').change(function() {
	checkuploadlanternradio();
	


	
	
}); 


});
