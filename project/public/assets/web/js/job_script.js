/**
 * Created by viperS on 24-06-2015 г..
 */
var title = $("#titleModal");
var body = $("#bodyModal");
var modal = $("#nudjModal");
var footer = $("#footerModal");

function down_modal(){
    modal.modal('hide');
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
    title.html("Success !");
    body.html("<p>SMS sent!</p>");
    modal.modal('show');
}

function successResult(){
    title.html("Success !");
    body.html("<p>The hirer has been notified about your application.</p>");
    footer.css("display","block");
    modal.modal('show');
}

function refResult(){
    $( "#btn-refer" ).css({"background-color":"#FFF","color":"#1293BD","border":"thin solid #1293BD"});
    title.html("Refer Someone");
    body.html(msgRefer);
    footer.css("display","none");
    modal.modal('show');
}

function failedResult(){
    title.html("Failed !");
    body.html("<p style='color: red;'>Something went wrong.Please try again.</p>");
    footer.css("display","block");
    modal.modal('show');
}

/*applay*/

function resApply(){
    var job_id = $("#job_id").val();
    $( "#btn-apply" ).css({"background-color":"#FFF","color":"#00A187","border":"thin solid #00A187"});
        var put_data = {job_id:job_id};
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

