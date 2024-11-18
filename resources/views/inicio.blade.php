<!--Incluimos el header y footer del layout-->
@extends('layouts.layout')

{{--Section para poder trabajar con layout --}}
@section('content')
    <link rel="stylesheet" href="{{ asset('CSS/General/carousel.css')}}">

        <!--Carousel-->
        <div class="carousel-Principal">
            <div class="list">
                <div class="item">
                    <img src="{{ asset('IMG/escena3.png') }}" alt="escanas">
                    <div class="content">
                        <div class="title">Bienvenido al Minerva RV Web </div>
                        <div class="des">
                            Sumérgete en una experiencia única donde la realidad se fusiona con la imaginación. <br>
                            ¡Bienvenido a la nueva dimensión de la realidad virtual!"
                        </div>
                        <div class="buttons">
                            <button><a href="{{ route('iniciarSesion') }}">Agendar cita</a></button>
                        </div><br>
                        <div class="derechos">Derechos de imagen de viroo</div>
                    </div>
                </div>

                <div class="item">
                    <img src="{{ asset('IMG/escena1.png') }}" alt="escanas">
                    <div class="content">
                        <div class="title">Bienvenido al Minerva RV Web </div>
                        <div class="des">
                            Descubre el fascinante proceso de construcción desde sus cimientos <br> hasta la última pieza,
                            vive el emocionante mundo de la <br> arquitectura y la ingeniería en acción
                            ¡Bienvenido a la realidad virtual!"
                        </div>
                        <div class="buttons">
                            <button><a href="{{ route('iniciarSesion') }}">Agendar cita</a></button>
                        </div><br>
                        <div class="derechos">Derechos de imagen de viroo</div>
                    </div>
                </div>

                <div class="item">
                    <img src="{{ asset('IMG/escena4.png') }}" alt="escanas">
                    <div class="content">
                        <div class="title">Bienvenido al Minerva RV Web </div>
                        <div class="des">
                            Entra al escenario definitivo para los amantes de los autos. <br>
                            Recorre un espectacular car show al alcance de tu mano <br>
                            ¡Bienvenido a la realidad virtual!"
                        </div>
                        <div class="buttons">
                            <button><a href="{{ route('iniciarSesion') }}">Agendar cita</a></button>
                        </div><br>
                        <div class="derechos">Derechos de imagen de viroo</div>
                    </div>
                </div>

                <div class="item">
                    <img src="{{ asset('IMG/escena5.png') }}" alt="escanas">
                    <div class="content">
                        <div class="title">Bienvenido al Minerva RV Web </div>
                        <div class="des">
                            Adéntrate en el asombroso mundo del cuerpo humano como nunca antes <br>
                            observa y explora cada órgano, músculo y sistema en detalle <br>
                            ¡Bienvenido a la realidad virtual!"
                        </div>
                        <div class="buttons">
                            <button><a href="{{ route('iniciarSesion') }}">Agendar cita</a></button>
                        </div><br>
                        <div class="derechos">Derechos de imagen de viroo</div>
                    </div>
                </div>

                <div class="item">
                    <img src="{{ asset('IMG/escena6.png') }}" alt="escanas">
                    <div class="content">
                        <div class="title">Bienvenido al Minerva RV Web </div>
                        <div class="des">
                            Sumérgete en el entorno controlado de un invernadero donde la <br>
                            tecnología y la naturaleza se encuentran. Aprende sobre las técnicas modernas de cultivo,
                            <br> el uso de sistemas de riego automatizado etc. <br>
                            ¡Bienvenido a la realidad virtual!"
                        </div>
                        <div class="buttons">
                            <button><a href="{{ route('iniciarSesion') }}">Agendar cita</a></button>
                        </div><br>
                        <div class="derechos">-</div>
                    </div>
                </div>
            </div>

            <div class="thumbnail">
                <div class="item">
                    <img src="{{ asset('IMG/escena3.png') }}" alt="escanas">
                </div>

                <div class="item">
                    <img src="{{ asset('IMG/escena1.png') }}" alt="escanas">
                </div>

                <div class="item">
                    <img src="{{ asset('IMG/escena4.png') }}" alt="escanas">
                </div>

                <div class="item">
                    <img src="{{ asset('IMG/escena5.png') }}" alt="escanas">
                </div>

                <div class="item">
                    <img src="{{ asset('IMG/escena6.png') }}" alt="escanas">
                </div>

            </div>

            <!--Buttons con las arrows de movimiento-->
            <div class="arrows">
                <button id="prev"><</button>
                <button id="next">></button>
            </div>
            <div class="time"></div>
        </div>

        <!--Contenido de la pagina-->
        <section>
        <!--Mensaje de Bienvenida-->
        <div class="mensaje">
            <h1>Minerva RV Web FMO <br> Tu espacio para poder agendar citas para recibir capacitación.</h1>
        </div>
        <br><br>
        <!--Contenido Principal-->
        <div class="container">
            <div class="row justify-content-center align-items-center">
                <div class="col-md-3 text-center">
                    <img class="robot img-fluid" src="{{ asset('IMG/Robot_transparente.png') }}" alt="Robot">
                </div>
                <div class="col-md-6 mt-3 mt-md-0">
                    <div class="card mb-3">
                        <div class="card-body card-mensaje">
                            <p class="card-text">En un mundo en constante avance y desarrollo tecnológico, es fundamental que la educación camine de la mano con la ciencia y la tecnología.
                                En la Universidad de El Salvador, somos conscientes de esto, por lo que te extendemos una cordial invitación a visitar el Minerva VR Lab, una innovadora forma de enseña
                            </p>
                        </div>
                    </div>

                </div>

            </div>
            <br>
        </div>
        <div class="mensaje2">
            <h3>Visítanos y vive la experiencia del emocionante <br> mundo de la realidad virtual.</h3>
        </div>
        <!--Parte del Carousel-->
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-md-8">
                    <div class="card">
                        <div class="card-body fotosSlide">
                            <div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-inner">
                                    <div class="carousel-item active">
                                        <img src="{{ asset('IMG/vr1.png') }}" class="d-block w-100" alt="...">
                                    </div>
                                    <div class="carousel-item">
                                        <img src="{{ asset('IMG/vr2.png') }}" class="d-block w-100" alt="...">
                                    </div>
                                    <div class="carousel-item">
                                        <img src="{{ asset('IMG/vr3.jpeg') }}" class="d-block w-100" alt="...">
                                    </div>
                                    <div class="carousel-item">
                                        <img src="{{ asset('IMG/vr4.jpeg') }}" class="d-block w-100" alt="...">
                                    </div>
                                    <div class="carousel-item">
                                        <img src="{{ asset('IMG/vr5.jpg') }}" class="d-block w-100" alt="...">
                                    </div>
                                    <div class="carousel-item">
                                        <img src="{{ asset('IMG/vr6.jpg') }}" class="d-block w-100" alt="...">
                                    </div>
                                </div>
                                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <br><br>
    </section>

    <script src="{{asset("js/themes/carousel.js")}}"></script>
@endsection
