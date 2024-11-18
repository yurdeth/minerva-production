@extends('layouts.layout')

@section('content')
<section>
    <h1 class="text-center">¡Hola Mundo!</h1><br>
    <!--Contenedor principal-->
    <div class="container my-5" style="padding-top: 0; padding-bottom: 0;">
        <h2 class="text-center">¿Quiénes somos?</h2>
        <hr>
        <br>

        <div class="row" style="align-items: center;">
            <div class="col-md-6 col-12" style="padding-right: 10px; padding-bottom: 15px;">
            <img class="img-fluid" src="{{asset('IMG/labFacebok.jpg')}}" alt="Quienes Somos" style="border-radius:6px; width: 450px;">
            </div>
            <div class="col-md-6 col-12" style="padding-left: 10px;">
                <div class="card" style="width: auto; box-shadow: 0 4px 8px rgba(93, 102, 107, 0.419), 0 6px 20px rgba(51, 152, 206, 0.419);">
                    <div class="card-body">
                        <p style="text-align:justify; margin-bottom: 0;">
                            Somos el Minerva RV Lab FMO, un espacio innovador en la Facultad Multidisciplinaria Oriental dedicado a estudiantes y docentes.
                            Para fomentar el desarrollo de nuevas aplicaciones de estudio mediante el uso de realidad virtual inmersiva.
                            la cuál potencia el aprendizaje y la investigación.

                            <br><br>
                            En el Minerva RV Lab FMO, estamos llevando la tecnología de realidad virtual al siguiente nivel. Desde simulaciones inmersivas hasta experiencias interactivas.
                            <br>
                            Nuestro objetivo es transformar la manera en que se aprende, explorando nuevas formas interactivas de estudio y creando experiencias de aprendizaje inmersivas y dinámicas.
                            Únete a nosotros y descubre el futuro de la educación.
                        </p>
                    </div>
                </div>
            </div>
        </div>
            <br><br>

         <h2 class="text-center">Historia</h2>
         <hr>
         <br>
        <div class="row" style="align-items: center;">
                <div class="col-md-6 col-12" style="padding-left: 10px;">
                    <img class="img-fluid" src="{{asset('IMG/minervaInfo.jpg')}}" alt="Quienes Somos" style="border-radius:6px; width: 450px;">
                </div>
                <div class="col-md-6 col-12" style="padding-right: 10px; padding-bottom: 15px;">
                    <div class="card" style="width: auto; box-shadow: 0 4px 8px rgba(93, 102, 107, 0.419), 0 6px 20px rgba(51, 152, 206, 0.419);">
                        <div class="card-body">
                            <p style="text-align:justify; margin-bottom: 0;">
                            La Universidad de El Salvador al ser pionera en diferentes campos y con la visión
                            de ir de la mano con los constantes avances tecnológicos que hoy en día nuestra sociedad
                            está experimentando decide dar un paso más en la formación de sus profesionales y se
                            adapta a los cambios tecnológicos que enfrenta la educación en el mundo por lo cual en el
                            marco del Proyecto de Transformación Digital se da inicio a la instalación del Laboratorio
                            de Realidad Virtual Inmersa en la Facultad Multidisciplinaria Oriental en el espacio físico que
                            anteriormente ocupaban las Salas de Conferencias 1 y 2 Finalizando la instalación de este
                            el 7 de julio de 2023.

                            <br><br>
                            Actualmente el laboratorio de realidad virtual se encuentra funcionando
                            exitosamente prestando servicio a cualquier grupo de estudiantes o docentes que solicite
                            hacer uso de este.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
    </div>
</section>

@endsection
