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
}, 5000)

function proximaImg(){
    cont++
    if (cont > 3) {
      cont = 1
    }

    document.getElementById('radio'+cont).checked = true
}