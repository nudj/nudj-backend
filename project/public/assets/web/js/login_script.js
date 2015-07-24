/**
 * Created by viperS on 22-06-2015 г..
 */

$(window).load(function(){
    var picker = $('.selectpicker');

    picker.selectpicker('val', 'United Kingdom-44-GB');
    $('#country_code').val("GB");

    if( /Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent) ) {
        picker.selectpicker('mobile');
    }
    else{
        picker.selectpicker({
            style: 'btn-info',
            size: 6
        });
    }

});

function remainderResult(message){

    var title = $("#titleModal");
    var body = $("#bodyModal");
    var modal = $("#nudjModal");

    switch (message){
        case "msgReminderOne":
            title.html("Reminder");
            body.html("<p>Please input your name.</p>");
            modal.modal('show');
            break;
        case "msgReminderTwo":
            title.html("Reminder");
            body.html("<p>Please input your phone number.</p>");
            modal.modal('show');
            break;
        case "msgReminderThree":
            title.html("Reminder");
            body.html("<p>Please input your name and phone number.</p>");
            modal.modal('show');
            break;
    }

}

$("#countries").on("change",function(){

   var origVal = $(this).val().trim().split("-");
   var newCode = '+' + origVal[1];

   $("#code").val(newCode);
   $("#clean-code").val($(this).val().trim());
   $("#country_id").val($(this).val().trim());
   $("#country_code").val(origVal[2]);
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
        $("#name").val( $(this).val());
    }
});


$("#code").focusout(function(){
   $("#clean-code").val($(this).val().trim());
});


$("#submit").click(function(){
    var msg = '';
    var check = '';
    var mobile = $("#mobile");
    var username = $("#user-name");

    if(username.val().trim().length <= 0){
        check = check+"N";

    }
    if(mobile.val().trim().length <= 0){
        check = check+"P";
    }

    switch (check){
        case "":
            var inPhone = $("#code").val() + mobile.val();
            $("input[name=phone]").val(inPhone);
            $("#login").submit();
            break;
        case "N" :
            msg = 'msgReminderOne';
            remainderResult(msg);
            break;
        case "P" :
            msg = 'msgReminderTwo';
            remainderResult(msg);
            break;
        case "NP" :
            msg = 'msgReminderThree';
            remainderResult(msg);
            break;
    }

});