$(() => {
    $('#addDevModal').modal();
    const serialDiv = $('#serialDiv');
    const brandModelRow = $('#brandModelRow');
    const brandDiv = $('#brandDiv');
    const modelDiv = $('#modelDiv');
    const commentRow = $('#commentRow');
    const typeDiv = $('#typeCheckBox');
    const product = {};
    product._token = $('meta[name="csrf-token"]').attr('content');

    serialDiv.hide();
    brandDiv.hide();
    modelDiv.hide();
    brandModelRow.hide();
    commentRow.hide();

    typeDiv.find('div').on('click', setType);

    function setType() {
        product.typeId = $(this).find('input').val();
        let textType = $(this).text();

        typeDiv.fadeOut(() => {
            typeDiv.html(`<h3 class="center">${textType}</h3>`).fadeIn(() => {
                brandModelRow.fadeIn(() => {
                    serialDiv.fadeIn(serialGet);
                });
            });
        });


    }
    
    function serialGet() {
        let serialInput = serialDiv.find('input');
        serialInput.focus();
        serialInput.keyup(() => {
            if(serialInput.val().length > 3) {
                remote.getParams('/product/serial/', 'get', serialInput.val())
                    .then(data => {
                        if(data.length === 0){
                            brandDiv.fadeIn();
                            serialInput.css('color', 'black');
                        } else {
                            brandDiv.fadeOut();
                            serialInput.css('color', 'red');
                            Materialize.toast(`<span>${data[0].serial}</span><a class="btn-flat toast-action white-text red" href="/product/${data[0].id}">&#10174;</a>`, 10000);
                        }
                    });
            }
        });
    }

    brandDiv.find('input').keyup(() => {
        let brand = brandDiv.find('input').val();
        let showBrand = $('#showBrand');

        if(brand.length === 0) {
            showBrand.empty();
            return;
        }

        showBrand.fadeIn();
        showBrand.empty();
        showBrand.append(`<i>Loading...</i>`);
        showBrand.empty();
        remote.getParams('/brand/select/', 'get', `${brand}/${product.typeId}`)
            .then(data => {
                if (data.length === 0) {
                    showBrand.append(`<p>${brand} <button class="btn-flat green-text waves-effect waves-light right-align"><i class="material-icons">add</i></button></p>`);
                } else {
                    for(let getBrand of data) {
                        showBrand.append(`<p>${getBrand.title} <button class="btn-flat green-text waves-effect waves-light right-align"><i class="material-icons">open_in_new</i></button></p>`)
                    }
                }
            });
    });

    function brandFun() {
        
    }
});
