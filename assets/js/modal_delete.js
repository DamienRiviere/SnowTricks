$(document).on("click", ".deleteTrick", function () {
    let id = $(this).data("id");
    $(".modal-delete-trick").attr("data-id", +id);
});

$(document).on("click", ".modal-delete-trick", function () {
    let id = $(this).data("id");
    $(".modal-delete-trick").attr("href", "/trick/delete/" + id);
});