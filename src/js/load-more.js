jQuery(document).ready(function () {
    let currentPage = 1;

    jQuery('#load-more').on('click', function () {
        currentPage++; // Do currentPage + 1, because we want to load the next page
        
        jQuery.ajax({
            type: 'POST',
            url: '/wp-admin/admin-ajax.php',
            dataType: 'html',
            data: {
                action: 'weichie_load_more',
                paged: currentPage,
            },
            success: function (res) {
                jQuery('.documents-archive__row').append(res);
            }
        });
    });
});