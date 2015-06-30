/**
 * Created by viperS on 22-06-2015 г..
 */
var pubUrl = window.location.protocol + '//' + window.location.host;

var msgReminderOne =
    '<div id="failed-head">Reminder</div>' +
    '<div id="failed-content">Please input your name.</div>' +
    '<div id="success-btn" onclick="down_modal();"><div id="btn-ok" style="" >OK</div></div>';
var msgReminderTwo =
    '<div id="failed-head">Reminder</div>' +
    '<div id="failed-content">Please input your phone number.</div>' +
    '<div id="success-btn" onclick="down_modal();"><div id="btn-ok" style="" >OK</div></div>';
var msgReminderThree =
    '<div id="failed-head">Reminder</div>' +
    '<div id="failed-content">Please input your phone number and name.</div>' +
    '<div id="success-btn" onclick="down_modal();"><div id="btn-ok" style="" >OK</div></div>';

function down_modal(){
    parent.TINY.box.hide();
}


$(window).load(function(){

    $('.selectpicker').selectpicker('val', 'United Kingdom-44');

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

function remainderResult(message){
    switch (message){
        case "msgReminderOne":
            TINY.box.show({html:msgReminderOne,width:200,height:200,fixed:false,maskid:'bluemask',maskopacity:40,close:false,closejs:function(){closeFailed()}});
            break;
        case "msgReminderTwo":
            TINY.box.show({html:msgReminderTwo,width:200,height:200,fixed:false,maskid:'bluemask',maskopacity:40,close:false,closejs:function(){closeFailed()}});
            break;
        case "msgReminderThree":
            TINY.box.show({html:msgReminderThree,width:200,height:200,fixed:false,maskid:'bluemask',maskopacity:40,close:false,closejs:function(){closeFailed()}});
            break;
    }

}

function closeFailed(){
}

$("#countries").on("change",function(){
   var origVal = $(this).val().trim().split("-");
   var newCode = '+' + origVal[1];
   $("#code").val(newCode);
   $("#clean-code").val($(this).val().trim());
   $("#country_id").val($(this).val().trim());
});

$("#mobile").on("change",function(){

    $("#phone").val($("#code").val() + $("#mobile").val());
});


$("#user-name").on({
    focusin:function(){
        $(this).css('background-image','none');
        },
    focusout:function(){
        $(this).css('background-image','url("../../assets/web/img/edit_icon.png")');
    }
});




$("#code").focusout(function(){
   $("#clean-code").val($(this).val().trim());
});


$("#submit").click(function(){
    var msg = '';
    var check = 0;

    if($("#user-name").val().trim().length <= 0){
        check = check+1;
        msg = 'msgReminderOne';
    }
    if($("#mobile").val().trim().length <= 0){
        check = check+1;
        msg = 'msgReminderTwo';
    }

    switch (parseInt(check)){
        case 0:
            var inPhone = $("#code").val() + $("#mobile").val();
            $("input[name=phone]").val(inPhone);
            $("#login").submit();
            break;
        case 1 :
            remainderResult(msg);
            break;
        case 2 :
            msg = 'msgReminderThree';
            remainderResult(msg);
            break;
    }




});