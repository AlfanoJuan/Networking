@extends('struct')
@section('Content')
<script>
    if(`{{ session()->get('status') }}` == "Credenciales inválidas") {
        document.addEventListener("DOMContentLoaded", function(){
            Swal.fire({
                position: 'center',
                icon: 'error',
                iconColor:'#a70202',
                title: `{{ session()->get('status') }}`,
                showConfirmButton: false,
                timer: 1500
            })

        });
    }

    @php
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
    @endphp

</script>
<div class="background container-fluid min-vh-100">
    <div class="netw-inicio min-vh-80" style="">
        <div class="row" >
        <div class="col-md-7 col-12 circle d-flex align-items-center text-center">
            <div class="inner-circle d-flex align-items-center text-center">
                </div>
                <img width="50%" class="img img-fluid mx-auto" src="http://127.0.0.1:8000/imgs/Forma 1.svg" alt="EXPO LMAD 2023">
            </div>

            <div class="col-md-5 col-12 py-lg-0 py-5 px-5" style="align-self: center;">
                <div class="row">
                    <form class="my-4 form-login" id="login" action="{{ ( route ('inicioSesion.store') )}}" method="post">
                        @csrf
                        <div class="col-12 d-flex justify-content-center my-5">
                            <h1 style="font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif; font-size:-webkit-xxx-large"> BIENVENIDO </h1>
                        </div>

                        <div class="d-flex justify-content-center">

                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1"><i class="bi bi-person-fill"></i></span>
                              </div>
                              <input autofill="off" type="text" class="form-control" name="email" id="email" placeholder="Correo" required>
                            </div>

                        </div>

                        <div class="d-flex justify-content-center">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1"><i class="bi bi-lock-fill"></i></span>
                              </div>
                              <input type="password" class="form-control" name="pas" id="pas" placeholder="Contraseña" required>
                        </div>

                        <div class="d-flex justify-content-center my-5">
                            <button type="submit" class="px-5 d-inline w-auto col-md-4 col-sm-12 btn btn-primary">Iniciar sesión</button>
                        </div>

                    </form>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>
@endsection
