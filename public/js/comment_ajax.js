document.querySelector("button[type='submit']").addEventListener("click", (e) => {
    e.preventDefault();

    const container = $("#comment-container");
    const btnNewComment = document.getElementById("btnNewComment");
    let slug = $(btnNewComment).data("trick-slug");

    $.ajax({
        url: "/trick/" + slug + "/new-comment",
        type: 'POST',
        data: $('form').serialize(),
        success: function (response) {
            container.prepend(response.html);
        }
    });
});

