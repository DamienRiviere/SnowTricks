const headTrick = document.getElementById("headtricks");

if (window.innerWidth <= 425) {
    headTrick.classList.remove("headtricks");
    headTrick.classList.add("headtricks-responsive");
}