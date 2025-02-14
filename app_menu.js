const hamburguer = document.querySelector(".hamburguer");
const nav = document.querySelector(".nav");
const navLinks = document.querySelectorAll('.nav-list li a');

hamburguer.addEventListener("click", () => {
  nav.classList.toggle("active");
});