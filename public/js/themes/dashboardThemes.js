//Archivo con la logica para cambiar los colores del dashboard

//Establecemos las constantes a emplear
const CambioPaleta = document.getElementById('Tema');
const sideBar = document.querySelector('.menuVertical');
const navbar = document.querySelector('.navHorizontal');
const data = document.querySelector('.datos');
const body = document.body;
const modoMinerva = '/IMG/Minerva.png';
const modoVR = '/IMG/Lentes.png';

//Funcion para cambiar la paleta de colores del dashboard
function newColor(){
    const temaGuardado = localStorage.getItem('tema'); //Nos ayuda a obtener el tema guardado en localstorage
    //Verificamos si el tema guardado es 'minerva'
    if (temaGuardado === 'minerva') {
        sideBar.classList.add('Temas');
        navbar.classList.add('color');
        data.classList.add('dataTheme')
        body.classList.add('fondos');
        CambioPaleta.innerHTML = `<img class="Lentes" src="${modoVR}" alt="Lentes" style="width: 40px; height: 40px;">`;
    } else {
        sideBar.classList.remove('Temas');
        body.classList.remove('fondos');
        navbar.classList.remove('color');
        data.classList.remove('dataTheme');
        CambioPaleta.innerHTML = `<img class="minerva" src="${modoMinerva}" alt="Lentes" style="width: 40px; height: 40px;">`;
    }
}

//Indicamos que se aplique la nueva paleta al cargar la pagina
newColor();

//Evento antes del cambio
CambioPaleta.addEventListener("click", () => {
    sideBar.classList.toggle("Temas");
    navbar.classList.toggle('color');
    data.classList.toggle('dataTheme');
    body.classList.toggle("fondos");

    //Indicamos el cambio de icono(IMG) según el modo en el que se encuentre la pagina
    const miverIcon = `<img class="minerva" src="${modoMinerva}" alt="Lentes" style="width: 40px; height: 40px;">`;
    const vrIcon = `<img class="Lentes" src="${modoVR}" alt="Lentes" style="width: 40px; height: 40px;">`;

    // Si las clases están presentes, cambiamos la IMG a modo VR y guardamos el estado
    if (sideBar.classList.contains("Temas") && body.classList.contains("fondos")) {
        CambioPaleta.innerHTML = vrIcon;
        localStorage.setItem('tema', 'minerva'); // Guardar el estado en localStorage
    } else {
         // Si no, cambiamos la IMG a modo Minerva y guardamos el estado
        CambioPaleta.innerHTML = miverIcon;
        localStorage.setItem('tema', 'vr'); // Guardar el estado en localStorage
    }
});

