const navbar = document.getElementById("navbar");
const containerNav = document.getElementById("container-navbar");


if (window.innerWidth <= 425) {
    navbar.classList.remove("fixed-top");
    navbar.classList.add("fixed-bottom");

    containerNav.classList.add("text-center");
}