/**
 * Created by viperS on 22-06-2015 г..
 */
var pubUrl = window.location.protocol + '//' + window.location.host;

var msgReminder =
    '<div id="failed-head">Reminder</div>' +
    '<div id="failed-content">Please input your name, code and phone number.</div>' +
    '<div id="success-btn" onclick="down_modal();"><div id="btn-ok" style="" >OK</div></div>';

function down_modal(){
    parent.TINY.box.hide();
}


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

function remainderResult(){
    TINY.box.show({html:msgReminder,width:200,height:200,fixed:false,maskid:'bluemask',maskopacity:40,close:false,closejs:function(){closeFailed()}})
}

$("#countries").on("change",function(){
   var newCode = '+' + $(this).val();
   $("#code").val(newCode);
   $("#clean-code").val($(this).val().trim());
   $("#country_id").val($(this).val().trim());
});

$("#user-name").focusin(function(){
   $(this).css('background-image','none');
});

$("#user-name").focusout(function(){
    console.log("OUT");
   $(this).css('background-image','url("../../assets/web/img/edit_icon.png")');
});

$("#code").focusout(function(){
   $("#clean-code").val($(this).val().trim());
});


$("#submit").click(function(){
    if(($("#code").val().trim().length > 0)&&($("#mobile").val().trim().length > 0)&&($("#user-name").val().trim().length > 0))
          $("#login").submit();
    else
        remainderResult();
});