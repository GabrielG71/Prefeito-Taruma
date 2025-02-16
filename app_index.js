const hamburguer = document.querySelector('.hamburguer');
const nav = document.querySelector('.container-box');
const navLinks = document.querySelectorAll('.nav-list li a');

hamburguer.addEventListener("click", () => {
  nav.classList.toggle("active");
});


var radio = document.querySelector('.manual-btn')

var cont = 1

document.getElementById('radio1').checked = true

setInterval(() => {
  proximaImg()
}, 10000)

function proximaImg(){
    cont++
    if (cont > 3) {
      cont = 1
    }

    document.getElementById('radio'+cont).checked = true
}

let startX = 0;
let endX = 0;


slider.addEventListener("touchmove", (event) =>{
  endX = event.touches[0].clientX;
})


slider.addEventListener("touchend", () => {
  if (startX - endX > 50) {
    
    proximaImg();
  } else if (endX - startX > 50) {
    
    cont--;
    if (cont < 1) {
      cont = 3;
    }
    document.getElementById("radio" + cont).checked = true;
  }
  
  
  clearInterval(slideInterval);
  slideInterval = setInterval(proximaImg, 10000);
});