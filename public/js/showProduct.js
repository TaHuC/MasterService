$(document).ready(function () {
    $('#addOrder').hide();
    $('#addRepair').hide();

    const product = JSON.parse($('#product').attr('data-content'));
    const cardProduct = $('#productInfo');
    const order = {
        '_token': $('meta[name="csrf-token"]').attr('content'),
        'productId': product.id
    }
    const repair = {
        '_token': $('meta[name="csrf-token"]').attr('content'),
    };

    (() => {
        remote.getParams('/type/', 'get', product.typeId)
            .then((data) => {
                product.type = data.title;
                remote.getParams('/brand/', 'get', product.brandId)
                    .then((data) => {
                        product.brand = data.title;
                        remote.getParams('/model/', 'get', product.modelId)
                            .then((data) => {
                                product.model = data.title;
                                domProduct();
                            });
                    });
            });


    })();

    function domProduct() {
        cardProduct.find('span').text(`${product.brand} ${product.model}`);
        cardProduct
            .append(`<p>&numero; ${product.serial}</p>`)
            .append(`<p>&#9777; ${product.comment}</p>`);

        remote.getParams('/order/', 'get', product.id)
            .then((data) => {
                if(data.length > 0){
                    repair.orderId = data[0].id;
                    ordersFunc(data);
                } else {
                    addOrder;
                }
            });
    }
    
    function addOrder() {
        $('#addRepair').hide();
        $('#addOrder').fadeIn();
    }
    
    function ordersFunc(data) {
        //repair.id = data[0].id;

        $('#addOrder').hide();

        let orders = $('#orders');
        orders.html('');
        orders.append($('<div class="card-tabs"></div>'));
        orders.append($('<div class="card-content blue-grey lighten-1"></div>'));
        orders.find('.card-tabs').append($('<ul class="tabs tabs-fixed-width"></ul>'));
        let tabs = orders.find('.tabs');
        let tabsInfo = orders.find('.card-content');
        remote.getParams('/status/', 'get', data[0].statusId)
            .then((dataStatus) => {
                let iconsSet = '';

                if (dataStatus.id === 1){
                    iconsSet = "store";
                    $('#addRepair').fadeIn();
                } else if (dataStatus.id === 2){
                    iconsSet = "build";
                    $('#addRepair').fadeIn();
                } else if (dataStatus.id === 3){
                    iconsSet = "thumb_up";
                } else if (dataStatus.id === 4){
                    iconsSet = "transfer_within_a_station";
                    $('#addRepair').hide();
                    $('#addOrder').fadeIn();
                }

                remote.getParams('/users/', 'get', data[0].userId)
                    .then((dataUser) => {
                        $('#productInfo').append($(`<div class="row center">`)
                            .append($(`<p>`)
                            .append($(`<i class="large material-icons">`).text(iconsSet))
                            .append($('<p>').text(dataStatus.status))
                            .append($('<p>').text(dataUser.name))
                                .append($(`<div class="divider">`))
                                .append($(`<div class="section">`))));

                        let btnHandover = $(`<button class="btn waves-effect green" data-status="3">`).append($('<i class="material-icons">').text(`thumb_up`));
                        let btnFinished = $(`<button class="btn waves-effect orange" data-status="4">`).append($('<i class="material-icons">').text('transfer_within_a_station'));

                        if(dataStatus.id === 1 || dataStatus.id === 2) {
                            $('.section').append(btnHandover.click(changeStatus)).append(btnFinished.click(changeStatus));
                        } else if(dataStatus.id === 3) {
                            $('.section').append(btnFinished.click(changeStatus));
                        } else if(dataStatus.id === 4) {

                        }
                    });
            });

        for (let i = 0; i < data.length; i++) {

            if(i === 0) {
                tabs.append(`<li class="tab"><a class="active waves-effect" href="#${data[i].id}"><h5>#${data[i].id}</h5></a></li>`);
            } else {
                tabs.append(`<li class="tab"><a class="waves-effect" href="#${data[i].id}"><h5>#${data[i].id}</h5></a></li>`);
            }

            let orderDetails = $(`<div id="${data[i].id}">`)
                .append($(`<div class="row white-text">`)
                    .append($(`<div class="col m2 s2">`).append($('<p>').text(data[i].problem)))
                    .append($(`<div class="col m2 s2">`).append($('<p>').text(data[i].now)))
                    .append($(`<div class="col m2 s2">`).append($('<p>').text(data[i].password)))
                    .append($(`<div class="col m4 s4">`).append($('<p>').text(data[i].description)))
                    .append($(`<div class="col m2 s2 right-align">`)
                        .append($('<h5>').text(data[i].price))
                        .append($(`<h5>`).text(data[i].deposit))
                        .append($(`<h5>`).text(data[i].price - data[i].deposit)))
                );

            let list = $('<ul class="collection with-header white">');
            list.append($('<li class="collections-header center">').append($('<h4>').text('Repairs list')));
            remote.getParams('/repair/', 'get', data[i].id)
            .then((dataRepair) => {
                if(dataRepair.length > 0) {
                    for(let i = 0; i < dataRepair.length; i++){
                        remote.getParams('/users/', 'get', dataRepair[i].userId)
                            .then((userRepair) => {
                                list.append($('<li class="collection-item">')
                                    .append($('<span class="title">').text('Repair: '+dataRepair[i].repair))
                                    .append($('<p>').text('Desc: '+dataRepair[i].description)));
                            });
                    }
                } else {
                    list.append($('<li class="collection-item">')
                        .append($('<span class="title">').text('No repairs')));
                }

                orderDetails.append($('<div class="row">').append(list));
            });

            tabsInfo.append(orderDetails);
            $('#addRepair').find('input[name=price]').val(data[0].price);


        }
        $('ul.tabs').tabs();
    }
    
    function changeStatus() {
        let status = $(this).attr('data-status');
        changeSt = {
            '_token': $('meta[name="csrf-token"]').attr('content'),
            'statusId': status
        };

        remote.getParams('/order/'+repair.orderId, 'put', changeSt)
            .then((data)=>{
                console.log(data);
                Materialize.toast('Order status change successfull!');
                clear();
            });
    }

    $('#saveOrder').click(function (e) {
        e.preventDefault();
        order.problem = $('#problem').val();
        order.now = $('#now').val();
        order.password = $('#password').val();
        order.description = $('#description').val();
        order.price = Number($('#price').val());
        order.deposit = Number($('#deposit').val());

        if(order.problem === ''){
            Materialize.toast('Fild PROBLEM must bu not empty!');
            $('#problem').focus();
            return;
        }

        if(order.now === ''){
            Materialize.toast('Fild NOW must bu not empty!');
            $('#now').focus();
            return;
        }

        if(!Number(order.price)){
            order.price = 0;
        }
        if(!Number(order.deposit)){
            order.deposit = 0;
        }

        remote.getParams('/order/', 'post', order)
            .then((data) => {
                console.log(data);
                Materialize.toast('Order create successfull!');
                clear();
            })

    });

    $('#saveRepair').click(function (e) {
        e.preventDefault();
        repair.repair = $('#repair').val();
        repair.description = $('#descriptionRepair').val();
        repair.price = $('#priceRepair').val();

        if(repair === '') {
            Materialize.toast('Repair input not bu empty', 3000);
            $('#repair').focus();
            return;
        }

        remote.getParams('/repair/', 'post', repair)
            .then(() => {
                Materialize.toast('Add repair successfull', 3000);
                clear();
            })
    });

    function clear() {
        let addRepai = $('#addRepair');
        addRepai.find('input').val('')
        addRepai.find('textarea').val('');
        cardProduct.html('');
        cardProduct.append($(`<span class="card-title">`));
        domProduct();
    }
});