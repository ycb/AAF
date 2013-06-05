(function ($)
{
    $(document).ready(function ()
	{
		
		$('#widgets-left').append($('#widgets-options'));
		
		for(i in restrict_widgets_args.restrict_widgets)
		{
			$("div[id*='"+restrict_widgets_args.restrict_widgets[i]+"'] div").remove();
		}

		for(i in restrict_widgets_args.restrict_class)
		{
			$("div[id*='"+restrict_widgets_args.restrict_class[i]+"-__i__']").remove();
		}

		for(i in restrict_widgets_args.restrict_nonclass)
		{
			$("div[id*='_"+restrict_widgets_args.restrict_nonclass[i]+"']").remove();
		}

		if(restrict_widgets_args.restrict_orphan_sidebar == 1)
		{
			$('.orphan-sidebar').remove();
		}

		$('#options-available-widgets').chosen({
			placeholder_text: restrict_widgets_args.restrict_available_widgets
		});
		$('#options-widgets-selection').chosen({
			placeholder_text: restrict_widgets_args.restrict_widgets_selection
		});
		$('#options-widgets-sidebars').chosen({
			placeholder_text: restrict_widgets_args.restrict_sidebars
		});
		$('#options-widgets-roles').chosen({
			placeholder_text: restrict_widgets_args.restrict_roles
		});

	});

	$(document).on('mouseover', '#widgets-right, .inactive-sidebar', function() {
		
		$(this).find('.restrict-widgets-hide').chosen({
			allow_single_deselect: true,
			disable_search: true
		});
		$(this).find('.restrict-widgets-select').chosen({
			placeholder_text: restrict_widgets_args.placeholder_text
		});

	});
	
	$(document).on('ajaxStop', function() {
		$('#widgets-right .restrict-widgets-hide, .inactive-sidebar .restrict-widgets-hide').chosen({
			allow_single_deselect: true,
			disable_search: true
		});
		$('#widgets-right .restrict-widgets-select, .inactive-sidebar .restrict-widgets-select').chosen({
			placeholder_text: restrict_widgets_args.placeholder_text
		});
	});
	
})(jQuery);