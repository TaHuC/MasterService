$(document).on("keypress", ":input:not(textarea)", function (e) {
    var code = e.keyCode || e.which;
    if (code == 13) {
        e.preventDefault();
        return false;
    }
});


$(document).ready(function () {
    $(function () {
        $("input").each(function () {
            var idInput = $(this).attr('id');
            if (idInput === 'serial') {
                $(this).keyup(function () {
                    if ($(this).val() === 'nqma' || $(this).val() === 'NQMA' || $(this).val() === 'niqma' || $(this).val() === 'NIAMA' || $(this).val() === 'Niama' || $(this).val() === 'Nqma' || $(this).val() === 'Няма' || $(this).val() === 'няма' || $(this).val() === 'НЯМА') {
                        alert('Защо се пишат глупости!!!');
                        $(this).val('');
                    }
                });
            }
        });
    });

    // message sm send to inbox.php
    $('#sendMess').click(function () {
        var userMess = $('#userMess').val();
        var textMess = $('#textMess').val();
        var smMess = $('#smMess').val();

        if (textMess != '') {
            $.post('addMess.php', {textMess: textMess, userMess: userMess, smMess: smMess}, function () {
                $('#textMess').val('');
            });

        } else {
            $('#textMess').attr('style', 'border: 1px solid red;')
        }
    });
    // end message sm

    // proverka za popylnini poleta

    $('#priceHour').keyup(function () {
        var priceGet = $('#priceHour').val();
        if (priceGet >= 1) {
            var priceOk = 'da';
        } else {
            $('#priceHour').val('');
        }
    });

    $('#dateHour').change(function () {

    });

    $('#btnHour').click(function () {
        var infoGet = $('#infoHour').val();
        var priceGet = $('#priceHour').val();
        var getDate = new Date();
        var dateSet = new Date($('#dateHour').val());

        if (getDate > dateSet) {
            alert('Неможе да изберете задна дата!');
            $('#dateHour').val('');
            $('#dateHour').css('border', '1px solid red');
        } else {
            var dateOK = 'ok';
        }

        if (infoGet.length < 4) {
            $('#infoHour').css('border', '1px solid red');
        } else {
            var infoOK = 'ok';
        }

        if (priceGet < 1) {
            $('#priceHour').css('border', '1px solid red');
        } else {
            var priceOK = 'ok';
        }


        if (infoOK === 'ok' && priceOK === 'ok' && dateOK === 'ok') {
            var clHour = $('#clHour').val();
            var clHourAdd = $('#clHourAdd').val();
            var timeEnd = $('#timeEnd').val();
            var clToken = $('#clToken').val();
            var dateGet = $('#dateHour').val();

            $.post('add.php', {infoGet: infoGet, priceGet: priceGet, dateGet: dateGet, clHourAdd: clHourAdd, clHour: clHour, clToken: clToken, timeEnd: timeEnd}, function () {
                $('#warningHour').html('Записване на час <small class="bg-success">Часът беше записан успешно</small>');
                setInterval(function () {
                    $(location).attr('href', 'index.php');
                }, 1500);
            });
        }

    });
    $(function () {
        $('#imgStore').change(function () {
            if (this.files.length > 3) {
                $('#imgStore').val('').css('border', '1px solid red');
                $('#imgLabel').css('color', 'red');
            }
        });
    });

    $(function () {
        $('#imgStore2').change(function () {
            if (this.files.length > 3) {
                $('#imgStore2').val('').css('border', '1px solid red');
                $('#imgLabel2').css('color', 'red');
            }
        });

    });

    $('#egnInput').on('input', function () {
        var checkNum = $(this).val();
        if (!Number(checkNum)) {
            $(this).val('');
        }
    });


    $('#addNote').click(function () {
        var getNote = $('#newNote').val();
        var userId = $('#userNote').val();
        var getData = $('#getDate').val();

        if (getNote !== '') {
            $.post('addNote.php', {getNote: getNote, userId: userId}, function (data) {
                $('#newNote').val('');
                var showDiv = '<!-- Start Panel --> <div class="panel panel-info" id="' + data + '"><div class="panel-heading"><button class="close" id="dellNote" getId="' + data + '">&times;</button><h5 class="panel-title">' + getData + '</h5></div><div class="panel-body bg-info">' + getNote + '</div></div>';
                $('#showNote').append(showDiv);
                showDiv.fadeIn('slow');
            });
        } else {
            $('#newNote').css('border', '1px solid red');
        }
    });

    $(function () {
        $('button').click(function () {
            var getId = $(this).attr('id');
            if (getId === 'dellNote') {
                var dellNote = $(this).attr('getId');
                var getIdDiv = $('div').attr('id');
                $('div#' + dellNote).fadeOut("slow");

                $.post('dellNote.php', {dellNote: dellNote}, function (data) {
                    $('#noteTitle').append('<small style="color: green;" id="compNote">Бележката е изтрита</small>');
                    setTimeout(function () {
                        $('small').fadeOut('slow');
                    }, 1000);
                });
            }
        });
    });

    $('#btnTask').click(function () {
        var task = $('#taskAdd').val();
        var userId = $('#userIdTask').val();
        var fromUser = $('#fromUser').val();

        if (fromUser === userId) {
            $.post('task.php', {task: task, userId: userId}, function (data) {
                $('.task-sm-add').fadeOut('slow');
                $('#taskAdd').val('');
                });
        } else {
            $.post('task.php', {task: task, userId: userId, fromUser: fromUser}, function (data) {
                $('.task-sm-add').fadeOut('slow');
                $('#taskAdd').val('');
            });
        }
    });
});

function taskClick(id) {
    var taskId = id;
	var status = confirm('Сигурен ли си че искаш да приключиш задачата?');
if(status === false){
return false;
}else {

    $.post('task.php', {taskId: taskId}, function () {
        $('#task_' + id).fadeOut('slow');
    });
}
}
