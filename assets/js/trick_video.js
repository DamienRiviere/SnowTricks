function handleDeleteButtons()
{
    $("button[data-action='delete']").click(function () {
        const target = this.dataset.target;
        $(target).remove();
    });
}

function updateCounter()
{
    const count = +$("#trick_videos div.form-group").length;

    $("#widget-counter").val(count);
}


$("#add-video").click(function () {
    // Index of future fields that will be created
    const index = +$("#widget-counter").val();

    // Retrieving the prototype of the entries
    const template = $("#trick_videos").data("prototype").replace(/__name__/g, index);

    // Inject the template into the div
    $("#trick_videos").append(template);

    $("#widget-counter").val(index + 1);

    // Manages the delete button
    handleDeleteButtons();
});

updateCounter();
handleDeleteButtons();