//Add form
// Initialize autocomplete with custom appendTo:

// End add form
// search form JS

$(document).ready(function () {

    $(window).load(function () {
        $('input#siscom').on('input', function () {
            var search = $('input#siscom').val();
            if ($.trim(search) != '') {
                $.post('search.php', {search: search}, function (data) {
                    $('div#show_search').html(data);
                });
            }
        });

        $('input#siscom').focusout(function () {
            setTimeout(function () {
                $('input#siscom').val('');
                $('div#show_search').html('');
            }, 300);
        });
    });

    $('i#dis_user').click(function () {
        var uId = $(this).attr('data-uId');
        var aCheck = $(this).attr('data-aCheck');
        $.post('adminaction.php', {eUser: "yes", uId: uId, aCheck: aCheck}, function () {

        });

        if (aCheck === '1') {
            $(this).attr('class', 'fa fa-plus');
            $(this).attr('data-aCheck', '0');
        } else {
            $(this).attr('class', 'fa fa-remove');
            $(this).attr('data-aCheck', '1');
        }
    });
    // end search form 
    function redirectTest() {
        setTimeout($(location).attr('href', 'device.php?order=<?php echo $order->id; ?>'), 500000);
    }

    //check inbox sm icon
    $(function () {
        setInterval(function () {
           $.get("numMess.php", function (data){
                $('#showNumMess').html(data);
           });
        }, 300);
    });
    
    //show message
    $('#showMessB').click(function (){
        $.get("showMes.php", function (data){
            $('#menu1').html(data);
        });
    });
    
    $('a#readMess').click(function (){
        var idMess = $(this).attr('value');
        $.post("showMes.php", {idMass: idMess}, function() {
            $('#notification').html('<p class="btn btn-danger">Право бе! много четеш</p>').show();
            setTimeout(function (){
                $('#notification').hide();
            }, 3000);
        });
    });
    
    //Save Time
    $(function (){
        setInterval(function (){
            $.get('saveTime.php', function (data){
                $('#saveTimeView').html(data);
            })
        }, 1000);
    });
    
    $(function (){
        setInterval(function (){
            $.get('numTime.php', function (data){
              $('#saveTimeNum').html(data);  
            }),
            $.get('checkTask.php', function (data){
                $('#taskList').html(data);
            }),
            $.get('numTask.php', function (data){
              $('#taskNum').html(data);  
            })
        }, 1000);
    });
    
    
});