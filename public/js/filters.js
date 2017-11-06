$(() => {
    $('input#filter').keyup(function() {
        let filter = $(this).val();
        filter.toLocaleLowerCase();

        $('table tbody tr').filter(function () {
            $(this).each(function () {
                found = false;
                $(this).children().each(function () {
                    content = $(this).html();
                    //content = content.toLowerCase();
                    if(content.toLowerCase().match(filter))
                    {
                        found = true;
                    }
                });
                if(!found)
                {
                    $(this).hide();
                }
                else
                {
                    $(this).show();
                }
            });
        });
    });
});