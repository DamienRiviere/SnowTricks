$(document).ready(function () {
    const loadBtn = document.getElementById("load-more");
    let nextPage = $(loadBtn).data("next-page");

    loadBtn.addEventListener("click", function (e) {
        const container = $("#trick-container");

        $.ajax({
            method: "GET",
            url: "/tricks?page=" + nextPage++,
            success(response) {
                container.append(response.html);

                if (nextPage > response.pages) {
                    loadBtn.style.display = "none";
                }
            }
        });
    });
});