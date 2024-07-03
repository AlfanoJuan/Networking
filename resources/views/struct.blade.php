<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @livewireStyles

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Networking</title>
        <link rel="icon" href="{{asset('imgs/icon2.png')}}">

        <!-- CSS only -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <link href="//cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@4/dark.css" rel="stylesheet">

        <link class="jsbin" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
    

        <!----Icons---->
        <link href='https://unpkg.com/css.gg@2.0.0/icons/css/arrow-left.css' rel='stylesheet'>
        <link href='https://unpkg.com/css.gg@2.0.0/icons/css/arrow-right.css' rel='stylesheet'>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" crossorigin="anonymous" />

        <!-- JavaScript Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
        <script class="jsbin" src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
        <script class="jsbin" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.0/jquery-ui.min.js"></script>

        <!-- Fonts -->
        <link href='https://fonts.googleapis.com/css?family=Kodchasan' rel='stylesheet'>
        <link href='https://fonts.googleapis.com/css?family=League' rel='stylesheet'>

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    </head>
    <body>
        <nav class="navbar navbar-expand-lg sticky-top navbar-dark" style="background-color: #111927;">
            <div class="container-fluid">
                <div class="col-md-0 p-2">
                    <a class="navbar-brand" href="/"> <img class="logo-img" src="{{ asset('imgs/logo-w.png') }}" height="40"> </a>
                </div>
                <button class="m-0 navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarNav">
                    @php
                    $id = session()->get('id');
                    $user = new App\Models\User();
                    $user = App\Models\User::where('id', '=', $id)->first();
                        if($user != null){

                            $rol = $user->rol;
                            if($rol == 'company')
                            {
                                $company = new App\Models\company();
                                $company = App\Models\company::where('user', '=', $user->id)->first();
                            }
                            if($rol == 'student')
                            {
                                $std = new App\Models\student();
                                $std = App\Models\student::where('user', '=', $user->id)->first();
                            }
                            if($rol == 'admin')
                            {
                                $admin = new App\Models\user();
                                $admin = App\Models\user::where('id', '=', $user->id)->first();
                            }

                        }

                    @endphp

                    <ul class="nav navbar-nav navbar-left">
                        @if(!empty($admin))
                            <li class="nav-item mx-lg-5 mx-2">
                                <a style="background: linear-gradient(to left, rgba(0, 175, 196, 0), #c53aff69); border-radius: 15px" href="{{route('adminInterests.index')}}" class="nav-link btn-w2">
                                    <p style="text-decoration: unset" class="my-0 mx-lg-5 mx-2 nav-txt nav-index"> Intereses </p>
                                </a>
                            </li>

                            <li class="nav-item mt-2 mt-lg-0">
                                <a style="background: linear-gradient(to left, rgba(0, 175, 196, 0), #c53aff69); border-radius: 15px" href="{{route('adminExpo.index')}}" class="nav-link btn-w2">
                                    <p style="text-decoration: unset" class="my-0 mx-lg-5 mx-2 nav-txt nav-index"> EXPOS registradas </p>
                                </a>
                            </li>
                        @endif
                    </ul>

                    <ul class="nav navbar-nav ms-auto me-2">

                        <li class="nav-item">
                            <a class="nav-link"
                                @if(!empty($company))
                                    href="{{route('empresa.index')}}"
                                @endif

                                @if(!empty($std))
                                    href="{{route('estudiante.index')}}"
                                @endif

                                @if(!empty($admin))
                                    href="{{route('admin.index')}}"
                                @endif>
                            </a>
                        </li>


                        @if (!session()->has('id'))
                            <li class="nav-item m-2">
                                <a class="nav-link btn-w" href="{{route('inicioSesion.index')}}">
                                    <p class="my-0 mx-5 nav-txt nav-index"> Ingresar </p>
                                </a>
                            </li>
                        @else

                            <li class="nav-item mx-lg-5 mx-2">
                                <a style="background: linear-gradient(to left, rgba(0, 175, 196, 0), #c53aff69); border-radius: 15px" class="nav-link btn-w2" href="{{route('cerrarSesion')}}">
                                    <p class="my-0 mx-2 nav-txt nav-index"> Salir </p>
                                </a>
                            </li>

                            <li class="nav-item mx-lg-0 mx-2 mt-2 mt-lg-0">
                                <a style="background: linear-gradient(to left, rgba(0, 175, 196, 0), #00AFC4); border-radius: 15px" class="nav-link btn-w2" id="nav-name" 
                                    @if(!empty($company))
                                        href="{{route('empresa.show', $id)}}"
                                    @endif
                                    @if(!empty($std))
                                        href="{{route('estudiante.show', $id)}}"
                                    @endif
                                    @if(!empty($admin))
                                        href="{{route('admin.index')}}"
                                    @endif>

                                    <p class="my-0 mx-2 nav-txt nav-index" > <!-- <i class="bi bi-person-fill"></i> -->
                                        @if(!empty($company))
                                            {{$company->fullName}}
                                        @endif
                                        @if(!empty($std))
                                            {{$std->fullName}}
                                        @endif
                                        @if(!empty($admin))
                                            Administrador
                                        @endif
                                    </p>
                                </a>
                            </li>

                        @endif


                    </ul>

                </div>

            </div>
        </nav>
        @livewireScripts
        @yield('Content')

    </body>
</html>
