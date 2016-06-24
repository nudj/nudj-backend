
var title = $("#titleModal");
var body = $("#bodyModal");
var modal = $("#nudjModal");
var footer = $("#footerModal");
var original = "";

function spoter(){
    var btnSMS =  $( "#btn-ok" );

    btnSMS.css({"background-color":"#FFF","color":"#1293BD","border":"thin solid #1293BD"});
    var chkr = 0;
    var refPhone = $("#refphone");
    var refCode = $("#refcode");
    var refName = $("#refname");
    var refMsg = $("#themsg");

    if(refPhone.val().length == 0){
        chkr = chkr +1;
        refPhone.css("border-color","red");
    }
    if(refName.val().length == 0){
        chkr =chkr + 1;
        refName.css("border-color","red");
    }
    if(refMsg.val().length == 0){
        chkr =chkr + 1;
        refMsg.css("border-color","red");
    }

    if(chkr == 0){
        var isPhone = refCode.val() + refPhone.val();
        resRefer(refMsg.val(),refName.val(),isPhone);
    }
    else{
        btnSMS.css({"background-color":"#1293BD","color":"#FFF","border":"thin solid transparent"});
    }


}

function down_modal(){
    modal.modal('hide');
    $( "#btn-ok" ).css({"background-color":"#1293BD","color":"#FFF","border":"thin solid transparent"});
}

function runFocus(thisElement){
    $("#"+thisElement).css("border-color","#EBEBEB");
}


function myFunction(){
    var origVal = $("#countr").val().split("-");
    var newCode = '+' + origVal[1];
    $("#refcode").val(newCode);
}


var msgSpoter =
    '<div id="sms-head" class="sms-sent">SMS sent!</div>';



function successSpoter(){
    original = body.html();
    title.html("Success !");
    body.html("<p>SMS sent!</p>");
    modal.modal('show');
}

function successResult(){
    original = body.html();
    title.html("Success !");
    body.html("<p>The hirer has been notified about your application.</p>");
    footer.css("display","block");
    modal.modal('show');
}

function refResult(){
    original = body.html();
    $( "#btn-refer" ).css({"background-color":"#FFF","color":"#1293BD","border":"thin solid #1293BD"});
    title.html("Refer Someone");
    footer.css("display","none");
    modal.modal('show');
}

function failedResult(){
    original = body.html();
    title.html("Failed !");
    body.html("<p style='color: red;'>Something went wrong.Please try again.</p>");
    footer.css("display","block");
    modal.modal('show');
}

/*applay*/

function resApply(){
    var job_id = $("#job_id").val();
    var hash = $("#hash").val();
    $( "#btn-apply" ).css({"background-color":"#FFF","color":"#00A187","border":"thin solid #00A187"});
        var put_data = {job_id:job_id,hash:hash};
        $.post( base_path +"/apply", put_data,function(data) {})
            .done(function( data ) {
                successResult();
                $( "#btn-apply" ).css({"background-color":"#00A187","color":"#FFF","border":"thin solid transparent"});
            })
            .fail(function(){
                failedResult();
                $( "#btn-apply" ).css({"background-color":"#00A187","color":"#FFF","color":"#FFF","border":"thin solid transparent"});
            })
}

/*refer*/

function resRefer(msg,name,contact){
    var job_id = $("#job_id").val();
    var put_data = {job_id:job_id,phone:contact,name:name,message:msg};
    $.post( base_path +"/refer", put_data,function(data) {})
        .done(function( data ) {
            successSpoter();
            $( "#btn-refer" ).css({"background-color":"#1293BD","color":"#FFF","border":"thin solid transparent"});
            $( "#btn-ok" ).css({"background-color":"#1293BD","color":"#FFF","border":"thin solid transparent"});
            setTimeout(function() {
                down_modal();
            }, 3000);
        })
        .fail(function(){
            failedResult();
            $( "#btn-refer" ).css({"background-color":"#1293BD","color":"#FFF","border":"thin solid transparent"});
            $( "#btn-ok" ).css({"background-color":"#1293BD","color":"#FFF","border":"thin solid transparent"});
        })
}

$("#nudjModal").on('hidden.bs.modal', function(){
    $( "#btn-apply" ).css({"background-color":"#00A187","color":"#FFF","border":"thin solid transparent"});
    $( "#btn-refer" ).css({"background-color":"#1293BD","color":"#FFF","border":"thin solid transparent"});
    $( "#btn-ok" ).css({"background-color":"#1293BD","color":"#FFF","border":"thin solid transparent"});
     body.html(original);
    $("#countr").val("United Kingdom-44-GB");
});

$(window).load(function(){
    $("#countr").val("United Kingdom-44-GB");
});