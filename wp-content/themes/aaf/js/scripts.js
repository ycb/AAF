(function($){
    $(function($) {
        //comment submit button
        $('#respond').find('input[type=submit]').addClass('btn theme-btn');

        $("a[rel^='prettyPhoto']").prettyPhoto({
            social_tools: false
        });

        $('.site-title').html('THE PRESCRIPTION TO<br /> END VIOLENCE AND CHANGE LIVES');
    });
})(jQuery);
