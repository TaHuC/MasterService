$(() => {
    (()=>{
        finalOrders();
        lastOrders();

        remote.getParams('order', 'get')
            .then((data) => {
                //console.log(data);
                let resultOrder = [];
                for(let i = 0; i < data.length; i++) {
                    resultOrder[i] = {
                        id: data[i].id,
                        client: data[i].product.client.name,
                        phone: data[i].product.client.phone,
                        serial: data[i].product.serial,
                        problem: data[i].problem,
                        status: data[i].status.status,
                        price: data[i].price,
                        url: `<a href="/product/${data[i].productId}">Open</a>`
                    }
                    //resultOrder[i].push(data[i].status[0].status);
                }

                $('#orderTable').DataTable({
                    data: resultOrder,
                    columns: [
                        { data: 'id' },
                        { data: 'client' },
                        { data: 'phone' },
                        { data: 'serial' },
                        { data: 'problem' },
                        { data: 'status' },
                        { data: 'price' },
                        { data: 'url' }
                    ]
                });
            });
    })();
    
    function finalOrders() {
        let finalOrders = $('#finalOrders').find($('ul'));

        remote.getParams('/order/params/', 'get', 'complate')
            .then((data) => {
                if(data.length === 0) {
                    finalOrders.append($('<li class="collection-item green lighten-5 center red-text">').text('There are no completed orders yet!'));
                } else {
                    for(let i = 0; i < data.length; i++){
                        remote.getParams('/status/', 'get', data[i].statusId)
                            .then((statusData) => {
                                finalOrders.append($('<li class="collection-item green lighten-5 avatar">')
                                    .append($('<i class="material-icons circle blue white-text">').text('assignment'))
                                    .append($('<span class="title">').text('#'+data[i].id))
                                    .append($('<p>').html(data[i].created_at+'<br>'+statusData.status))
                                    .append($(`<a class="btn-link waves-effect secondary-content" href="/product/${data[i].productId}">`).html('<i class="material-icons green-text">visibility</i>'))
                                )
                            });
                    }
                }
            });

    }

    function lastOrders() {
        let limit = 5;
        let ordersDiv = $('#lastOrders').find($('ul'));

        remote.getParams('/order/params/', 'get', `last/${limit}`)
            .then((data) => {
                if(data.length === 0) {
                    ordersDiv.append($('<li class="collection-item indigo lighten-5 center red-text">').text('There are no completed orders yet!'));
                } else {
                    for(let i = 0; i < data.length; i++){
                        remote.getParams('/status/', 'get', data[i].statusId)
                            .then((statusData) => {
                                ordersDiv.append($('<li class="collection-item indigo lighten-5 avatar">')
                                    .append($('<i class="material-icons circle blue white-text">').text('assignment'))
                                    .append($('<span class="title">').text('#'+data[i].id))
                                    .append($('<p>').html(data[i].created_at+'<br>'+statusData.status))
                                    .append($(`<a class="btn-link waves-effect secondary-content" href="/product/${data[i].productId}">`).html('<i class="material-icons green-text">visibility</i>'))
                                )
                            });
                    }
                }
            });
    }
});