@extends('layouts.layout')

@section('content')
    <link rel="stylesheet" href="{{ asset('CSS/principal.css')}}">
    <!--Contenido de Home-->
    <section>
        <!--Contenedor principal-->
        <div class="container">
            <div class="card">
                <div class="card-body">
                    <video class="video" controls autoplay disablepictureinpicture loop muted
                                   controlsList="nodownload nofullscreen noplaybackrate" oncontextmenu="return false;"
                                   src="{{asset('IMG/VideoVR.mp4')}}" type="video/mp4">
                    </video>
                    <div class="informacion">
                        <h4> Servicio de capacitación </h4>
                        <p>
                            El Minerva RV Lab es un laboratorio de realidad virtual inmersiva el cual tiene como objetivo
                            principal potenciar la formación de los estudiantes a través de la interacción virtual. <br><br>

                            En dicho espacio los estudiantes y docentes que reserven cita podrán tener acceso a una de las dos salas con la cuenta el Minerva VR Lab FMO
                            donde un capacitador o guía les brindara un recorrido a través de los distintos entornos o escenarios virtuales con los que se cuentan.
                            <br><br>

                            <b>Equipo con el que contamos: </b> <br><br>

                            <i class="fa-solid fa-vr-cardboard"></i> Lentes de realidad virtual. <br>
                            <i class="fa-solid fa-tv"></i> Televisión de alta definición. <br>
                            <i class="fa-solid fa-desktop"></i> Computadoras de alta gama. <br> <br>

                            <b>Visítanos no pierdas la oportunidad de experimentar una forma de aprendizaje</b>
                        </p>
                    </div>
                </div>
            </div> <br> <br>

            <h3 class="text-center mb-3">Contamos con:</h3>

            <div class="row">
                <div class="col-md-4 col-12 mb-4">
                    <div class="card text-center" style="box-shadow: 0 4px 20px rgba(93, 102, 107, 0.5); transition: transform 0.3s; border: none; min-height: 350px;">
                        <div class="card-body" style="background-color: #f8f9fa; display: flex; flex-direction: column; justify-content: center; align-items: center;">
                            <i class="fa-solid fa-hospital fa-3x mb-3" style="color: #476679;"></i>
                            <h5 class="card-title">Escenarios  <br> en el área de medicina</h5>
                            <p class="card-text" style="text-align: justify;">
                                En el Minerva RV  contamos con avanzados escenarios diseñados específicamente para apoyar el aprendizaje en el área de medicina.
                                A través de simulaciones inmersivas, los estudiantes podrán experimentar situaciones clínicas realistas para mejorar sus habilidades
                                 en un entorno seguro y controlado.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 col-12 mb-4">
                    <div class="card text-center" style="box-shadow: 0 4px 20px rgba(93, 102, 107, 0.5); transition: transform 0.3s; border: none; min-height: 350px;">
                        <div class="card-body" style="background-color: #f8f9fa; display: flex; flex-direction: column; justify-content: center; align-items: center;">
                        <i class="fa-solid fa-screwdriver-wrench fa-3x mb-3" style="color: #476679;"></i>
                            <h5 class="card-title">Escenarios  <br> para Ingeniería y Arquitectura </h5>
                            <p class="card-text" style="text-align: justify;">
                                Nuestro laboratorio ofrece escenarios innovadores que facilitan el aprendizaje en las áreas de ingeniería y arquitectura
                                A través de simulaciones los usuarios pueden explorar  áreas de construcción, visualizar el motor de un avión de manera interna y externa
                                brindando una experiencia práctica que fomenta la creatividad
                            </p>
                        </div>
                    </div>
                </div>


                <div class="col-md-4 col-12 mb-4">
                    <div class="card text-center" style="box-shadow: 0 4px 20px rgba(93, 102, 107, 0.5); transition: transform 0.3s; border: none; min-height: 350px;">
                        <div class="card-body" style="background-color: #f8f9fa; display: flex; flex-direction: column; justify-content: center; align-items: center;">
                            <i class="fa-solid fa-seedling fa-3x mb-3" style="color: #476679;"></i>
                            <h5 class="card-title">Escenarios <br> en el área de Agronomía</h5>
                            <p class="card-text" style="text-align: justify;">
                                Explora escenarios enfocados en el área de agronomía, donde los estudiantes podran interactuar con entornos virtuales que simulan técnicas agrícolas avanzadas.
                                Tal y como lo es el cultivo hidropónico, donde se puede experimentar el proceso completo de cultivo sin suelo, desde la gestión de nutrientes hasta el monitoreo
                                 de las condiciones ambientales.
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </section>
    <br>


@endsection
