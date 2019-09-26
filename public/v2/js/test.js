/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$('input#addBrand').keyup('input', function (){
   var getData = $('input#addBrand').val();
   
   $('div#brands').html(getData);
});
