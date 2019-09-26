/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function () {
    $('#underGroupDiv').hide();
    $('#underGroup').change(function () {
        if (this.checked) {
            $('#underGroupDiv').fadeIn('slow');

        } else {
            $('#underGroupDiv').fadeOut('slow');
        }
    });
    
    
    //add stoke
    $('#add_stock').attr('style', 'display: none;');
    var stoke = $('#add_stock').val();
    if(stoke !== null){
       $('#add_stock').removeAttr('style'); 
    }
    $('#stock').keyup(function (){
        if($(this).val().length) {
            $('#add_stock').removeAttr('style');
        } else {
            $('#add_stock').attr('style', 'display: none;');
        }
    });
});

