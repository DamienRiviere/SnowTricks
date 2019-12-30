document.querySelector("button[type='submit']").addEventListener("click", (e) => {
    e.preventDefault();

    const container = $("#comment-container");
    let slug = $("#allComments").data("trick-slug");

    $.ajax({
        url: "/trick/" + slug + "/new-comment",
        type: 'POST',
        data: $('form').serialize(),
        success: function (response) {
            container.prepend(response.html);
        }
    });
});

