@extends('struct')
@section('Content')

<style>

    .card-body>.row {
        padding-top: 5px;
        padding-bottom: 5px;
    }

    .card-body {
        padding-top: 5px;
        padding-bottom: 5px;
    }

    .bi{
        color: white;
    }
</style>

<script>

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#editEventImg').attr('src', e.target.result).width(300).height(200);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }

</script>

<div class="background-2 container-fluid min-vh-100">

    <div class="sticky-center">
        <form class="row align-items-center pt-3 pb-5" id="registroEmpresa" action="{{route('adminEmpresa.update', [$cmpy->id])}}" method="post">
            @csrf
            @method('PUT')
            <h1 class="mb-3" style="text-align: center;"> Editando Empresa </h1>
            <hr class="" style="border: 1px solid; border-image: linear-gradient(to left, #0000, #C53AFF, #0000); border-image-slice: 1; border-radius:50%; opacity:100%">

            <div class="row">

                <div class="col-md-8 col-sm-12 col-12 mx-auto mt-3 mt-md-0 py-md-4 px-md-5 px-4">

                    <div class="row mb-4">
                        <div class="col-sm-5 d-flex align-items-center justify-content-center justify-content-sm-end">
                            <h5 class="mb-md-0 mb-2">Nombre de la Empresa</h5>
                        </div>
                        <div class="col-sm-6 text-secondary">
                            <input class="form-control col-11" type="text" name="regCompanyName" id="regCompanyName" value="{{$cmpy->fullName}}"required>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-sm-5 d-flex align-items-center justify-content-center justify-content-sm-end">
                            <h5 class="mb-md-0 mb-2"  style="align-self: top;">Correo</h5>
                        </div>
                        <div class="col-sm-6 text-secondary">
                            <input class="form-control col-11" type="text" name="regCompanyEmail" id="regCompanyEmail" value="{{$user->email}}" readonly>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-sm-5 d-flex align-items-center justify-content-center justify-content-sm-end">
                            <h5 class="mb-md-0 mb-2"  style="align-self: top;">Contraseña</h5>
                        </div>
                        <div class="col-sm-6 text-secondary">
                            <input class="form-control col-11" type="text" name="regCompanyPass" id="regCompanyPass" placeholder="Deje en blanco si no desea editar la contraseña">
                        </div>
                    </div>                         

                    @php
                        $numRedes = count($companyNetworks);
                    @endphp

                    @if($numRedes == 0)
                    <div class="row mb-4">
                        <div class="col-sm-5 d-flex justify-content-center justify-content-sm-end">
                            <h5 class="mb-md-0 mb-2"  style="align-self: center;">Redes Sociales</h5>
                        </div>
                        <div class="col-sm-7 d-flex align-items-center"> 
                            <select id="red1" name="red1" style="display: none;">
                                <option value="linkedin" selected>Linkedin</option>
                                <option value="facebook">Facebook</option>
                                <option value="instagram">Instagram</option> 
                                <option value="artstudio">Artstudio</option>   
                            </select>

                            <div class="select2-custom1">
                                <span class="d-flex justify-content-between selected-option1"><i class="bi bi-linkedin"></i><i class="bi bi-caret-down-fill"></i></span> <!-- Muestra el icono de LinkedIn por defecto -->
                                <ul class="options1">
                                    <li data-value="linkedin"><i class="bi bi-linkedin"></i></li>
                                    <li data-value="facebook"><i class="bi bi-facebook"></i></li>
                                    <li data-value="instagram"><i class="bi bi-instagram"></i></li>
                                    <li data-value="artstation"><i class="fa-brands fa-artstation" style="color: white"></i></li>
                                </ul>
                            </div>
                            <input class="form-control" type="text" name="regCompanyRed1" id="regCompanyRed1">
                            <button id="newRed" type="button" class="btn" style="margin-right: 22px"><i class="bi bi-plus-circle"></i></button>
                        </div>
                    </div>
                    @endif

                    @foreach ($companyNetworks as $key => $cNetwork)
                    <div class="row mb-4">
                        <div class="col-sm-5 d-flex justify-content-center justify-content-sm-end">
                            @if($key == 0)
                                <h5 class="mb-md-0 mb-2"  style="align-self: top;">Redes Sociales</h5>
                            @endif
                        </div>
                        <div class="col-sm-6 d-flex align-items-center red{{$key + 1}}"> 
                            <select id="red{{$key + 1}}" name="red{{$key + 1}}" style="display: none;">
                                <option value="linkedin" @if($cNetwork->red == "linkedin") selected @endif>Linkedin</option>
                                <option value="facebook" @if($cNetwork->red == "facebook") selected @endif>Facebook</option>
                                <option value="instagram" @if($cNetwork->red == "instagram") selected @endif>Instagram</option> 
                                <option value="artstation" @if($cNetwork->red == "artstation") selected @endif>Artstation</option>   
                            </select>

                            <div class="select2-custom{{$key + 1}}">
                                <span class="d-flex justify-content-between selected-option{{$key + 1}}">
                                    @if($cNetwork->red == "artstation")
                                        <i class="pt-1 fa-brands fa-artstation" style="color: white"></i>
                                    @else
                                        <i class="bi bi-{{$cNetwork->red}}"></i>
                                    @endif>
                                        <i class="bi bi-caret-down-fill"></i>
                                </span>
                                <ul class="options{{$key + 1}}">
                                    <li data-value="linkedin"><i class="bi bi-linkedin"></i></li>
                                    <li data-value="facebook"><i class="bi bi-facebook"></i></li>
                                    <li data-value="instagram"><i class="bi bi-instagram"></i></li>
                                    <li data-value="artstation"><i class="fa-brands fa-artstation" style="color: white"></i></li>
                                </ul>
                            </div>
                            <input class="form-control" type="text" name="regCompanyRed{{$key + 1}}" id="regCompanyRed{{$key + 1}}" value="{{$cNetwork->link}}">
                        </div>
                    </div>
                    @endforeach            

                    <div class="row mb-4 addRed" style="display: none;">
                        <div class="col-sm-5 d-flex justify-content-center justify-content-sm-end">
                        </div>
                        <div class="col-sm-7 d-flex align-items-center"> 
                            <select id="red2" name="red4" style="display: none;">
                                <option value="linkedin">Linkedin</option>
                                <option value="facebook" selected>Facebook</option>
                                <option value="instagram">Instagram</option> 
                                <option value="artstudio">Artstudio</option>   
                            </select>

                            <div class="select2-custom2">
                                <span class="d-flex justify-content-between selected-option2"><i class="bi bi-facebook"></i><i class="bi bi-caret-down-fill"></i></span> <!-- Muestra el icono de LinkedIn por defecto -->
                                <ul class="options2">
                                    <li data-value="linkedin"><i class="bi bi-linkedin"></i></li>
                                    <li data-value="facebook"><i class="bi bi-facebook"></i></li>
                                    <li data-value="instagram"><i class="bi bi-instagram"></i></li>
                                    <li data-value="artstation"><i class="fa-brands fa-artstation" style="color: white"></i></li>
                                </ul>
                            </div>
                            <input class="form-control" type="text" name="regCompanyRed4" id="regCompanyRed4">
                            <button id="newRed2" type="button" class="btn" style="margin-right: 22px"><i class="bi bi-plus-circle"></i></button>
                        </div>
                    </div>

                    <div class="row mb-4 addRed2" style="display: none;">
                        <div class="col-sm-5 d-flex justify-content-center justify-content-sm-end">
                        </div>
                        <div class="col-sm-6 d-flex align-items-center"> <!-- Contenedor flex para alinear elementos verticalmente -->
                            <select id="red3" name="red5" style="display: none;">
                                <option value="linkedin">Linkedin</option>
                                <option value="facebook" selected>Facebook</option>
                                <option value="instagram">Instagram</option> 
                                <option value="artstudio">Artstudio</option>   
                            </select>

                            <div class="select2-custom3">
                                <span class="d-flex justify-content-between selected-option3"><i class="bi bi-facebook"></i><i class="bi bi-caret-down-fill"></i></span> <!-- Muestra el icono de LinkedIn por defecto -->
                                <ul class="options3">
                                    <li data-value="linkedin"><i class="bi bi-linkedin"></i></li>
                                    <li data-value="facebook"><i class="bi bi-facebook"></i></li>
                                    <li data-value="instagram"><i class="bi bi-instagram"></i></li>
                                    <li data-value="artstation"><i class="fa-brands fa-artstation" style="color: white"></i></li>
                                </ul>
                            </div>
                            <input class="form-control" type="text" name="regCompanyRed5" id="regCompanyRed5">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-5 d-flex justify-content-center justify-content-sm-end">
                            <h5 class="mb-md-0 mb-2"  style="align-self: top;">Intereses</h5>
                        </div>
                        <div class="col-sm-5">
                            <div class="form-floating">
                                <select class="form-select col-11" id="regCompanyInterests" name="regCompanyInterests[]" multiple="multiple" size="5" style="overflow-y: auto; height:100%">
                                    @foreach ($allInterests as $interest)
                                        <option value="{{$interest->id}}"
                                            @foreach ($interests as $int)
                                                @if($interest->id == $int->id)
                                                selected
                                                @endif
                                            @endforeach
                                            >{{$interest->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <span style="color:snow; opacity: 30%">Seleccione uno o más intereses</span>

                        </div>
                    </div>
                </div>
            </div>


                <div class="col-12" style="text-align:center;">
                    <button id="regCompany" type="submit" class="px-5 d-inline w-auto col-md-4 col-sm-12 btn btn-primary">CONFIRMAR</button>
                </div>

        </form>
    </div>

</div>

<script>
    
    $(document).ready(function() {
    
        var numRedes = {{ $numRedes }};

        if (numRedes == 1) {

            var container = document.querySelector('.d-flex.align-items-center.red1');

            var button = document.createElement('button');
            button.setAttribute('id', 'newRed');
            button.setAttribute('type', 'button');
            button.classList.add('btn');
            button.style.marginRight = '-42px';

            var icon = document.createElement('i');
            icon.classList.add('bi', 'bi-plus-circle');

            button.appendChild(icon);

            container.appendChild(button);
        }
        if (numRedes == 2) {

            var container = document.querySelector('.d-flex.align-items-center.red2');

            var button = document.createElement('button');
            button.setAttribute('id', 'newRed2');
            button.setAttribute('type', 'button');
            button.classList.add('btn');
            button.style.marginRight = '-42px';

            var icon = document.createElement('i');
            icon.classList.add('bi', 'bi-plus-circle');

            button.appendChild(icon);

            container.appendChild(button);
        }
    });

    $(document).ready(function() {
        $('#newRed').click(function() {   
            $('.addRed').toggle(); 
            if ($('.addRed').is(':visible')) {
                $('#newRed i').removeClass('bi-plus-circle').addClass('bi-dash-circle');
            } else {
                $('#newRed i').removeClass('bi-dash-circle').addClass('bi-plus-circle');
            }
        });

        $('#newRed2').click(function() {   
            $('.addRed2').toggle(); 
            if ($('.addRed2').is(':visible')) {
                $('#newRed2 i').removeClass('bi-plus-circle').addClass('bi-dash-circle');
            } else {
                $('#newRed2 i').removeClass('bi-dash-circle').addClass('bi-plus-circle');
            }
        });

        $('.select2-custom1').click(function() {
            $(this).find('.options1').toggle();
        });

        $('.select2-custom1 .options1 li').click(function() {
            var value = $(this).data('value');
            $('#red1').val(value).trigger('change');
            if(value != 'artstation'){
                $('.selected-option1').html('<i class="bi bi-' + value + '"></i><i class="bi bi-caret-down-fill">');
            }else{
                $('.selected-option1').html('<i class="pt-1 fa-brands fa-artstation" style="color: white"></i><i class="bi bi-caret-down-fill">');
            }
            $(this).find('.options1').toggle();
        });

        $('.select2-custom2').click(function() {
            $(this).find('.options2').toggle();
        });

        $('.select2-custom2 .options2 li').click(function() {
            var value = $(this).data('value');
            $('#red2').val(value).trigger('change');
            if(value != 'artstation'){
                $('.selected-option2').html('<i class="bi bi-' + value + '"></i><i class="bi bi-caret-down-fill">');

            }else{
                $('.selected-option2').html('<i class="pt-1 fa-brands fa-artstation" style="color: white"></i><i class="bi bi-caret-down-fill">');
            }
            $(this).find('.options2').toggle();
        });

        $('.select2-custom3').click(function() {
            $(this).find('.options3').toggle();
        });

        $('.select2-custom3 .options3 li').click(function() {
            var value = $(this).data('value');
            $('#red3').val(value).trigger('change');
            if(value != 'artstation'){
                $('.selected-option3').html('<i class="bi bi-' + value + '"></i><i class="bi bi-caret-down-fill">');

            }else{
                $('.selected-option3').html('<i class="pt-1 fa-brands fa-artstation" style="color: white"></i><i class="bi bi-caret-down-fill">');
            }
            $(this).find('.options3').toggle();
        });
    });

    $("#regCompanyInterests").mousedown(function(e) {
        selections = $(this).val();

      }).click(function() {

        if (selections == null) {
          var selected = -1;
          selections = [];
        } else
          var selected = selections.indexOf($.isArray($(this).val()) ? $(this).val()[$(this).val().length - 1] : $(this).val());

        if (selected >= 0)
          selections.splice(selected, 1);
        else
          selections.push($(this).val()[0]);

        $('#regCompanyInterests option').each(function() {
          $(this).prop('selected', selections.indexOf($(this).val()) >= 0);
        });
      });

  </script>
@endsection
