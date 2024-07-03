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

    .marginFix{
        margin: 0px !important;
        display: flex;
        justify-content: center !important;

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
                $('#adminEditStudentImg').attr('src', e.target.result).width(300).height(200);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }

</script>

<div class="background-2 container-fluid min-vh-100">

    <div class="sticky-center">
        <form class="row align-items-center pt-3 pb-5" enctype="multipart/form-data" id="adminStudentEdit" action="{{route('adminEstudiante.update', [$student->id])}}" method="post">
            @csrf
            @method('PUT')
            <h1 class="mb-3" style="text-align: center;"> Editando Estudiante </h1>
            <hr style="border: 1px solid; border-image: linear-gradient(to left, #0000, #C53AFF, #0000); border-image-slice: 1; border-radius:50%; opacity:100%">

            <div class="row d-flex justify-content-end p-md-0 px-4 mx-auto">              
                <div class="col-md-2 col-sm-2 d-flex flex-column pt-md-5">

                    <div class="mb-4 d-flex justify-content-center">
                        <img width="200" height="200" onclick="document.getElementById('adminEditBtnStudent').click();" name="adminEditStudentImg" style="object-fit: cover" id="adminEditStudentImg"
                            @if(is_null($student->image)) src="https://api.dicebear.com/5.x/pixel-art/svg?seed={{$student->fullName}}&backgroundColor=b6e3f4"
                            @else src="{{asset('/studentImages/'.$student->image)}}" @endif
                            alt="avatar"
                            required
                        />
                    </div>

                    <div class="d-flex justify-content-center">
                        <div class="btn btn-primary btn-rounded" onclick="document.getElementById('adminEditBtnStudent').click();">
                            <label class="form-label text-white m-1" for="adminEditBtnStudent"><i class="bi bi-image-fill"></i></label>
                            <input accept="image/*" type="file" class="form-control d-none" name="adminEditBtnStudent" id="adminEditBtnStudent" onchange="readURL(this)"/>
                            <input name="originalImage" id="originalImage" type="text" value="{{$student->image}}" hidden>
                        </div>
                    </div>

                </div>
                <div class="col-md-8 col-sm-12 col-12 mt-5 mt-md-0 pt-md-5">

                    <div class="row mb-4">
                        <div class="col-sm-4 d-flex align-items-center justify-content-center justify-content-sm-end">
                            <h5 class="mb-md-0 mb-2">Nombre del estudiante</h5>
                        </div>
                        <div class="col-sm-5 text-secondary"> <input value="{{$student->fullName}}" class="form-control col-11" type="text" name="adminEditStudentName" id="adminEditStudentName"required> </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-sm-4 d-flex align-items-center justify-content-center justify-content-sm-end">
                            <h5 class="mb-md-0 mb-2">Correo</h5>
                        </div>
                        <div class="col-sm-5 text-secondary"> <input value="{{$user->email}}" class="form-control col-11" type="text" name="adminEditStudentEmail" id="adminEditStudentEmail" readonly> </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-sm-4 d-flex align-items-center justify-content-center justify-content-sm-end">
                            <h5 class="mb-md-0 mb-2">Contraseña</h5>
                        </div>
                        <div class="col-sm-5 text-secondary"> 
                            <input placeholder="Deje en blanco si no desea editar la contraseña" class="form-control col-11" type="text" name="adminEditStudentPassword" id="adminEditStudentPassword"> 
                        </div>
                    </div>

                    @php
                        $numRedes = count($studentNetworks);
                    @endphp

                    @if($numRedes == 0)
                        <div class="row mb-4">
                            <div class="col-sm-4" style="align-self: center; text-align: -webkit-right;">
                                <h5 class="mb-0"  style="align-self: center;">Redes Sociales</h5>
                            </div>
                            <div class="col-sm-6 d-flex align-items-center"> 
                                <select id="red1" name="red1" style="display: none;">
                                    <option value="linkedin" selected>Linkedin</option>
                                    <option value="facebook">Facebook</option>
                                    <option value="instagram">Instagram</option> 
                                    <option value="artstation">Artstation</option>   
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
                                <input class="form-control" type="text" name="adminEditStudentRed1" id="adminEditStudentRed1">
                                <button id="newRed" type="button" class="btn" style="margin-right: 30px"><i class="bi bi-plus-circle"></i></button>
                            </div>
                        </div>
                    @endif

                    @foreach ($studentNetworks as $key => $sNetwork)
                    <div class="row mb-4">
                        <div class="col-sm-4 d-flex align-items-center justify-content-center justify-content-sm-end">
                            @if($key == 0)
                                <h5 class="mb-md-0 mb-2"  style="align-self: top;">Redes Sociales</h5>
                            @endif
                        </div>
                        <div class="col-sm-5 d-flex align-items-center red{{$key + 1}}"> 
                            <select id="red{{$key + 1}}" name="red{{$key + 1}}" style="display: none;">
                                <option value="linkedin" @if($sNetwork->red == "linkedin") selected @endif>Linkedin</option>
                                <option value="facebook" @if($sNetwork->red == "facebook") selected @endif>Facebook</option>
                                <option value="instagram" @if($sNetwork->red == "instagram") selected @endif>Instagram</option> 
                                <option value="artstation" @if($sNetwork->red == "artstation") selected @endif>Artstation</option>   
                            </select>

                            <div class="select2-custom{{$key + 1}}">
                                <span class="d-flex justify-content-between selected-option{{$key + 1}}">
                                    @if($sNetwork->red == "artstation")
                                        <i class="pt-1 fa-brands fa-artstation" style="color: white"></i>
                                    @else
                                        <i class="bi bi-{{$sNetwork->red}}"></i>
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
                            <input class="form-control" type="text" name="adminEditStudentRed{{$key + 1}}" id="adminEditStudentRed{{$key + 1}}" value="{{$sNetwork->link}}">
                        </div>
                    </div>
                    @endforeach            

                    <div class="row mb-4 addRed" style="display: none;">
                        <div class="col-sm-4" style="align-self: top; text-align: -webkit-center;">
                        </div>
                        <div class="col-sm-6 d-flex align-items-center"> 
                            <select id="red2" name="red4" style="display: none;">
                                <option value="linkedin">Linkedin</option>
                                <option value="facebook" selected>Facebook</option>
                                <option value="instagram">Instagram</option> 
                                <option value="artstation">Artstation</option>   
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
                            <input class="form-control" type="text" name="adminEditStudentRed4" id="adminEditStudentRed4">
                            <button id="newRed2" type="button" class="btn" style="margin-right: 32px"><i class="bi bi-plus-circle"></i></button>
                        </div>
                    </div>

                    <div class="row mb-4 addRed2" style="display: none;">
                        <div class="col-sm-4" style="align-self: top; text-align: -webkit-center;">
                        </div>
                        <div class="col-sm-5 d-flex align-items-center"> <!-- Contenedor flex para alinear elementos verticalmente -->
                            <select id="red3" name="red5" style="display: none;">
                                <option value="linkedin">Linkedin</option>
                                <option value="facebook" selected>Facebook</option>
                                <option value="instagram">Instagram</option> 
                                <option value="artstation">Artstation</option>   
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
                            <input class="form-control" type="text" name="adminEditStudentRed5" id="adminEditStudentRed5">
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-sm-4 d-flex justify-content-center justify-content-sm-end">
                            <h5 class="mt-1"  style="align-self: top;">Intereses</h5>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-floating">
                                <select class="form-select" id="adminEditStudentInterests" name="adminEditStudentInterests[]" multiple="multiple" size="5" style="overflow-y: auto; height:100%">
                                    @foreach ($allInterests as $interest)
                                        <option value="{{$interest->id}}"
                                            @foreach($studentInterests as $sInterest)
                                                @if($interest->id == $sInterest->id) selected @endif
                                            @endforeach >{{$interest->name}}
                                        </option>
                                    @endforeach
                                </select>
                                <span style="color:snow; opacity: 50%">Seleccione uno o más intereses</span>
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-sm-4 d-flex justify-content-center justify-content-sm-end">
                            <h5 class="mt-1 mb-md-0 mb-2"  style="align-self: top;">EXPOS asistidas</h5>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-floating">
                                <select class="form-select" id="regStudentExpos" name="regStudentExpos[]" multiple="multiple" size="5" style="overflow-y: auto; height:100%" required>
                                @foreach ($allExpos as $expo)
                                    <option value="{{$expo->id}}"
                                        @foreach($studentExpos as $sExpo)
                                            @if($expo->id == $sExpo->id) selected @endif
                                        @endforeach
                                        >{{$expo->year}}</option>
                                @endforeach
                                </select>
                            </div>
                            <span style="color:snow; opacity: 50%">Seleccione una o más exposiciones</span>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-12 pt-5" style="text-align:center;">
                <button id="adminEditStudent" type="submit" class="px-5 d-inline w-auto col-md-4 col-sm-12 btn btn-primary">CONFIRMAR</button>
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

    $("#regStudentExpos").mousedown(function(e) {
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

        $('#regStudentExpos option').each(function() {
          $(this).prop('selected', selections.indexOf($(this).val()) >= 0);
        });
    });

    $("#adminEditStudentInterests").mousedown(function(e) {
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

        $('#adminEditStudentInterests option').each(function() {
            $(this).prop('selected', selections.indexOf($(this).val()) >= 0);
        });
    });

  </script>

@endsection
