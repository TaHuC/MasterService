$(document).ready(function () {
    $('.modal').modal();

    const orderDetail = {
        productId: $('#productId').val(),
        _token: $('meta[name="csrf-token"]').attr('content'),

    };
    const orderTableTd = $('#orderTable td');
    const ordetTableTr = $('#orderTable tr');

    $('#price').keyup(priceCheck);
    $('#deposit').keyup(priceCheck);


    function priceCheck() {
        let price = $(this);
        if(isNaN(price.val())) {
            price.val('');
        }
    }

    $('#saveRepair').on('click', saveRepair);
    
    function saveRepair(e) {
        e.preventDefault();
        let values = {
            _token: $('meta[name="csrf-token"]').attr('content'),
            orderId: Number($('#orderDetails').find('h5').text().slice(2)),
            repair: $('#repairForm').find('input[name=repair]').val(),
            description: $('#repairForm').find('textarea').val(),
            price: Number($('#repairForm').find('input[name=price]').val()) || 0
        };

        if(values.repair === "") {
            Materialize.toast('Input (Repair), is not must by empty!', 2500);
            $('#repairForm').find('input[name=repair]').focus();
            return;
        }
        remote.getParams('/repair/', 'post', values)
            .then(() => {
                Materialize.toast('Add repair success.', 2500, '', function() {
                    window.location.reload();
                });
            });
    }

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


    $(ordetTableTr).on('click', getOldOrder);
    
    function getOldOrder() {
        let orders = $(this);
        console.log(orders);
    }

    $('#newOrderShow').on('click', function () {
        $('#formOrder').hide();
        $('#formOrder').fadeIn('slow');
    });

    $('#saveNewProblem').on('click', saveOrder);

    function saveOrder() {
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
    }
});