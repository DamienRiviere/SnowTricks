const btn = document.querySelector("button[type='submit']");

if (btn != null) {
    btn.addEventListener("click", function (e) {
        e.preventDefault();

        const container = $("#comment-container");
        let url = $(this).data("url");

        $.ajax({
            url: url,
            type: "POST",
            data: $("form").serialize(),
            success(response) {
                if ($(".alert-danger").length > 0) {
                    $(".alert-danger").addClass("d-none");
                }

                container.prepend(response.html);
            }
        });
    });
}


