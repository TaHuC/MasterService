$(() => {
    //getOrder();
    getDevices()
});

function getOrder(){
     remote.getParams('order', 'get')
        .then((data) => {
            //console.log(data[0]);
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
                    url: `<a class="btn btn-sm btn-outline-light" href="/product/${data[i].productId}" data-toggle="tooltip" data-placement="top" title="Отвори поръчката"><i class="material-icons">assignment</i></a> <a class="btn btn-sm btn-outline-light" href="/client/${data[i].product.clientId}" data-toggle="tooltip" data-placement="top" title="Отвори клиента"><i class="material-icons">assignment_ind</i></a>`
                }
                $(function () {
                    $('[data-toggle="tooltip"]').tooltip()
                });
                //resultOrder[i].push(data[i].status[0].status);
            }
            
            $('#orderTable').DataTable({
                data: resultOrder,
                responsive: true,
                columns: [
                    {
                        data: 'id'
                    },
                    { data: 'client' },
                    { data: 'phone' },
                    
                    { data: 'serial' },
                    // { data: 'problem' },
                    { data: 'status' },
                    // {
                    //     class: 'text-right',
                    //     data: 'price'
                    // },
                    {
                        class: 'text-right',
                        data: 'url'
                    },
                   
                ],
                "order": [[0, 'desc']],
                "lengthMenu": [[5, 50, 100, -1], [5, 50, 100, "All"]]
            });
        });
};

async function getClients() {
    return allClients = await remote.getParams('clients', 'get')
    .then((results) => {
        return results;
    })
}

async function getDevices() {
    $('#devicesTable').DataTable({
        'processing': true,
        'language': {
        'processing': 'Зареждане...'
        },
        'serviceSide': true,
        'ajax': {
            "url": "devices/",
            "dataSrc": ""
        },
        "columns": [
            {"data": "data[0].client"},
            {"data": "data[0].phone"},
            {"data": "data[0].device"},
            {"data": "data[0].serial"},
            {
                "data": "data[0].url"
            }
        ]
    })
}