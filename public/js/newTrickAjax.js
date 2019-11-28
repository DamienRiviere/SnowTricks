document.querySelector("button[type='submit']").addEventListener("click", (e) => {
    e.preventDefault();

    const url = window.location.pathname;
    const form = $('form').serialize();

    $.ajax({
        url: url,
        type: 'POST',
        data: form,
        dataType: "html",
        success: function (data) {
            $("body").html(data);

            const errors = document.getElementsByClassName("form-error-message").length;
            const name = document.getElementById("trick_name").value;
            const str = name.normalize("NFD").replace(/[\u0300-\u036f]/g, "").toLowerCase();
            const slug = str.replace(" ", "-");

            if (errors === 0) {
                window.location.replace("/trick/" + slug);
            }
        }
    });
});

