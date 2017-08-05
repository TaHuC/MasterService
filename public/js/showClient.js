$(document).ready(function(){
    let typeId = 0
    let _token = $('meta[name="csrf-token"]').attr('content');


    $('#serialDiv').css('display', 'none');
    $('#brandDiv').css('display', 'none');
    $('#modelDiv').css('display', 'none');

    $('.modal').modal();

    $('#typeCheckBox input').on('click', function getType() {
        typeId = $(this).val();
        if($('#brand').val().length !== 0 || $('#model').val().length !== 0) {
            $('#modelDiv').fadeOut('slow');
            $('#brand').val('').removeAttr('disabled');
            $('#model').val('').removeAttr('disabled');
        }

        $('#serialDiv').fadeOut('slow').fadeIn('slow');
        $('#serial').focusin();
        $('#brandDiv').fadeOut('slow').fadeIn('slow');

        $('#brand').keyup(() => {
            let getBrand = $('#brand').val();
            let showBrandDiv = $('#showBrand');

            if(getBrand.length >= 1){
                $.get('/brand/select/' + getBrand + '/' + typeId, function (data) {
                    if(!showBrandDiv.is(':visible')) {
                        showBrandDiv.fadeIn('slow');
                    }
                    if(data.length !== 0) {
                        for (let resultB of data) {
                            showBrandDiv.html(`<p onclick="getBrand('${resultB.title}', ${resultB.id})">${resultB.title}</p>`);
                        }
                    } else {
                        showBrandDiv.html('');
                        showBrandDiv.html(`<p>${getBrand} <span onclick="addBrand('${getBrand}', ${typeId}, '${_token}')" class="btn-flat green-text waves-effect waves-light right-align"><i class="material-icons">add</i></span></p>`);
                    }
                });
            } else {
                showBrandDiv.html('');
                showBrandDiv.fadeOut('slow');
            }
        });
    });

    $('#serial').keyup(() => {
        let getSerial = $('#serial').val();

        if(getSerial.length >= 2) {
            $.get('/product/serial/'+getSerial, function (data) {
                let getData = data;
                let serial = [];
                for (let i = 0; i < getData.length; i++) {
                    serial.push(`<a class="waves-effect waves-light btn-flat" href="/product/${getData[i].id}">${getData[i].serial}</a> `);
                }
                $('.test').html(serial);

                if(serial.length != []) {
                    $('#serial').css("color", "red");
                } else {
                    $('#serial').css('color', 'green');
                }
            });
        }
    });

    $('#genetareSerial').on('click', function () {
        let getDate = new Date();
        let randomString = Math.random().toString(36).slice(2);

        $('#serial').val(''+ getDate.getDate() + getDate.getMonth() + getDate.getFullYear() + randomString);
        $('#serial').css('color', 'green').attr('disabled', 'disabled');
        $('#brand').focus();
    });

    $('#saveProduct').on('click', function () {
       let serial =  $('#serial').val();
       let brand = 0;
       let model = 0;
       let comment = $('#comment').val()||'No comment';
       let clientId = $('#clientId').val();

       $.get('/brand/select/'+$('#brand').val()+'/'+typeId, function (data) {
           if(data.length !== 0) {
               brand = data[0].id;
           }

           $.get('/model/select/' + $('#model').val() + '/' + brand, function (data) {
               if(data.length !== 0) {
                   model = data[0].id;
               }

               if(serial.length !== 0 && brand.length !== 0 && model.length !== 0) {
                   $.post('/product/', {typeId, serial, brand, model, clientId, comment, _token}, function (data) {
                       window.location.pathname = '/product/'+data;
                   });
               }
           });

       });

    });
});
