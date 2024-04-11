document.addEventListener('DOMContentLoaded', function(){

    eventListeners();
    
    darkMode();

    tipoAmazon();
});

function darkMode(){

    const prefiereDarkMode = window.matchMedia('(prefers-color-scheme: dark)');
    if(prefiereDarkMode.matches){
        document.body.classList.add('dark-mode');
    }else{
        document.body.classList.remove('dark-mode');
    }
    prefiereDarkMode.addEventListener('change', function(){
        if(prefiereDarkMode.matches){
            document.body.classList.add('dark-mode');
        }else{
            document.body.classList.remove('dark-mode');
        }
    })
    const btnDarkMode = document.querySelector('.dark-mode-boton');
    btnDarkMode.addEventListener('click', function(){
        document.body.classList.toggle('dark-mode');
    });
}


function eventListeners(){
    const mobilMenu = document.querySelector('.mobile-menu');

    mobilMenu.addEventListener('click', navegacionResponsive);
    //Muestra campos condicionales
    const metodoContacto = document.querySelectorAll('input[name="contacto[contacto]" ]');
    metodoContacto.forEach(input => input.addEventListener('click',mostrarMetodosContacto));
}

function navegacionResponsive(){
    const navegacion = document.querySelector('.navegacion');
    navegacion.classList.toggle('mostrar')
}

function mostrarMetodosContacto(e){
    const contactoDiv = document.querySelector('#contacto');

    if(e.target.value === 'telefono'){
        contactoDiv.innerHTML = `
        <label for="telefono">Número de Celular</label>
        <input type="tel" placeholder="Tu Teléfono" id="telefono" name="contacto[telefono]">


        <p>Elija la fecha y la hora para la llamada</p>

        <label for="fecha">Fecha</label>
        <input type="date" id="fecha" name="contacto[fecha]">

        <label for="hora">Hora:</label>
        <input type="time" id="hora" min="9:00" max="18:00" name="contacto[hora]">
        
        `;
    }else{
        contactoDiv.innerHTML = `

        <label for="email">E-mail</label>
        <input type="email" placeholder="Tu Email" id="email" name="contacto[email]" >
        
        `;
    }

}
function tipoAmazon() {
    let thumbnails = document.getElementsByClassName('thumbnail')
    let featuredImage = document.getElementById('featuredImage');
    let activeImages = document.getElementsByClassName('active');
    let featuredVideo = document.getElementById('featuredVideo');
    let buttonRight = document.getElementById('slideRight');
    let buttonLeft = document.getElementById('slideLeft');
    let slider = document.getElementById('sliderUltimo');
    let videos= slider.querySelectorAll('video');

    // Inicialmente ocultar el botón izquierdo
    buttonLeft.style.display = 'none';


    for (var i = 0; i < thumbnails.length; i++) {

        thumbnails[i].addEventListener('mouseover', function () {
            console.log(activeImages)

            if (activeImages.length > 0) {
                activeImages[0].classList.remove('active')
            }


            this.classList.add('active');

            // document.getElementById('featured').src = this.src;
           if (this.tagName.toLowerCase() === 'img') {
               featuredImage.src = this.src;
               featuredImage.style.display = 'block';
               featuredVideo.style.display = 'none';
           }else if (this.tagName.toLowerCase() === 'video') {
          // Cambios para los videos
               featuredVideo.style.transition = '0.5s ease-out';

               // Retrasar el cambio de src para que la transición sea más suave
               setTimeout(() => {
                   featuredVideo.src = this.src;
                   featuredVideo.style.display = 'block';
                   featuredImage.style.display = 'none';
                   // Restaurar la opacidad después de cambiar el src
                   setTimeout(() => {
                       featuredVideo.style.transition = '';
                       // featuredVideo.style.opacity = '1';
                   }, 100);
               }, 500);
           }

       })
   }
   videos.forEach(function(video) {
       // Para cada video dentro del slider, quitar el atributo controls
       video.removeAttribute('controls');
   });


   buttonRight.addEventListener('click', function () {
       slider.scrollLeft += 180;
       buttonLeft.style.display = 'block'; // Mostrar botón izquierdo cuando se hace clic en el botón derecho
       rightButtonClicked = true;
   });

   buttonLeft.addEventListener('click', function () {
       slider.scrollLeft -= 180;
       rightButtonClicked = false;
   });

   // Ocultar el botón izquierdo cuando estás en el primer elemento del slider
   slider.addEventListener('scroll', function () {
       if (slider.scrollLeft === 0) {
           buttonLeft.style.display = 'none';
       } else {
           buttonLeft.style.display = 'block';
       }

       // Ocultar el botón derecho cuando estás en el último elemento del slider
       if (slider.scrollLeft + slider.clientWidth === slider.scrollWidth) {
           buttonRight.style.display = 'none';
       } else {
           buttonRight.style.display = 'block';
       }
   });

   // Manejar el estado inicial del botón derecho
   if (slider.scrollLeft + slider.clientWidth === slider.scrollWidth) {
       buttonRight.style.display = 'none';
   }
}