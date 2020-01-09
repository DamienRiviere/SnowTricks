const sectionTitle = document.getElementById("section-title");

if (window.innerWidth <= 425) {
    sectionTitle.classList.remove("section-title");
    sectionTitle.classList.add("section-title-responsive");
}