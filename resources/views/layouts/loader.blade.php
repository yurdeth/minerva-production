<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loader</title>
</head>
<body>
    <!--Loader del sistema de gestion de citas-->
    <div class="loader-sistema" id="loader">
        <div class="loader"></div>
        <h1 class="loader-message">MINERVA RV LAB</h1>
    </div>

    <!--Style del loader-->
    <style>
        .loader-sistema{
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgb(27, 34, 39);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .loader{
            width: 48px;
            height: 48px;
            display: inline-block;
            position: relative;
        }

        .loader::after,
        .loader::before{
            content: '';
            width: 48px;
            height: 48px;
            border: 2px solid #FFF;
            position: absolute;
            left: 0;
            top: 0;
            box-sizing: border-box;
            animation: rotation 2s ease-in-out infinite;
        }

        .loader::after{
            border-color: #FF3D00;
            animation-delay: 1s;
        }

        @keyframes rotation {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
        }

        .loader-message {
            color: white;
            font-size: 1.5rem;
            margin-top: 20px;
            font-family: Arial, sans-serif;
        }

    </style>
</body>
</html>
