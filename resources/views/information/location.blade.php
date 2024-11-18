@extends('layouts.layout')

@section('content')
<section>
    <div class="container mb-5">
        <div class="card" style="box-shadow: 0 4px 8px rgba(93, 102, 107, 0.419), 0 6px 20px rgba(51, 152, 206, 0.419);">
            <div class="card-body">
                <h1 class="text-center">Ubicación </h1>
                <hr><br>
                <div class="row" style="align-items: center;">
                    <div class="col-md-6 col-12" style="padding-right: 10px; padding-bottom: 15px;">
                        <h2>¡Nuestra Ubicación!</h2>
                        <p style="text-align:justify; margin-bottom: 0;">
                            Puedes visitarnos en el Segundo nivel de la Unidad Bibliotecaria. Universidad de El Salvador, <br>
                             Facultad Multidisciplinaria Oriental, Carretera al Cuco Km144, San Miguel, San Miguel.
                        </p>

                    </div>
                    <div class="col-md-6 col-12" style="padding-left: 10px;">
                        <div class="map-container" style="position: relative; width: 100%; height: 0; padding-bottom: 56.25%;">
                            <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d242.53425659763352!2d-88.1582831!3d13.4402752!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8f7ad606207f4beb%3A0x52e490dcfdd9b2c5!2sUnidad%20Bibliotecaria!5e0!3m2!1ses-419!2ssv!4v1728956626768!5m2!1ses-419!2ssv"
                                style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: 0; border-radius: 8px;"
                                allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                            </iframe>
                            <br>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row" style="align-items: center;">
                    <div class="col-md-6 col-12"  style="padding-bottom: 15px;">
                        <h2>¡Te invitamos a visitarnos!</h2> <br>
                        <p style="text-align:justify; margin-bottom: 0;">
                                En el Minerva RV Lab te ofrece acceso a un ambiente cómodo y moderno, ideal para el aprendizaje y la investigación.
                                No pierdas la oportunidad de conocernos y aprovechar todo lo que tenemos para ofrecer. ¡Ven y descubre cómo podemos
                                apoyarte en tu desarrollo académico
                        </p>
                    </div>
                    <div class="col-md-6 col-12"  style="padding-bottom: 15px;">
                        <img class="img-fluid" src="{{asset('IMG/RVLab2.jpg')}}" alt="Quienes Somos" style="border-radius:6px; width: 100%;">
                    </div>
                </div>
            </div>
    </div>
</section>


@endsection
