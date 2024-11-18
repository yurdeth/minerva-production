<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Reporte de Inventario</title>
</head>
<body>

<style>
    .firma {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        text-align: center;
        padding: 10px 0;
    }
</style>
    <div>
        <img src="IMG/logoUES.png" alt="Logo UES" style=" width: 80px; float: left;">
        <img src="IMG/Logo FMO.png" alt="Logo UES" style=" width: 80px; float: right;">
        <h4  class="text-center" style="font-size:16px; margin-top:20px;" >  UNIVERSIDAD DE EL SALVADOR <br>
                FACULTAD MULTIDISCIPLINARIA ORIENTAL <br>
                MINERVA RV LAB
        </h4>
        <hr style="border: 1px solid  #D8D8D6">
    </div>
    
    <h5 class="text-center">Reporte de Inventario</h5>

    <div class="table-responsive" style=" width: 100%;">
        <table class="table table-bordered text-center" style="width: 100%; margin-bottom: 0; border-collapse: collapse;">
            <thead style="background-color: #476679; color: white;">
                <tr>
                    <th>Número de sala</th>
                    <th>Tipo de recurso</th>
                    <th>Estado</th>
                    <th>Número de activo fijo</th>
                </tr>
            </thead>
            <tbody>
                @foreach($resources as $resource)
                <tr>
                    <td>{{ $resource->room->name }}</td>
                    <td>{{ $resource->resourceType->resource_name }}</td>
                    <td>
                        @if($resource->status['status'] == 'Mal estado')
                            <span style="color: #973131;">Mal estado</span>
                        @elseif($resource->status['status'] == 'Buen estado')
                            <span style="color: #0B5ED7;;">Buen estado</span>
                        @elseif($resource->status['status'] == 'En reparación')
                            <span style="color: #5F8670;">En reparación</span>
                        @endif
                    </td>
                    <td style="padding: 10px; border: 1px solid #dee2e6;">{{ $resource->fixed_asset_code }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <br>
        <div class="firma">
        <span>Firma: ______________________________</span>
        </div>
    </div>
</body>
</html>
