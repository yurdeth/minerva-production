@extends('layouts.layout')

@section('content')

    <section>
        <h1 class="text-center">Servicios</h1>
        <!--Contenedor principal-->
        <div class="container my-3">

            <p class="text-center" style="text-align: justify;">
                El Minerva RV Lab es un espacio que ofrece servicios de capacitación para estudiantes y docentes.
                Nuestro laboratorio de realidad virtual inmersiva está diseñado para potenciar la formación académica a través de la tecnología avanzada.
                <br><br>
                Al reservar una cita, tendrás acceso a una de nuestras salas de realidad virtual, donde un capacitador te guiará en recorridos interactivos por diversos entornos y escenarios virtuales que facilitan el aprendizaje de manera innovadora.
            </p>

            <div class="row">
                <!-- Tarjeta de Capacitación -->
                <div class="col-md-4 col-12 mb-4">
                    <div class="card text-center" style="box-shadow: 0 4px 20px rgba(93, 102, 107, 0.5); transition: transform 0.3s; border: none; min-height: 350px;">
                        <div class="card-body" style="background-color: #f8f9fa; display: flex; flex-direction: column; justify-content: center; align-items: center;">
                            <i class="fas fa-chalkboard-teacher fa-3x mb-3" style="color: #007bff;"></i>
                            <h5 class="card-title">Capacitación</h5>
                            <p class="card-text" style="text-align: center;">
                                Ofrecemos capacitación en el uso de la realidad virtual para potenciar el aprendizaje de los estudiantes.
                                Nuestros expertos te enseñarán a manejar las herramientas y aplicaciones necesarias para crear experiencias educativas unicas.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Tarjeta de Reservas -->
                <div class="col-md-4 col-12 mb-4">
                    <div class="card text-center" style="box-shadow: 0 4px 20px rgba(93, 102, 107, 0.5); transition: transform 0.3s; border: none; min-height: 350px;">
                        <div class="card-body" style="background-color: #f8f9fa; display: flex; flex-direction: column; justify-content: center; align-items: center;">
                            <i class="fas fa-calendar-check fa-3x mb-3" style="color: #007bff;"></i>
                            <h5 class="card-title">Reservas</h5>
                            <p class="card-text" style="text-align: center;">
                                Agenda tu cita para acceder a nuestros entornos virtuales y experiencias unicas.
                                Disponemos de horarios flexibles para adaptarnos a tus necesidades y facilitar tu acceso a la capacitación en realidad virtual.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Tarjeta de Soporte Técnico -->
                <div class="col-md-4 col-12 mb-4">
                    <div class="card text-center" style="box-shadow: 0 4px 20px rgba(93, 102, 107, 0.5); transition: transform 0.3s; border: none; min-height: 350px;">
                        <div class="card-body" style="background-color: #f8f9fa; display: flex; flex-direction: column; justify-content: center; align-items: center;">
                            <i class="fas fa-tools fa-3x mb-3" style="color: #007bff;"></i>
                            <h5 class="card-title">Soporte Técnico</h5>
                            <p class="card-text" style="text-align: center;">
                                Brindamos soporte técnico para asegurar el correcto funcionamiento del equipo y software de VR.
                                Nuestro equipo está disponible para resolver cualquier inconveniente y asegurar que tu experiencia sea la mejor posible.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <style>
        .card:hover {
            transform: scale(1.05);
        }
    </style>

@endsection
