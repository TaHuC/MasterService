$(() => {
    $(document).on({
        ajaxStart: function () {
            Materialize.toast('Loading...', 3500);
        },
        ajaxStop: function () {

        }
    });
});