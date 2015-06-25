/**
 * Created by viperS on 22-06-2015 г..
 */
var pubUrl = window.location.protocol + '//' + window.location.host;

$(window).load(function(){

    if( /Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent) ) {
        $('.selectpicker').selectpicker('mobile');
    }
    else{
        $('.selectpicker').selectpicker({
            style: 'btn-info',
            size: 6
        });
    }

});

$("#countries").on("change",function(){
   var newCode = '+' + $(this).val();
   $("#code").val(newCode);
});

$("#user-name").focusin(function(){
   $(this).css('background-image','none');
});

$("#user-name").focusout(function(){
   $(this).css('background-image','url("../assets/web/img/edit_icon.png")');
});

$("#submit").click(function(){
    window.location.href = pubUrl + "/submit";
});