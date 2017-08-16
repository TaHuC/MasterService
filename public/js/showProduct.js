$(document).ready(function () {
    $('.modal').modal();

    const orderDetail = {
        productId: $('#productId').val(),
        _token: $('meta[name="csrf-token"]').attr('content'),

    };
    const orderTableTd = $('#orderTable td');
    const ordetTableTr = $('#orderTable tr');

    $('#price').keyup(() => {
        let price = $('#price');
        if(isNaN(price.val())) {
            price.val('');
        }
    });
    $('#deposit').keyup(() => {
        let deposit = $('#deposit');
        if(isNaN(deposit.val())) {
            deposit.val('');
        }
    });


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
        if($('#problem').val().length <= 3){
            Materialize.toast('The "Problem" field is required min 3 simbol', 2500,'',function(){
                $('#problem').focus();
            });
            return;
        }
        if($('#now').val().length <= 2){
            Materialize.toast('The "Now" field is required min 3 simbol', 2500,'',function(){
                $('#now').focus();
            });
            return;
        }

        orderDetail.problem = $('#problem').val();
        orderDetail.now = $('#now').val();
        orderDetail.password = $('#password').val();
        orderDetail.description = $('#description').val();
        orderDetail.price = $('#price').val();
        orderDetail.deposit = $('#deposit').val();

        remote.getParams('/order/', 'post', orderDetail)
            .then(() => {
                window.location.reload();
            });
    });
});