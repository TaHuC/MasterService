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
                        id: `<h6 class="title">${data[i].id}</h6>`,
                        client: data[i].product.client.name + ` <p class="text-muted">${data[i].product.client.idNumber === '0' ? '' : 'ID: '+ data[i].product.client.idNumber}</p>`,
                        phone: data[i].product.client.phone,
                        serial: data[i].product.serial,
                        problem: data[i].problem,
                        status: data[i].status.status,
                        price: data[i].price+'лв.',
                        url: `<a class="btn btn-link" href="/product/${data[i].productId}"><i class="material-icons">assignment</i></a> <a class="btn btn-link" href="/client/${data[i].product.clientId}"><i class="material-icons">assignment_ind</i></a>`
                    }
                    //resultOrder[i].push(data[i].status[0].status);
                }

                // Orders table
                $('#orderTable').DataTable({
                    data: resultOrder,
                    columns: [
                        {
                            data: 'id'
                        },
                        { data: 'client' },
                        { data: 'phone' },
                        { data: 'serial' },
                        { data: 'problem' },
                        { data: 'status' },
                        {
                            class: 'text-right',
                            data: 'price'
                        },
                        {
                            class: 'text-right',
                            data: 'url'
                        }
                    ],
                    "order": [[0, 'desc']],
                    "lengthMenu": [[10, 50, 100, -1], [10, 50, 100, "All"]]
                });
            });
    })();
    
    function finalOrders() {
        let finalOrders = $('#finalOrders').find($('#completedOrders'));

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
        let ordersDiv = $('#lastOrders').find($('#lastOrder'));

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