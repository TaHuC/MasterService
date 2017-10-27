$(() => {
    $('input#filter').keyup(function() {
        let filter = $(this).val();

        $('table tbody tr').filter(function () {
            console.log(this);
            $(this).each(function () {
                found = false;
                $(this).children().each(function () {
                    content = $(this).html();
                    if(content.match(filter))
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