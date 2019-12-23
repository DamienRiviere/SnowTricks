(function () {
    let link = document.getElementById("unlikeButton");

    function makeRequest()
    {
        const id = $(link).data("id");

        $.ajax({
            url: "/trick/" + id + "/unlike",
            type: 'POST'
        });

        window.location.replace("/account");
    }

    if (link != null) {
        link.addEventListener("click", (e) => {
            e.preventDefault();
            makeRequest();
        });
    }
})();