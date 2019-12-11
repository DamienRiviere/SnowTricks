document.querySelector("button[type='submit']").addEventListener("click", (e) => {
    e.preventDefault();

    const url = window.location.pathname;

    $.ajax({
        url: url,
        type: 'POST',
        data: $('form').serialize(),
        dataType: "html",
        success: function (data) {
            $("body").html(data);
        }
    });
});

