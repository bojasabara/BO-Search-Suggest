jQuery(document).ready(function($){
    $('.bo_ss_color_picker').wpColorPicker();
    $('#bo_remove_transient').on('click', function(){
        /* TODO: ajax to delete transients */
        var data = {
			'action': 'delete_bo_ss_transient'
		};
		jQuery.post(ajaxurl, data, function(response) {
            location.reload();
        });
			
    });
});