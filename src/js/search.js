jQuery(function ($) {
    $("#search__form").hide();

    $("#search__toggle").click(function () {
        $("#search__form").toggle("medium", function () {
            $("#search__field").focus();
        });
    });
});