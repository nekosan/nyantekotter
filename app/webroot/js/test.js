$(function(){
    $("#posttext").bind("change keyup", function(){
        var count = 140 - $(this).val().length;
        $("#textnum").text(count);
    });
});
