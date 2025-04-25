// Pega o botão do menu
const hamburguer = document.querySelector(".hamburguer");

// Pega o menu de navegação
const nav = document.querySelector(".nav");

// Pega os links do menu
const navLinks = document.querySelectorAll('.nav-list li a');

// Quando clicar no botão, ativa ou desativa o menu
hamburguer.addEventListener("click", () => {
  nav.classList.toggle("active");
});
