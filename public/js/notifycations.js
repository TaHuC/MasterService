$(() => {
    $(document).on({
        ajaxStart: function () {
            console.log('loading')
        },
        ajaxStop: function () {

        }
    });
});