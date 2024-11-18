//Variables a emplear
let nextDom = document.getElementById('next'); //Para avanzar en el carousel
let prev = document.getElementById('prev'); //Para retroceder en el carousel
let carouselDom = document.querySelector('.carousel-Principal');
let listItemDom = document.querySelector('.carousel-Principal .list');
let thumbnailDom = document.querySelector('.carousel-Principal .thumbnail');
//Variables del tiempo que tomará en cambiar automáticamente las imágenes del carrusel
let timeRunning = 3000;
let runTimeOut;
let esperaCambio = 8000;

//Asiganamos la unción 'showSlider' para que se ejecute cuando se haga clic en el botón 'next'
nextDom.onclick = function(){
    showSlider('next');
}

// Asignamos la función 'showSlider' para que se ejecute cuando se haga clic en el botón 'prev'
prev.onclick = function(){
    showSlider('prev');
}

// Función que muestra el siguiente o el anterior slide en el carrusel
function showSlider(type){
    let itemSlider = document.querySelectorAll('.carousel-Principal .list .item');
    let itemThumbnail = document.querySelectorAll('.carousel-Principal .thumbnail .item');

    if(type === 'next' && itemSlider.length > 0 && itemThumbnail.length > 0){
        listItemDom.appendChild(itemSlider[0]);
        thumbnailDom.appendChild(itemThumbnail[0]);
        carouselDom.classList.add('next');

        // Remueve la clase 'next' después de un tiempo
        setTimeout(() => {
            carouselDom.classList.remove('next');
        }, 500);
    } else{
        let positionLastItem = itemSlider.length -1;
        listItemDom.prepend(itemSlider[positionLastItem]);
        thumbnailDom.prepend(itemThumbnail[positionLastItem]);
        carouselDom.classList.add('prev')


        // Remueve la clase 'prev' después de un tiempo
        setTimeout(() => {
            carouselDom.classList.remove('prev');
        }, 500);
    }
}


let autoNextInterval = setInterval(() => {
    showSlider('next');
}, esperaCambio);


nextDom.onclick = function(){
    clearInterval(autoNextInterval);
    showSlider('next');
    autoNextInterval = setInterval(() => {
        showSlider('next');
    }, esperaCambio);
}

prev.onclick = function(){
    clearInterval(autoNextInterval);
    showSlider('prev');
    autoNextInterval = setInterval(() => {
        showSlider('next');
    }, esperaCambio);
}
