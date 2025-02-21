let postcall;
jQuery(document).ready(
    function(){
        jQuery('#bo_ss_search_input').on('input', function(){
            var input_container = jQuery(this).closest('.bo_ss_search_input_container');
            if(jQuery(this).val().length > 2){
                if (postcall){
                    postcall.abort();
                }
                showLoader();
                jQuery('.bo_ss_autosuggest_response').remove();
                jQuery('.bo_ss_autosuggest_container').remove();

                var data = {
                    action: 'bo_ss_search',
                    bo_ss_search: jQuery(this).val()
                };

                postcall = jQuery.post(bo_ss_ajax_object.ajaxurl, data, function(response) {
                    hideLoader();
                    jQuery(input_container).append('<div class="bo_ss_autosuggest_container"></div>');
                    if(response.length > 0){
                        for (var i = 0; i < response.length; ++i) {
                            var to_append = '<div class="bo_ss_autosuggest_response"><div>';
                            
                            //Product Image
                            if(response[i].show_thumbnail == 'on' && response[i].type == 'product'){
                                to_append += '<div><img style="width:50px; height: auto;" src="'+response[i].img_url+'"></div>';
                            }
                            //Title and Link
                            to_append += '<div><div class="bo_ss_autosuggest_title"><a href="'+response[i].link+'">'+response[i].title+'</a>';
                            //Category title
                            if(response[i].show_cat == 'on' && response[i].type == 'product'){
                                to_append += '<p>'+response[i].cat_title+'</p>';
                            }
                            //Category title
                            if(response[i].show_price == 'on' && response[i].type == 'product'){
                                to_append += '<p>'+response[i].price+'</p>';
                            }
                            to_append += '</div></div>';
                            
                            jQuery('.bo_ss_autosuggest_container').append(to_append);
                        }
                    }
                    else{
                        jQuery('.bo_ss_autosuggest_container').append('<p>'+bo_ss_ajax_object.not_found+'</p>');
                    }
                    
                    jQuery('.bo_ss_autosuggest_container').append('<div class="bo_ss_autosuggest_all_res">'+bo_ss_ajax_object.show_results+'</div>');
            	});

            }
        });

        jQuery(document).mouseup(function(e)
        {
            var container =jQuery(".bo_ss_autosuggest_container");
            if (!container.is(e.target) && container.has(e.target).length === 0)
            {
                container.hide();
            }
        });

        jQuery('.bo_ss_search_input_container').on('click', '.bo_ss_autosuggest_response', function(e){
            var href = jQuery(this).find('a').attr('href');
            window.location.href = href;
        });

        jQuery('.bo_ss_search_input_container').on('click', '.bo_ss_autosuggest_all_res', function(e){
            jQuery(this).closest('.bo_ss_search_input_container').find('form').submit();
        });
    }
);

function showLoader(){
    jQuery('.bo_ss_loader').show();
}

function hideLoader(){
    jQuery('.bo_ss_loader').hide();
}
