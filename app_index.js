// Menu Hamburguer
const hamburguer = document.querySelector(".hamburguer");
const nav = document.querySelector(".container-box");
const navLinks = document.querySelectorAll(".nav-list li a");

hamburguer.addEventListener("click", () => {
  nav.classList.toggle("active");
});

// Slider de Imagens
const slider = document.querySelector(".slider-content");
const radios = document.querySelectorAll("input[name='btn-radio']");
let currentIndex = 0;
let startX = 0;
let endX = 0;

// Garante que o primeiro slide esteja selecionado ao carregar a página
document.getElementById("radio1").checked = true;

// Troca automática das imagens a cada 10 segundos
let slideInterval = setInterval(nextSlide, 10000);

// Função para atualizar o slide
function updateSlide(index) {
  if (index < 0) {
    currentIndex = radios.length - 1;
  } else if (index >= radios.length) {
    currentIndex = 0;
  } else {
    currentIndex = index;
  }
  radios[currentIndex].checked = true;
}

// Avança para o próximo slide
function nextSlide() {
  updateSlide(currentIndex + 1);
}

// Volta para o slide anterior
function prevSlide() {
  updateSlide(currentIndex - 1);
}

// Detecta o início do toque
slider.addEventListener("touchstart", (event) => {
  startX = event.touches[0].clientX;
});

// Detecta o movimento do dedo
slider.addEventListener("touchmove", (event) => {
  endX = event.touches[0].clientX;
});

// Quando o usuário solta o dedo, verifica a direção do deslize
slider.addEventListener("touchend", () => {
  let swipeDistance = startX - endX;
  
  if (swipeDistance > 50) {
    // Se arrastar para a esquerda, vai para o próximo slide
    nextSlide();
  } else if (swipeDistance < -50) {
    // Se arrastar para a direita, volta para o slide anterior
    prevSlide();
  }

  // Reinicia o intervalo de troca automática para evitar mudanças abruptas
  clearInterval(slideInterval);
  slideInterval = setInterval(nextSlide, 10000);
});
