jQuery(document).ready(function () {
    // Hide all copy
    jQuery('.accordion__copy').hide();

    // Indicate that definitions are hidden using aria-expanded
    jQuery('.accordion__button').attr('aria-expanded', false);

    // On click
    jQuery('.accordion__button').click(function () {
        var button = jQuery(this);
        var copy = button.next();

        button.toggleClass('accordion__button--active');

        button.attr('aria-expanded', function (i, attr) {
            return attr == 'true' ? 'false' : 'true'
        });

        copy.slideToggle();
    });
});