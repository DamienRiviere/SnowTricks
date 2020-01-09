const head_trick = document.getElementById("headtricks");

if (window.innerWidth <= 425) {
    head_trick.classList.remove("headtricks");
    head_trick.classList.add("headtricks-responsive");
}