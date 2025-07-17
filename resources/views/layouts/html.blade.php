<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <title>Cahina-chimbote</title>
        <style>

            ::-webkit-scrollbar{
                display: none
            }

            body{
                background: #aaa
            }

            form{
                background: #ccc
            }

            form input{
                outline:  none;
                border: none
            }

            #alerta{
                position: absolute;
                right: 10px;
                margin: 10px;

                animation: alertas 1.5s linear forwards;
            }

            @keyframes alertas{
                100%{
                    right: -200px;
                    opacity: 0;
                }
            }

        </style>
</head>
<body>
    @yield('content')
</body>
</html>