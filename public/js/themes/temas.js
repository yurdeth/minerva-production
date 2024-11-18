document.addEventListener('DOMContentLoaded', () => {
    // Establecemos las constantes a emplear
    const toggle = document.getElementById('toggle');
    const navbar = document.querySelector('.navbar');
    const footer = document.getElementById('FooterCambio');
    const buttons = document.querySelectorAll('.nav-item button');
    const contenedorImagen = document.getElementById('contenedorImagen');
    const logoInicio = document.getElementById('logoInicio');
    const body = document.body;
    //Constantes con las rutas de las imagenes
    const modoMinerva = '../IMG/Minerva.png';
    const modoVR = '../IMG/Lentes.png';
    const logoFMO = '../IMG/Logo FMO.png';
    const logoVR = '../IMG/LogoLentes.png';

    // Definimos una función que nos ayude a cambiar el tema establecido por otro
    function newTema() {
        const temaGuardado = localStorage.getItem('tema') || 'vr';
        const isMinerva = temaGuardado === 'minerva';

        navbar.classList.toggle('Temas', isMinerva);
        body.classList.toggle('fondos', isMinerva);
        buttons.forEach(button => button.classList.toggle('Temas', isMinerva));
        footer.classList.toggle('Temas', isMinerva);

        if (contenedorImagen) {
            contenedorImagen.classList.toggle('contenedor-minerva', isMinerva);
            contenedorImagen.classList.toggle('contenedor-vr', !isMinerva);
        }

        if (logoInicio) {
            logoInicio.src = isMinerva ? logoFMO : logoVR;
            logoInicio.className = isMinerva ? 'logo-fmo' : 'logo-vr';
        }

    }

    // Aplicamos el tema al cargar la página
    newTema();

    toggle.addEventListener("click", () => {
        const isMinerva = !navbar.classList.contains('Temas');
        navbar.classList.toggle('Temas', isMinerva);
        body.classList.toggle('fondos', isMinerva);
        buttons.forEach(button => button.classList.toggle('Temas', isMinerva));
        footer.classList.toggle('Temas', isMinerva);

        if (contenedorImagen) {
            contenedorImagen.classList.toggle('contenedor-minerva', isMinerva);
            contenedorImagen.classList.toggle('contenedor-vr', !isMinerva);
        }

        if (logoInicio) {
            logoInicio.src = isMinerva ? logoFMO : logoVR;
            logoInicio.className = isMinerva ? 'logo-fmo' : 'logo-vr';
        }

        localStorage.setItem('tema', isMinerva ? 'minerva' : 'vr');
    });
});
