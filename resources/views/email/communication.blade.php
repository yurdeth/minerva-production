@extends('administration.dashboard')
@section('title', 'Mensajes')


@section('content_header')
    <h1>Mensajes</h1><br>
@stop

@section('content')
    <link rel="stylesheet" href="{{ asset('CSS/administracion/mensajes.css')}}">
    <link rel="stylesheet" href="{{ asset('CSS/administracion/tables.css')}}">
    <section>
        <h4>En este apartado, puede enviar mensajes a un usuario en particular.</h4><br>
        <img class="mensajesIMG" src="{{ asset('IMG/Mensajes.jpg') }}" alt="IMGMensajes"><br>
        <div class="mensajeContent">
            <h4>Redactar un Nuevo Correo.</h4><br>
            <div>
                <div class="form-group">
                    <input list="emails" type="email" class="form-control" id="email" name="email"
                           placeholder="Selecciona o ingresa un correo" required>
                    <datalist id="emails"></datalist>
                </div>
                <br>

                <div class="form-group">
                    <input type="text" class="form-control" id="subject" name="subject" placeholder="Ingresa el asunto"
                           required>
                </div>
                <br>

                <div class="form-group">
                    <textarea class="form-control" id="message" name="message" rows="5"
                              placeholder="Escribe tu mensaje aquí" required></textarea>
                </div>
                <div class="button-group">
                    <button type="submit" class="btn-submit" id="sendMailButton">Enviar</button>
                    <button type="submit" class="btn-cancel" id="cancelButton">Cancelar</button>
                </div>
            </div>

            <div class="opcionesMensaje">
                <button class="btn btn-PrimaryM" id="openModalBtn">Buscar Usuario</button>
            </div>
        </div>

        <!--Modal para hacer la busqueda -->
        <div class="modal" id="buscarModal">
            <!-- contenido del Modal -->
            <div class="modal-content">
                <div class="cerrar">
                    <span class="close">X</span>
                </div>
                <h3>Buscar Usuario Registrados</h3>
                <!-- Barra de busqueda -->
                <div class="button-container">
                    <form action="" id="searchForm" style="margin-left: auto;">
                        <div class="input-group inline-form-group">
                            <input list="emails" class="form-control me-5" id="emailModal" name="emailModal"
                                   placeholder="Selecciona o ingresa un correo" required style="width: 300px">
                            <datalist id="emails"></datalist>
                        </div>
                        <div class="input-group inline-form-group">
                            <button type="button" class="btn btn-PrimaryM ms-5" id="sendPasswordButton">Buscar</button>
                        </div>
                    </form>
                </div>
                <!-- tabla con los datos -->
                <div class="table-responsive" style="height: 100%; width: 100%;">
                    <table class="table table-bordered text-center" id="usuariosAPITable"
                           style="width: 100%; margin-bottom: 0;">
                        <thead class="table-avatar">
                        <tr>
                            <th scope="col">Nombre</th>
                            <th scope="col">Correo</th>
                            <th scope="col">Departamento</th>
                            <th scope="col">Carrera</th>
                            <th scope="col">Estado</th>
                        </tr>
                        </thead>
                        <tbody id="table-body"></tbody>
                    </table>
                </div>
                <div id="pagination" class="pagination-container">
                    <button type="submit" class="btn btn-PrimaryM" id="confirmPasswordSubmition">Confirmar envío de contraseña</button>
                </div>
            </div>
        </div>

    </section>

    <script>
        //Definimos las variables a emplear
        let openModal = document.getElementById("openModalBtn");
        let closeModalSpan = document.getElementsByClassName("close")[0];
        var modal = document.getElementById("buscarModal");

        //Funcion para abrir el modal
        openModal.addEventListener('click', (e) => {
            e.preventDefault();
            modal.classList.add('modalShow');

        });

        //Funcion para Cerrar el modal al hacer clic en el botón de cerrar
        closeModalSpan.onclick = function (e) {
            e.preventDefault();
            modal.classList.remove('modalShow');
        }
    </script>

    <script src="{{ asset('js/mailing/sendNewMail.js') }}" type="module"></script>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('CSS/administracion.css')}}">
@stop
