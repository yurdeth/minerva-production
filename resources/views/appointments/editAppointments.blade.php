@extends('layouts.layout')

@section('content')

<style>
    .btn-primary {
    background-color: #007bff;
    border-color: #007bff;
    color: #fff;
    padding: 8px 18px;
    cursor: pointer;
    border-radius: 3px;
    border: none;
    text-decoration: none;
    width: 100%;
    display: block;
    margin-bottom: 5px;
}

    .btn-danger {
    background-color: #d33;
    border-color: #f65e3f;
    color: white;
    border: none;
    padding: 8px 18px;
    cursor: pointer;
    border-radius: 3px;
    width: 100%;
    display: block;
    margin-bottom: 5px;
}
</style>

    <div class="container-sm" style="margin-top: 70px; margin-bottom: 70px; max-width: 950px;">
        <div class="row">
            <div class="col-2"></div>
            <div class="col-8 bg-white p-5 text-center">
                <h2>Editar datos de la Cita</h2>

                <form id="updateForm" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group position-relative p-2">
                        <p class="text-start">Fecha</p>
                        <input type="date" class="form-control" id="date" name="date"
                               style="padding-left: 30px;" required onchange="showAvailableShedules()">
                    </div>

                    <div class="row">
                        <div class="col-md-6 form-group position-relative ps-3">
                            <p class="text-start">Hora de inicio</p>
                            <input type="time" class="form-control" id="start-time"
                                   name="start-time" placeholder="" style="padding-left: 30px;" required>
                        </div>

                        <div class="col-md-6 form-group position-relative pe-3">
                            <p class="text-start">Hora de finalización</p>
                            <input type="time" class="form-control" id="end-time"
                                   name="end-time" placeholder="" style="padding-left: 30px;" required>
                        </div>
                    </div>

                    <div class="form-group position-relative p-2 text-center" id="loadAvailableSchedules"></div>

                    <div class="form-group position-relative p-2">
                        <p class="text-start">Número de Asistentes</p>
                        <input type="number" class="form-control" id="number_of_assistants" name="number_of_assistants"
                               style="padding-left: 15px;" min="1" max="72">
                    </div>

                    @if(Auth::user()->roles_id == 1)
                        <div class="form-group position-relative p-2">
                            <p class="text-start">Responsable</p>
                            <input type="text" class="form-control" id="name"
                                   style="padding-left: 15px;" min="1" max="20" readonly>
                        </div>
                    @endif
                </form>
                <div id="actionsButtons" class="row"></div>
            </div>
            <div class="col-2"></div>
        </div>
    </div>

    <script defer type="module" src="{{asset("js/utils/alert.js")}}"></script>
    <script defer type="module" src="{{asset("js/utils/api.js")}}"></script>
    <script defer type="module" src="{{ asset('js/appointments/viewAppointment.js') }}"></script>
    <script defer src="{{ asset('js/appointments/showAvailableShedules.js') }}"></script>

    <script defer>
        document.addEventListener('DOMContentLoaded', function (){
            setTimeout(() => {
                showAvailableShedules();
            }, 1000);
        });
    </script>

@endsection
