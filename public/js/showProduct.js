$(document).ready(function () {
    $('.modal').modal();
    let productId = $('#productId').val();
    let _token = $('meta[name="csrf-token"]').attr('content');
    let orderTableTd = $('#orderTable td');
    let ordetTableTr = $('#orderTable tr');

    if(orderTableTd[2] != undefined) {
        if(orderTableTd[2].dataset['status'] < 3) {
            $('#newOrderShow').attr('disabled', 'disabled');
            $('#formOrder').hide();
        } else {
            $('#orderInfo').hide();
        }
    } else {
        $('#orderInfo').hide();
    }


    $(ordetTableTr).on('click', function () {
        alert('test');
    });

    $('#newOrderShow').on('click', function () {
        $('#formOrder').hide();
        $('#formOrder').fadeIn('slow');
    });

    $('#saveNewProblem').on('click', function () {
       let problem = $('#problem');
       let nowStatus = $('#now');
       let password = $('#password');
       let description = $('#description');
       let price = $('#price');

       if(problem.val().length <= 4){
           Materialize.toast('The "Problem" field is required', 2500,'',function(){
               problem.focus();
           });
           return;
       }
        if(nowStatus.val().length <= 2){
            Materialize.toast('The "Now" field is required', 2500,'',function(){
                nowStatus.focus();
            });
            return;
        }

        if(isNaN(price.val())) {
            Materialize.toast('The "Price" field must be a number', 2500,'',function(){
                price.val('');
                price.focus();
            });
            return;
        }

        $.post('/order/', {problem: problem.val(), nowStatus: nowStatus.val(), password: password.val(), description: description.val(), price: price.val(), _token, productId}, function (data) {
            $('#saveOrder').modal('open');
            setTimeout(function () {
                $('#saveOrder h4').fadeIn('slow');
                setTimeout(function () {
                    $('#saveOrder h5').fadeIn('slow').text('#'+data);
                    setTimeout(function () {
                        window.location.reload();
                    }, 4000);
                }, 1500)
            }, 1500);
        });
    });
});