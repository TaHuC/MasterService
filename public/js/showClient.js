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
        product.typeId = Number($(this).find('input').val());
        let textType = $(this).text();
        $('#typeCheckBox').removeClass('typeCheckBox');

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
        let resultBrand = [];

        if(brand.length === 0) {
            return;
        }

        showBrand.fadeIn();

        remote.getParams('/brand/select/', 'get', `${brand}/${product.typeId}`)
            .then(data => {
                let check = false;
                $(data).each((i) => {
                    if(data[i].title.toLowerCase() === brand.toLowerCase()) {
                        return check = true;
                    }
                });

                if(data.length === 0 || check !== true){
                    resultBrand.push($(`<p data-brand="${brand}" data-status="new">${brand} <button class="btn-flat green-text waves-effect waves-light right-align"><i class="material-icons">add</i></button></p>`)
                        .on('click', brandFun));
                }
                    
                for(let getBrand of data) {
                    resultBrand.push($(`<p data-brand="${getBrand.title}" data-status="old">${getBrand.title} <button class="btn-flat green-text waves-effect waves-light right-align"><i class="material-icons">open_in_new</i></button></p>`)
                        .on('click', brandFun));
                }

                showBrand.html(resultBrand);
                resultBrand = [];
            });

        function brandFun(e) {
            e.preventDefault();
            let brandData = $(this).attr('data-brand');
            let brandStatus = $(this).attr('data-status');

            if(brandStatus === 'old'){
                remote.getParams('/brand/select/', 'get', `${brandData}/${product.typeId}`)
                    .then(data => {
                        product.brandId = data[0].id;
                        $('#showBrand').empty().hide();
                        $('#brand').val(data[0].title).attr('disabled', 'true');
                        modelDiv.fadeIn(() => {
                            $('#model').focus();
                        });
                    });

            } else {
                let dataSend = {
                    brand: brandData,
                    typeId: product.typeId,
                    _token: product._token
                };

                console.log(dataSend);
                remote.getParams('/brand', 'post', dataSend)
                    .then( function(data){
                        product.brandId = data;
                        Materialize.toast(`Brand: ${dataSend.brand}, added`, 2500);
                        $('#showBrand').empty().hide();
                        $('#brand').attr('disabled', 'true');
                        modelDiv.fadeIn(() => {
                            $('#model').focus();
                        });

                    });
            }
        }
    });



    modelDiv.find('input').keyup(() => {
        let model = modelDiv.find('input').val();
        let showModel = $('#showModel');
        let resultModel = [];

        if(model.length === 0) {
            return;
        }

        showModel.fadeIn();

        remote.getParams('/model/select/', 'get', `${model}/${product.brandId}`)
            .then(data => {
                let check = false;
                $(data).each((i) => {
                    if(data[i].title.toLowerCase() === model.toLowerCase()) {
                        return check = true;
                    }
                });

                if(data.length === 0 || check !== true){
                    resultModel.push($(`<p data-model="${model}" data-status="new">${model} <button class="btn-flat green-text waves-effect waves-light right-align"><i class="material-icons">add</i></button></p>`)
                        .on('click', modelFun));
                }

                for(let getModel of data) {
                    resultModel.push($(`<p data-model="${getModel.title}" data-status="old">${getModel.title} <button class="btn-flat green-text waves-effect waves-light right-align"><i class="material-icons">open_in_new</i></button></p>`)
                        .on('click', modelFun));
                }

                showModel.html(resultModel);
                resultModel = [];

            });

        function modelFun(e) {
            e.preventDefault();

            let modelData = $(this).attr('data-model');
            let modelStatus = $(this).attr('data-status');

            if(modelStatus === 'old') {
                remote.getParams('/model/select/', 'get', `${modelData}/${product.brandId}`)
                    .then(data => {
                        product.modelId = data[0].id;
                        showModel.empty().hide();
                        $('#model').val(data[0].title).attr('disabled', 'true');
                        commentRow.fadeIn(() => {
                            $('#comment').focus();
                        });
                        $('#saveProduct').removeAttr('disabled');
                    });
            } else {
                let dataSend = {
                    model: modelData,
                    brand: product.brandId,
                    _token: product._token
                };

                remote.getParams('/model', 'post', dataSend)
                    .then( function(data){
                        product.modelId = data;
                        Materialize.toast(`Model: ${dataSend.model}, added`, 2500);
                        showModel.empty().hide();
                        $('#model').attr('disabled', 'true');
                        commentRow.fadeIn(() => {
                            $('#comment').focus();
                        });
                        $('#saveProduct').removeAttr('disabled');
                    });
            }
        }
    });

    $('#saveProduct').on('click', function (e) {
        e.preventDefault();

        product.serial = $('#serial').val();
        product.comment = $('#comment').val() || 'No comment';
        product.clientId = Number($('#clientId').val());

        remote.getParams('/product', 'post', product)
            .then(data => {
                window.location.pathname = '/product/'+data;
            });
    })
});
