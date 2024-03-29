"use strict"
document.addEventListener('DOMContentLoaded', ()=>{
        // variable page menu hamburger 
   
        let btnMenu = document.querySelector('.menuHamburger');
        let menu = document.getElementById('menu');
        let croix1 = document.getElementById('barre1');
        let croix2 = document.getElementById('barre2');
    
        btnMenu.onclick = function(){/*on récupère les éléments enfants du conteneur hamburger pour réaliser l'animations en css grâce à l'id croix*/
            menu.classList.toggle('hide');
            croix1.classList.toggle('croix');
            croix2.classList.toggle('croix');
            croix1.classList.toggle('angleBarre1');
            croix2.classList.toggle('angleBarre2');
        }
})