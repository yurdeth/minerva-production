<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Reporte de Citas</title>
</head>
<body>
    <div>
        <img src="IMG/logoUES.png" alt="Logo UES" style=" width: 80px; float: left;">
        <img src="IMG/Logo FMO.png" alt="Logo UES" style=" width: 80px; float: right;">
        <h4  class="text-center" style="font-size:16px; margin-top:20px;" >  UNIVERSIDAD DE EL SALVADOR <br>
                FACULTAD MULTIDISCIPLINARIA ORIENTAL <br>
                MINERVA RV LAB
        </h4>
        <hr style="border: 1px solid  #D8D8D6">
    </div>

    <h5 class="text-center">Reporte de asistencias a Capacitación </h5>

    <div class="table-responsive" style=" width: 100%;">
        <table class="table table-bordered text-center" style="width: 100%; margin-bottom: 0;">
            <thead style="background-color: #476679; color: white;">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Encargado</th>
                <th scope="col">Departamento</th>
                <th scope="col">Carrera</th>
                <th scope="col">Fecha</th>
                <th scope="col">Hora</th>
                <th scope="col">Participantes</th>
            </tr>
            </thead>
            <tbody>
                @foreach ($appointments as $appointment)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $appointment->name }}</td>
                        <td>{{ $appointment->department_name }}</td>
                        <td>{{ $appointment->career_name }}</td>
                        <td>{{ $appointment->date }}</td>
                        <td>{{ $appointment->start_time }}
                            a
                            {{ $appointment->end_time}}
                        </td>
                        <td>{{ $appointment->number_of_assistants }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
