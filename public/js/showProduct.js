$(document).ready(function () {
    $('.notesList').each(function (i) {
        let noteList = this;
        remote.getParams(`/notes/${$(this).attr('data-orderId')}/order`, 'get')
            .then(function (result) {
                if(result.length !== 0){
                    for(let i = 0; i < result.length; i++){
                        $(noteList).append($('<li class="list-group-item list-group-item-dark">')
                            .append($('<div class="d-flex w-100 justify-content-between">')
                                .append(`<p class="mb-1 col-9">${result[i]['note']}</p>`)
                                .append(`<small>${result[i]['created_at']}</small>`))
                                .append(`<small>${result[i]['user'][0]['name']}</small>`));
                    }
                } else {
                    $(noteList).append('<li><h3>Not notes</h3></li>');
                }
            });
    });
});