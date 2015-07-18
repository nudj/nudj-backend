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

function spoter(){

    var chkr = 0;
    var refPhone = $("#refphone");
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
        successSpoter();
        setTimeout(function() {
            down_modal();
        }, 3000);
    }


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


$("#btn-refer").click(function() {
    refResult();
});

/*applay*/

function resApply(){
    //e.preventDefault();
   console.log("Success");
    //var job_id = $("#job_id").val();
    //
    //    var put_data = {job_id:job_id};
        //$.post( base_path +"/apply", put_data,function(data) {})
        //    .done(function( data ) {
        //        successResult();
        //    })
        //    .fail(function(){
        //        TINY.box.show({html:msgFail,width:200,height:200,fixed:false,maskid:'bluemask',maskopacity:40,close:false,closejs:function(){closeFailed()}})
        //    })
    successResult();
}

