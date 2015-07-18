/**
 * Created by viperS on 24-06-2015 г..
 */

function failMessage(){
    var title = $("#titleModal");
    var body = $("#bodyModal");
    var modal = $("#nudjModal");

    title.html("Incorrect Code");
    body.html("<p style='color: red;'>Please check and <br>try again.</p>");
    modal.modal('show');
}

$("#btn-submit").click(function(e){
    e.preventDefault();
    var verific = $("#mobile-one").val() +$("#mobile-two").val() + $("#mobile-three").val() + $("#mobile-four").val();

    var chkCode = verific.length;

    if(chkCode <4){
        failMessage();
    }
    else{
        var phone = $("#phone_num").val().trim();
        var country_code = $("#country_code").val().trim();

        var put_data = {phone:phone,verification:verific,country_code:country_code};
        $.post( base_path +"/verify", put_data,function(data) {})
            .done(function( data ) {
                if(data.success){
                    if($("#reqfrom").val() == "refer")
                         window.location.href = base_path +"/job/"+$("#jobid").val();
                    else
                        window.location.href = base_path +"/job/"+$("#jobid").val();
                }
                else{
                    failMessage();
                }
            })
            .fail(function(){
                failMessage();
            })
    }

});


$("#nudjModal").on('hidden.bs.modal', function(){
    closeFailed()
});

function closeFailed(){

    $("input[name=mobile-one]").val("");
    $("input[name=mobile-two]").val("");
    $("input[name=mobile-three]").val("");
    $("input[name=mobile-four]").val("");
    $("#mobile-one").focus();

}

$("#mobile-one").keyup(function(e){
   if($("input[name=mobile-one]").val().length > 0){
       $("#mobile-two").focus();
   }
});

$("#mobile-two").keyup(function(e){
   if($("input[name=mobile-two]").val().length > 0){
       $("#mobile-three").focus();
   }
});

$("#mobile-three").keyup(function(e){
   if($("input[name=mobile-three]").val().length > 0){
       $("#mobile-four").focus();
   }
});

$("#mobile-four").keyup(function(e){

    if (e.keyCode == 13) {

        var verific = $("#mobile-one").val() +$("#mobile-two").val() + $("#mobile-three").val() + $(this).val();

        var chkCode = verific.length;

        if(chkCode <4){
            failMessage();
        }
        else{
            $("#btn-submit").click();
        }

    }

});

