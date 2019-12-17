(function () {
    let like;
    let icon = document.getElementById("iconLike");
    let link;

    if (document.getElementById("likeButton") != null) {
        link = document.getElementById("likeButton");
        like = "like";
    } else {
        link = document.getElementById("unlikeButton");
        like = "unlike";
    }

    function makeRequest()
    {
        const slug = $(link).data("slug");
        const id = $(link).data("id");

        $.ajax({
            url: "/trick/" + id + "/" + like,
            type: 'POST'
        });

        window.location.replace("/trick/" + slug);

        if (like === "like") {
            icon.setAttribute("class", "fas fa-thumbs-up");
        } else if (like === "unlike") {
            icon.setAttribute("class", "far fa-thumbs-up");
        }
    }

    if (link != null) {
        link.addEventListener("click", (e) => {
            e.preventDefault();
            makeRequest();
        });
    }
})();