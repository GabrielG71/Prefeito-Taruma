// Seleciona o ícone de hamburguer (menu mobile) e o container da navegação
const hamburguer = document.querySelector(".hamburguer");
const nav = document.querySelector(".container-box");

// Adiciona um evento de clique no ícone do hamburguer para alternar a classe 'active' na navegação
hamburguer.addEventListener("click", () => {
  nav.classList.toggle("active"); // Adiciona ou remove a classe 'active' para abrir ou fechar o menu
});

// Seleciona os botões de rádio que controlam os slides, as bolinhas de navegação e o conteúdo do slider
const radios = document.querySelectorAll("input[name='btn-radio']");
const autoBtns = document.querySelectorAll(".nav-auto div");
const sliderContent = document.querySelector(".slider-content");

// Inicializa algumas variáveis para controle do slider
let currentIndex = 0; // Índice do slide atual
let startX = 0; // Posição inicial do toque (usado para detectar o movimento no slider)
let endX = 0; // Posição final do toque (usado para detectar o movimento no slider)
let isDragging = false; // Flag que indica se o usuário está arrastando (movendo) o slide

// Define o primeiro radio como checked e chama a função para atualizar as bolinhas de navegação
document.getElementById("radio1").checked = true;
atualizarBolinhas(0);

// Define o intervalo para navegar automaticamente entre os slides a cada 10 segundos
let slideInterval = setInterval(nextSlide, 10000);

// Função que atualiza as bolinhas de navegação e marca o slide ativo
function atualizarBolinhas(index) {
  radios.forEach((radio) => (radio.checked = false)); // Desmarca todos os botões de rádio
  radios[index].checked = true; // Marca o botão de rádio correspondente ao slide atual

  // Atualiza o estilo das bolinhas de navegação
  autoBtns.forEach((btn, i) => {
    btn.style.backgroundColor = i === index ? "#2cf8ff" : "transparent"; // Marca a bolinha ativa com cor
  });
}

// Função para atualizar o slide com base no índice
function updateSlide(index) {
  if (index < 0) { // Caso o índice seja menor que 0, vai para o último slide
    currentIndex = radios.length - 1;
  } else if (index >= radios.length) { // Caso o índice seja maior que o número de slides, vai para o primeiro
    currentIndex = 0;
  } else {
    currentIndex = index; // Caso contrário, atualiza o índice do slide
  }

  atualizarBolinhas(currentIndex); // Atualiza as bolinhas de navegação
}

// Função para ir para o próximo slide
function nextSlide() {
  updateSlide(currentIndex + 1); // Atualiza o slide para o próximo
}

// Função para ir para o slide anterior
function prevSlide() {
  updateSlide(currentIndex - 1); // Atualiza o slide para o anterior
}

// Função que reinicia o intervalo de navegação automática
function resetSlideInterval() {
  clearInterval(slideInterval); // Limpa o intervalo existente
  slideInterval = setInterval(nextSlide, 10000); // Cria um novo intervalo para navegação automática
}

// Detecta o início do toque no conteúdo do slider
sliderContent.addEventListener("touchstart", (event) => {
  startX = event.touches[0].clientX; // Registra a posição inicial do toque
  isDragging = false; // Reseta a flag de arrasto
});

// Detecta o movimento do toque no conteúdo do slider
sliderContent.addEventListener("touchmove", (event) => {
  endX = event.touches[0].clientX; // Registra a posição final do toque
  isDragging = true; // Marca como "arrastando"
});

// Detecta o fim do toque e decide a direção do movimento (deslizar para esquerda ou direita)
sliderContent.addEventListener("touchend", () => {
  if (!isDragging) return; // Se o usuário não arrastou, não faz nada

  let swipeDistance = startX - endX; // Calcula a distância do movimento

  if (swipeDistance > 50) { // Se o movimento foi para a direita
    nextSlide(); // Avança para o próximo slide
  } else if (swipeDistance < -50) { // Se o movimento foi para a esquerda
    prevSlide(); // Volta para o slide anterior
  }

  resetSlideInterval(); // Reinicia o intervalo de navegação automática
});

// Adiciona eventos de clique para os botões de navegação manual
document.querySelectorAll(".nav-manual .manualbtn").forEach((btn, index) => {
  btn.addEventListener("click", () => {
    updateSlide(index); // Atualiza para o slide correspondente ao botão clicado
    resetSlideInterval(); // Reinicia o intervalo de navegação automática
  });
});

// Adiciona eventos de clique para os botões de rádio
radios.forEach((radio, index) => {
  radio.addEventListener("click", () => {
    updateSlide(index); // Atualiza o slide para o índice correspondente ao botão de rádio
    resetSlideInterval(); // Reinicia o intervalo de navegação automática
  });
});
