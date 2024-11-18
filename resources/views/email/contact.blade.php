<!DOCTYPE html>
<html>
<head>
        <title>{{ $details['subject'] }}</title>
{{--        <title>Prueba</title>--}}
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .navbar {
            background-color: #6e1818;
            color: #fff;
            padding: 10px;
            text-align: center;
        }
        .footer {
            background-color: #6e1818;
            color: #fff;
            padding: 10px;
            text-align: center;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
        .container {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            max-width: 600px;
            margin: 20px auto;
        }
        h1 {
            color: #333;
            text-align: center;
            margin-bottom: 20px;
        }
        p {
            color: #333;
            line-height: 1.6;
            margin: 10px 0;
        }
    </style>
</head>
<body>
<div class="navbar">
    <p style="color: #FFFFFF"><strong><strong> {{ $details['subject'] }}</p>
{{--    <p style="color: #FFFFFF"><strong><strong> Prueba</p>--}}
</div>

<div class="container">

{{--    Esta mierda no se envía --}}
{{--    <div style="text-align: center;">
        <img src="{{ asset('IMG/logoUES.png') }}" alt="UES Logo" style="width: 50%; max-width: 600px;">
    </div>--}}

    <h1>Has recibido un nuevo correo electrónico</h1>
    <p><strong>De:</strong> {{ $details['name'] }}</p>
{{--    <p><strong>De:</strong> Minerva RB Lab</p>--}}
    <p><strong>Para:</strong> {{ $details['email'] }}</p>
{{--    <p><strong>Para:</strong> Prueba</p>--}}
    <p> <strong>Asunto: </strong> {{ $details['message'] }}</p>
{{--    <p><strong>Asunto:</strong> Clavito pabló un pablito</p>--}}

</div>

<div class="footer">
    <p style="color: #FFFFFF">&copy; {{ date('Y') }} Universidad de El Salvador - Facultad Multidisciplinaria Oriental.</p>
</div>
</body>
</html>
