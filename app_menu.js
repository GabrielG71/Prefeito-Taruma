const hamburguer = document.querySelector(".hamburguer");
const nav = document.querySelector(".container-box");

// Adiciona um evento de clique no ícone do hamburguer para alternar a classe 'active' na navegação
hamburguer.addEventListener("click", () => {
  nav.classList.toggle("active"); // Adiciona ou remove a classe 'active' para abrir ou fechar o menu
});