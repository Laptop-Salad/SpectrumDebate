$("#comments").hide();

$("#viewStatements").click(function () {
    $("#comments").hide();
    $("#statements").show();
})

$("#viewComments").click(function () {
    $("#statements").hide();
    $("#comments").show();
})