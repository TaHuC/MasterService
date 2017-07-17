$(document).ready(function(){
    $('.modal').modal();

    $('#typeCheckBox input').on('click', function getType() {
        let typeId = $(this).val();

        $('#brand').keyup(() => {
            let getBrand = $('#brand').val();

            $.get('/brand/select/'+getBrand + '/' + typeId, function (data) {
                console.log(data);
            });
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

        $('#serial').val(''+getDate.getDate()+getDate.getMonth()+getDate.getFullYear()+randomString);
        $('#serial').css('color', 'green');
    });
});
