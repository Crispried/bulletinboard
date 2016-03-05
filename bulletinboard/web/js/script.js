$("#addBulletin").click(function () {
    closeAllModals();
    $("#addBulletinModal").modal("show");
});
var closeAllModals = function(){
    $(".modal").modal("hide");
}
$("#add").click(function () {
    $('#title').val('');
    $('#description').val('');
});
