$(() => {
    $('#loadOrderBtn').on('click', getOrderFunc);
    $('#idOrder').keypress(function(e){
        console.log(e);
        if(e.which == 13){
            getOrderFunc();
        }
    });
});

function getOrderFunc() {
    let getOrderId = $('#idOrder');

    if(getOrderId.val().length === 0){
        $('nav.navbar').next().before($('<div class="alert alert-danger">').text('Order Id do not empty!!!'));
        setTimeout(function() {
            $('.alert-danger').fadeOut();
            getOrderId.focus();
        }, 2000);
        return;
    }

    if(isNaN(getOrderId.val())){
        getOrderId.val('');
        $('nav.navbar').next().before($('<div class="alert alert-danger">').text('Order Id do not a number!!!'));
        setTimeout(function() {
            $('.alert-danger').fadeOut();
            getOrderId.focus();
        }, 2000);
        return;
    }

    remote.getParams('/order/productId/'+getOrderId.val(), 'get')
        .then((e) => {
            if(e !== 'orderNull'){
                $('nav.navbar').next().before($('<div class="alert alert-success">').text('Order loading...'));
                window.location.href = '/product/'+e;
            } else {
                $('nav.navbar').next().before($('<div class="alert alert-danger">').text('Order not found!!!'));
                setTimeout(function() {
                    $('.alert-danger').fadeOut();
                    getOrderId.focus();
                }, 2000);
                return;
            }
        });
}