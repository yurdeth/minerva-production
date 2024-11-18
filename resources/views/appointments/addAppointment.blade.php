<!--Incluimos el header y footer del layout-->
@extends('layouts.layout')

{{--Section para poder trabajar con layout --}}
@section('content')
        <div class="container-fluid" style="margin-top: 70px; margin-bottom: 70px; max-width: 950px;">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-md-10 col-sm-12 bg-white p-5 text-center" style="box-shadow: 0 4px 8px rgba(93, 102, 107, 0.419), 0 6px 20px rgba(51, 152, 206, 0.419); border-radius: 6px;">
                    <h2>Formulario de Solicitud de Cita</h2>
                    <form class="" method="post">
                        @csrf
                        <div class="form-group position-relative p-2">
                            <p class="text-start">Numero de Asistentes</p>
                            <input type="number" class="form-control" id="number_of_assistants" name="number_of_assistants"
                                       placeholder="n° de personas (Máx. 72)" style="padding-left: 15px;" min="1" max="72"
                                       required>
                        </div>

                        <div class="form-group position-relative p-2">
                            <p class="text-start">Fecha</p>
                            <input type="date" class="form-control" name="date" id="date"
                                style="padding-left: 30px;" required onchange="showAvailableShedules()">
                        </div>

                        <div class="row">
                            <div class="col-md-6 form-group position-relative ps-3">
                                <p class="text-start">Hora de inicio</p>
                                <input type="time" class="form-control" id="start-time" name="start-time" required>
                            </div>
                            <div class="col-md-6 form-group position-relative pe-3">
                                <p class="text-start">Hora de finalización</p>
                                <input type="time" class="form-control" id="end-time" name="end-time" required>
                            </div>
                        </div>

                        <div class="form-group position-relative p-2 text-center" id="loadAvailableSchedules"></div>
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="modal-calendario">
                                    <!-- Modal para el calendario -->
                                    <div class="modal fade" id="calendarModal" aria-hidden="true"
                                              aria-labelledby="calendarModalLabel" tabindex="-1">
                                        <div class="modal-dialog modal-dialog-centered modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="calendarModalLabel">Calendario</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close">
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div id="calendar">
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    <!-- Modal para la fecha seleccionada -->
                                    <div class="modal fade" id="dateModal" aria-hidden="true" aria-labelledby="dateModalLabel" tabindex="-1">
                                         <div  class="modal-dialog modal-dialog-centered modal-lg">
                                            <div class="modal-content border border-primary-subtle bg-secondary bg-gradient" >
                                                <div class="modal-header">
                                                    <h5 class="modal-title text-light" id="dateModalLabel">Fecha seleccionada</h5>
                                                    <a type="button text-light" class="btn btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close">
                                                    </a>
                                                </div>
                                                <div class="modal-body container" style="padding: 20px;">
                                                    <div id="selectedDate" class="row justify-content-center align-items-center" style="height: 100%;">
                                                    </div>
                                                </div>
                                            </div>
                                         </div>
                                    </div>




                                    <!-- Botón para abrir el modal del calendario -->
                                    <button type="button" class="btn btn-primary m-2 w-100" id="btnOpenCalendar"
                                        data-bs-toggle="modal" data-bs-target="#calendarModal">Mostrar calendario
                                    </button>

                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <button type="submit" class="btn text-white m-2 w-100" id="submitButton" style="background-color: #660D04;">
                                    Agendar
                                </button>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            localStorage.removeItem('rutaImagen');
        });
    </script>
    <script type="module" src="{{asset("js/utils/alert.js")}}"></script>
    <script type="module" src="{{asset("js/utils/api.js")}}"></script>
    <script type="module" src="{{ asset('js/appointments/addAppointment.js') }}"></script>
    <script src="{{ asset('js/appointments/showAvailableShedules.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"
            integrity="sha256-ZztCtsADLKbUFK/X6nOYnJr0eelmV2X3dhLDB/JK6fM=" crossorigin="anonymous"></script>
    <script src="{{ asset("js/calendar/calendar.js") }}"></script>
@endsection
