/**
 * Created by TaHuC on 5/4/17.
 */
$(document).ready(function () {
    $('#typeDiv').hide();
    $('#brandDiv').hide();
    $('#modelDiv').hide();
    $('#orderDiv').hide();

    $('#setSerial').on('click', function () {
        var date = new Date();
     var random = date.getDate().toString() + date.getMonth().toString() + date.getFullYear().toString() + Math.random().toString(36).replace(/[^a-z]+/g, '');

     $('#serial').val(random);
     $('#typeDiv').fadeIn('slow');
    });

    $('#serial').change(function () {
        var getSerial = $(this).val();
        if(getSerial.length > 4) {
            setTimeout(function () {
                $.get('../product/serial/' + getSerial, function (data) {
                   if(data.length != 0) {
                       for(var i = 0; i < data.length; i++) {
                           $('#showSerial').html("<p class='text-danger'>"+data[i].serial+" <a href='#' class='btn btn-xs btn-danger'>Open</a></p>");
                           $('#typeDiv').fadeOut('slow');
                       }
                   } else {
                        $('#showSerial').html('<p class="text-success">This serial is not found in datebase!</p>');
                        $('#typeDiv').fadeIn('slow');
                   }
                });
            }, 1000);
        }
    });

    $('#typeDivRadio').on('change', function () {
        $('#showSerial').fadeOut('slow');
       var getType = $('input[name="type"]:checked').val();

       if(getType != null) {
           $('#brandDiv').fadeIn('slow');

            $.get('../brand/select/'+getType, function (data) {
                
            });
       }
    });
});