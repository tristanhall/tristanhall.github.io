jQuery(function() {
    jQuery('.mobileNavToggle').click(function() {
        jQuery(this).parents('#primaryNav').first().find('ul.menu').first().slideToggle();
    })
});