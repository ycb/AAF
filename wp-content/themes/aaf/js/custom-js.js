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
		preview = jQuery(this).siblings('.custom_pslide_image');
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
		jQuery(this).parent().siblings('.custom_pslide_image').attr('src', defaultImage);
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

});
