$(document).ready(function () {
    $('#addOrder').hide();
    $('#addRepair').hide();

    const product = JSON.parse($('#product').attr('data-content'));
    const cardProduct = $('#productInfo');
    const repair = {};

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
        cardProduct.append(`<p>&numero; ${product.serial}</p>`);
        cardProduct.append(`<p>&#9777; ${product.comment}</p>`);

        remote.getParams('/order/', 'get', product.id)
            .then((data) => {
                if(data.length > 0){
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
        repair.id = data[0].id;

        $('#addOrder').hide();

        let orders = $('#orders');
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

                        let btnHandover = $(`<button class="btn waves-effect green">`).append($('<i class="material-icons">').text(`thumb_up`));
                        let btnFinished = $(`<button class="btn waves-effect orange">`).append($('<i class="material-icons">').text('transfer_within_a_station'));

                        if(dataStatus.id === 1 || dataStatus.id === 2) {
                            $('.section').append(btnHandover).append(btnFinished);
                        } else if(dataStatus.id === 3) {
                            $('.section').append(btnFinished);
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
                        .append($('<p>').text(data[i].price))
                        .append($(`<p>`).text(data[i].deposit))
                        .append($(`<p>`).text(data[i].price - data[i].deposit)))
                );

            tabsInfo.append(orderDetails);


        }
        $('ul.tabs').tabs();
    }
});