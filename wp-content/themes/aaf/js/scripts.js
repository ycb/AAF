(function($){
    $(function($) {
        //comment submit button
        $('#respond').find('input[type=submit]').addClass('btn theme-btn');

        $("a[rel^='prettyPhoto'], a.thickbox, .gallery-item a").prettyPhoto({
            social_tools: false,
            theme: 'facebook'
        });

        //$('.site-title').html('THE PRESCRIPTION TO<br /> END VIOLENCE AND CHANGE LIVES');
    });

    $(window).resize(function(){
		if ($(window).width() <= 979){	
			// do something here
			$('.entry-content .meta-nav').addClass('btn-large btn-block');
		} else {
			$('.entry-content .meta-nav').removeClass('btn-large btn-block');
		}
	});
})(jQuery);
