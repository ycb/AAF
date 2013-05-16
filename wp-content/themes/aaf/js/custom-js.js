jQuery(function(jQuery) {

	if( jQuery.isFunction(jQuery.fn.datepicker) ){
		// function exists, so we can now call it
		jQuery('.datepicker').datepicker();
	}
	
	if( jQuery.isFunction(jQuery.fn.tablesorter) ){
		jQuery(".datagrid.on > table").tablesorter();
	}
	
	jQuery('#media-items').bind('DOMNodeInserted',function(){
		jQuery('input[value="Insert into Post"]').each(function(){
				jQuery(this).attr('value','Use This Image');
		});
	});
	
	jQuery('.custom_upload_image_button').click(function() {
		formfield = jQuery(this).siblings('.custom_upload_image');
		preview = jQuery(this).siblings('.custom_preview_image');
		tb_show('', 'media-upload.php?type=image&TB_iframe=true');
		window.send_to_editor = function(html) {
			imgurl = jQuery('img',html).attr('src');
			classes = jQuery('img', html).attr('class');
			id = classes.replace(/(.*?)wp-image-/, '');
			formfield.val(id);
			preview.attr('src', imgurl);
			tb_remove();
		}
		return false;
	});
	
	jQuery('.custom_clear_image_button').click(function() {
		var defaultImage = jQuery(this).parent().siblings('.custom_default_image').text();
		jQuery(this).parent().siblings('.custom_upload_image').val('');
		jQuery(this).parent().siblings('.custom_preview_image').attr('src', defaultImage);
		return false;
	});
	
	jQuery('.repeatable-add').click(function() {
		field = jQuery(this).closest('td').find('.custom_repeatable li:last').clone(true);
		fieldLocation = jQuery(this).closest('td').find('.custom_repeatable li:last');
		
		var d = new Date();
		var curr_date = d.getDate();
		var curr_month = d.getMonth();
		curr_month++;
		var curr_year = d.getFullYear();
		
        if( !(data_field = jQuery('input', field)).length )
            data_field = jQuery('textarea', field);
            data_field.val(curr_month + "/" + curr_date + "/" + curr_year + '').attr('name', function(index, name) {
			return name.replace(/(\d+)/, function(fullMatch, n) {
				return Number(n) + 1;
			});
		})
		field.insertAfter(fieldLocation, jQuery(this).closest('td'))
		return false;
	});
	
	jQuery('.repeatable-remove').click(function(){
		//var test = jQuery(this).closest('.custom_repeatable').find('li').length < 1;
		if ( jQuery(this).closest('.custom_repeatable').find('li').length < 2 ) 
		{ 
			//console.log("no li(s)" + test);
			jQuery(this).siblings('input[class$="_repeatable"]').val('');
			return false;
		} 
		else 
		{ 	//console.log("has li(s)" + test);
			jQuery(this).parent().remove();
			return false;
		};
	});
	
	if( jQuery.isFunction(jQuery.fn.sortable) ){
		// function exists, so we can now call it
		jQuery('.custom_repeatable').sortable({
			opacity: 0.6,
			revert: true,
			cursor: 'move',
			handle: '.sort'
		});
	}
	
	
	/// ASSOCIATIONS 
	if( jQuery.isFunction(jQuery.fn.select2) ){
		// function exists, so we can now call it
		jQuery(".bigdrop").select2({
            placeholder: "Associate with:",
            minimumInputLength: 3,
            multiple: true,
            ajax: {
                url: ajaxurl,
                type: 'POST',
                dataType: 'jsonp',
                quietMillis: 100,
                data: function (term, page) { // page is the one-based page number tracked by Select2
                    return {
                        //wordpress wants this var and will map it to our backend method
                        action: 'slidetoplay_search_api_posts',

                        q: term, //search term
                        page_limit: 10, // page size
                        page: page, // page number
                    };
                },
                results: function (data, page) {
                    var more = (page * 10) < data.total; // whether or not there are more results available
 
                    // notice we return the value of more so Select2 knows if more results can be loaded
                    return {results: data.movies, more: more};
                }
            },
            formatResult: movieFormatResult, // omitted for brevity, see the source of this page
            formatSelection: movieFormatSelection, // omitted for brevity, see the source of this page
            dropdownCssClass: "bigdrop", // apply css that makes the dropdown taller
            initSelection: function(element, callback){
                var data = [];
                var titles = element.attr('id').split('|');
                jQuery(element.val().split(',')).each(function(i, id){
                    data.push({id: id, title: titles[i]});
                });
                return callback(data);
            }
        });
	}	
	
	//REVIEWS LINK TO GAME ASSOCIATION
	if( jQuery.isFunction(jQuery.fn.select2) ){
		// function exists, so we can now call it
		jQuery(".bigdrop_reviews").select2({
            placeholder: "Search for a game to link to",
            minimumInputLength: 3,
            multiple: true,
            ajax: {
                url: ajaxurl,
                type: 'POST',
                dataType: 'jsonp',
                quietMillis: 100,
                data: function (term, page) { // page is the one-based page number tracked by Select2
                    return {
                        //wordpress wants this var and will map it to our backend method
                        action: 'slidetoplay_games_search_api_posts',

                        q: term, //search term
                        page_limit: 10, // page size
                        page: page, // page number
                    };
                },
                results: function (data, page) {
                    var more = (page * 10) < data.total; // whether or not there are more results available
 
                    // notice we return the value of more so Select2 knows if more results can be loaded
                    return {results: data.movies, more: more};
                }
            },
            formatResult: movieFormatResult, // omitted for brevity, see the source of this page
            formatSelection: movieFormatSelection, // omitted for brevity, see the source of this page
            dropdownCssClass: "bigdrop", // apply css that makes the dropdown taller
            initSelection: function(element, callback){
                var data = [];
                var titles = element.attr('id').split('|');
                jQuery(element.val().split(',')).each(function(i, id){
                    data.push({id: id, title: titles[i]});
                });
                return callback(data);
            }
        });
	}	
	
	//// FUNCTIONS FOR THIS EXAMPLE MIKE YOU CAN DELETE THIS I GUESS LEFT IT IN CASE YOU NEEDED TO SEE HOW IT WORKED
    function movieFormatResult(movie) {
        var markup = "<table class='movie-result'><tr>";
        if (movie.icon !== undefined) {
            markup += "<td class='movie-image'><img src='" + movie.icon + "'/></td>";
        }
        markup += "<td class='movie-info'><div class='movie-title'>" + movie.title + "</div>";
        if (movie.price !== undefined) {
            markup += "<div class='movie-synopsis'>$" + movie.price + " (v" + movie.version + ")</div>";
        }
        else if (movie.description !== undefined) {
            markup += "<div class='movie-synopsis'>" + movie.description + "</div>";
        }
        markup += "</td></tr></table>"
        return markup;
    }

    function movieFormatSelection(movie) {
        return movie.title;
    }



});
