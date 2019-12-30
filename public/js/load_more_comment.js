$(document).ready(function () {
    const loadBtn = document.getElementById("load-more");
    let slug = $("#allComments").data("trick-slug");
    let nextPage = $(loadBtn).data("next-page");

    if (loadBtn != null) {
        loadBtn.addEventListener("click", function (e) {
            const container = $("#comment-container");

            $.ajax({
                method: "GET",
                url: "/trick/" + slug + "/comment?page=" + nextPage++,
                success: function (response) {
                    container.append(response.html);

                    if (nextPage > response.pages) {
                        loadBtn.style.display = "none";
                    }
                }
            });
        });
    }
});