<div>
    
    <h1 class="text-center"> {{$company->fullName}}</h1>
    
    <hr class="" style="border: 1px solid; border-image: linear-gradient(to left, #0000, #C53AFF, #0000); border-image-slice: 1; border-radius:50%; opacity:100%">
     
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="text-white text-center">
            <div class="p-3 card-profile"> <!-- redes -->
                    Redes sociales: <br>
                
                    <div id="notFormEditLinkedin">
                        <div class="p-2">
                        @if(count($networks) != 0)
                            @foreach($networks as $red)
                                @if($red->red == 'artstation')
                                <a class="px-2" target="_blank" href="" style="text-decoration: none;"> 
                                    <i class="fa-brands fa-artstation" style="font-style:normal;">                                   
                                    </i>
                                    {{$red->link}}
                                </a>
                                @else
                                <a class="px-2" target="_blank" href="" style="text-decoration: none;"> 
                                    <i class="bi bi-{{$red->red}}" style="font-style:normal;">
                                        {{$red->link}}
                                    </i>
                                </a>
                                @endif                                
                            @endforeach
                        
                        @else
                        <i style="font-size:.9rem; ">No se han registrado redes sociales</i>
                        @endif
                        <svg id="editL" xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="white" class="bi bi-pencil-fill" viewBox="0 0 16 16" style="cursor:pointer">
                            <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z"/>
                        </svg>
                        </div>
                        
                    </div>
                    <form id='submitFormRedesUpdate' action="{{route('editarRe', $company->id)}}" method="post">
                        @method('PUT')

                        @csrf
                        <div class="" id="formEditLinkedin" style="display: none">
                            <div class="d-flex flex-sm-row flex-column justify-content-center" style="align-items: center;text-align-last: start;">
                                <div class="col-md-8 col-12 mx-3">
                                    <div class="input-group flex-column">
                                        @php
                                            $numRedes = count($networks);                                       
                                        @endphp
                                        @if($numRedes != 0)
                                            @if($numRedes == 3)
                                                @foreach($networks as $key => $sNetwork)
                                                    <div class="d-flex align-items-center red{{$key + 1}} my-2">
                                                        <select id="red{{$key + 1}}" name="select{{$key + 1}}" style="display: none;">
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
                                                                @endif
                                                                    <i class="bi bi-caret-down-fill"></i>
                                                            </span>
                                                            <ul class="options{{$key + 1}}">
                                                                <li data-value="linkedin"><i class="bi bi-linkedin"></i></li>
                                                                <li data-value="facebook"><i class="bi bi-facebook"></i></li>
                                                                <li data-value="instagram"><i class="bi bi-instagram"></i></li>
                                                                <li data-value="artstation"><i class="fa-brands fa-artstation" style="color: white"></i></li>
                                                            </ul>
                                                        </div>
                                                        <input class="w-100 form-control" autocomplete="off" name="red{{$key + 1}}" type="text" placeholder="{{$sNetwork->link}}" value="{{$sNetwork->link}}" required>
                                                    </div>
                                                @endforeach
                                            @else
                                                @if($numRedes == 2)
                                                @foreach($networks as $key => $sNetwork)
                                                    <div class="d-flex align-items-center red{{$key + 1}} my-2">
                                                        <select id="red{{$key + 1}}" name="select{{$key + 1}}" style="display: none;">
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
                                                                @endif
                                                                    <i class="bi bi-caret-down-fill"></i>
                                                            </span>
                                                            <ul class="options{{$key + 1}}">
                                                                <li data-value="linkedin"><i class="bi bi-linkedin"></i></li>
                                                                <li data-value="facebook"><i class="bi bi-facebook"></i></li>
                                                                <li data-value="instagram"><i class="bi bi-instagram"></i></li>
                                                                <li data-value="artstation"><i class="fa-brands fa-artstation" style="color: white"></i></li>
                                                            </ul>
                                                        </div>
                                                        <input class="w-100 form-control" autocomplete="off" name="red{{$key + 1}}" type="text" placeholder="{{$sNetwork->link}}" value="{{$sNetwork->link}}" required>
                                                    </div>
                                                @endforeach
                                                    <div class="d-flex align-items-center red3 my-2">
                                                        <select id="red3" name="select3" style="display: none;">
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
                                                        <input class="w-100 form-control" autocomplete="off" name="red3" type="text" placeholder="Red3" required>  
                                                    </div>
                                                @else
                                                    @foreach($networks as $key => $sNetwork)
                                                    <div class="d-flex align-items-center red{{$key + 1}} my-2">
                                                        <select id="red{{$key + 1}}" name="select{{$key + 1}}" style="display: none;">
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
                                                                @endif
                                                                    <i class="bi bi-caret-down-fill"></i>
                                                            </span>
                                                            <ul class="options{{$key + 1}}">
                                                                <li data-value="linkedin"><i class="bi bi-linkedin"></i></li>
                                                                <li data-value="facebook"><i class="bi bi-facebook"></i></li>
                                                                <li data-value="instagram"><i class="bi bi-instagram"></i></li>
                                                                <li data-value="artstation"><i class="fa-brands fa-artstation" style="color: white"></i></li>
                                                            </ul>
                                                        </div>
                                                        <input class="w-100 form-control" autocomplete="off" name="red{{$key + 1}}" type="text" placeholder="{{$red->link}}" value="{{$red->link}}" required>
                                                    </div>
                                                    @endforeach
                                                    <div class="d-flex align-items-center red2 my-2">
                                                        <select id="red2" name="select2" style="display: none;">
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
                                                        <input class="w-100 form-control" autocomplete="off" name="red2" type="text" placeholder="Red2" required>  
                                                    </div>
                                                    <div class="d-flex align-items-center red3 my-2">
                                                        <select id="red3" name="select3" style="display: none;">
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
                                                        <input class="w-100 form-control" autocomplete="off" name="red3" type="text" placeholder="Red3" required>  
                                                    </div>                                            
                                                @endif
                                            @endif
                                        @else
                                            <div class="d-flex align-items-center red1 my-2">
                                                <select id="red1" name="select1" style="display: none;">
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
                                                <input class="w-100 form-control" autocomplete="off" name="red1" type="text" placeholder="Red1" required>  
                                            </div>
                                            <div class="d-flex align-items-center red2 my-2">
                                                <select id="red2" name="select2" style="display: none;">
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
                                                <input class="w-100 form-control" autocomplete="off" wire:model.lazy="red2" name="red2" type="text" placeholder="Red2" required>  
                                            </div>
                                            <div class="d-flex align-items-center red3 my-2">
                                                <select id="red3" name="select3" style="display: none;">
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
                                                <input class="w-100 form-control" autocomplete="off" wire:model.lazy="red3" name="red3" type="text" placeholder="Red3" required>  
                                            </div>
                                        @endif

                                    </div>
                                </div>
                                <div class="mx-1 mx-lg-0 my-2" style="text-align-last: center;">
                                    <a onclick="submitFormRedes()" class="btn-table btn btn-primary col-12 m-auto" id="buttonEditA"><i class="bi bi-check-lg"></i></a>
                                </div>
                                <div class="mx-1" style="text-align-last: center;">
                                    <a id="buttonEditB" class="btn-table btn btn-secondary m-auto" ><i class="bi bi-x-lg" style="color: snow"></i></a>
                                </div>
                            </div>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="position-md-absolute p-3 card-profile mt-4 mt-md-0"> <!-- cambiar contra -->
                <div class="px-2 row">
                    Cambiar contraseña:
                
                    <div class="w-25 mb-2" id="modalChangePassword">
                        <div id='containerCP'>
                            <svg id="editP" xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="white" class="bi bi-pencil-fill" viewBox="0 0 16 16" style="cursor:pointer">
                                <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z"/>
                            </svg>
                        </div>
                    </div>
                    <form id='submitFormPasswordUpdate' action="{{route('editarPass', $company->id)}}" method="post">
                        @method('PUT')

                        @csrf
                        <div class="" id="formEditPassword" style="display: none">
                            <div class="mt-2 d-flex flex-column justify-content-center" style="align-items: center;text-align-last: start;">
                                <div class="col-md-11 col-12 mx-2">
                                    <div class="input-group flex-column">
                                        <div class="d-flex">
                                            <button id="togglePass" type="button" class="input-group-text">
                                            <i class="bi bi-eye" id="icon"></i>
                                            </button>
                                            <input autocomplete="off" id="inptActPassword" name="actualPassword" type="password" class="form-control" placeholder="Contraseña actual" required>
                                        </div>
                                        <div class="d-flex mt-4">
                                            <button id="togglePass2" type="button" class="input-group-text">
                                            <i class="bi bi-eye" id="icon2"></i>
                                            </button>
                                            <input autocomplete="off" id="inptNewPassword" name="editPassword" type="password" class="form-control" placeholder="Nueva contraseña" required>                                               
                                        </div>
                                        <div class="validation-messages mt-1 mx-4">
                                            <p id="lengthMessage" class="mb-0 error"><i id="lengthIcon" class="bi bi-x"></i> Mínimo 6 caracteres</p>
                                            <p id="uppercaseMessage" class="mb-0 error"><i id="uppercaseIcon" class="bi bi-x"></i> Al menos una mayúscula</p>
                                            <p id="numberMessage" class="mb-0 error"><i id="numberIcon" class="bi bi-x"></i> Al menos un número</p>
                                            <p id="specialCharMessage" class="mb-0 error"><i id="specialCharIcon" class="bi bi-x"></i> Al menos un carácter especial</p>
                                        </div>                                 
                                        <div class="d-flex mt-3">
                                            <button id="togglePass3" type="button" class="input-group-text">
                                            <i class="bi bi-eye" id="icon3"></i>
                                            </button>
                                            <input autocomplete="off" id="inptConfirmPassword" name="confirmPassword" type="password" class="form-control" placeholder="Confirmar contraseña" required>
                                        </div>
                                        <p id="confirmMessage" class="mt-1 mx-4 mb-0 error">Las contraseñas no coinciden</p>
                                    </div>                                        
                                </div>
                                <div class="d-flex mt-3">
                                    <div class="mx-1 mx-lg-0" style="text-align-last: center;">
                                        <a onclick="submitFormPassword()" class="btn-table btn btn-primary col-12 m-auto" id="buttonEditA"><i class="bi bi-check-lg"></i></a>
                                    </div>
                                    <div class="mx-1" style="text-align-last: center;">
                                        <a id='stopEditing' class="btn-table btn btn-secondary m-auto" id="buttonEditB"><i class="bi bi-x-lg" style="color: snow"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>              
        </div>   
    </div>

</div>

<script>
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

    $(document).ready(function() {
        $('#togglePass').click(function() {   
            var input = $('#inptActPassword');
            var icon = $('#icon');
            if (input.attr('type') === 'password') {
                input.attr('type', 'text');
                icon.removeClass('bi-eye').addClass('bi-eye-slash');
            } else {
                input.attr('type', 'password');
                icon.removeClass('bi-eye-slash').addClass('bi-eye');
            }
        });
        $('#togglePass2').click(function() {   
            var input = $('#inptNewPassword');
            var icon = $('#icon2');
            if (input.attr('type') === 'password') {
                input.attr('type', 'text');
                icon.removeClass('bi-eye').addClass('bi-eye-slash');
            } else {
                input.attr('type', 'password');
                icon.removeClass('bi-eye-slash').addClass('bi-eye');
            }
        });
        $('#togglePass3').click(function() {   
            var input = $('#inptConfirmPassword');
            var icon = $('#icon3');
            if (input.attr('type') === 'password') {
                input.attr('type', 'text');
                icon.removeClass('bi-eye').addClass('bi-eye-slash');
            } else {
                input.attr('type', 'password');
                icon.removeClass('bi-eye-slash').addClass('bi-eye');
            }
        });
    });

    const passwordInput = document.getElementById('inptNewPassword');

    function checkPassword() {
        const password = passwordInput.value;

        const lengthMessage = document.getElementById('lengthMessage');
        var lenghtIcon = $('#lengthIcon')
        if (password.length >= 6) {
            lengthMessage.classList.remove('error');
            lengthMessage.classList.add('valid');
            lenghtIcon.removeClass('bi bi-x').addClass('bi bi-check-lg');
        } else {
            lengthMessage.classList.remove('valid');
            lengthMessage.classList.add('error');
            lenghtIcon.removeClass('bi bi-check-lg').addClass('bi bi-x');
        }

        const uppercaseMessage = document.getElementById('uppercaseMessage');
        var uppercaseIcon = $('#uppercaseIcon')
        if (/[A-Z]/.test(password)) {
            uppercaseMessage.classList.remove('error');
            uppercaseMessage.classList.add('valid');
            uppercaseIcon.removeClass('bi bi-x').addClass('bi bi-check-lg');
        } else {
            uppercaseMessage.classList.remove('valid');
            uppercaseMessage.classList.add('error');
            uppercaseIcon.removeClass('bi bi-check-lg').addClass('bi bi-x');
        }

        const numberMessage = document.getElementById('numberMessage');
        var numberIcon = $('#numberIcon')
        if (/\d/.test(password)) {
            numberMessage.classList.remove('error');
            numberMessage.classList.add('valid');
            numberIcon.removeClass('bi bi-x').addClass('bi bi-check-lg');
        } else {
            numberMessage.classList.remove('valid');
            numberMessage.classList.add('error');
            numberIcon.removeClass('bi bi-check-lg').addClass('bi bi-x');
        }

        const specialCharMessage = document.getElementById('specialCharMessage');
        var specialCharIcon = $('#specialCharIcon')
        if (/[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]+/.test(password)) {
            specialCharMessage.classList.remove('error');
            specialCharMessage.classList.add('valid');
            specialCharIcon.removeClass('bi bi-x').addClass('bi bi-check-lg');
        } else {
            specialCharMessage.classList.remove('valid');
            specialCharMessage.classList.add('error');
            specialCharIcon.removeClass('bi bi-check-lg').addClass('bi bi-x');
        }
    }

    const inpConfirm = document.getElementById('inptConfirmPassword');
    function checkConfirm() {
        const password = passwordInput.value;
        const confirm = inpConfirm.value;

        const confirmMessage = document.getElementById('confirmMessage');
        if(password === confirm && password !== ''){
            confirmMessage.classList.remove('error');
            confirmMessage.classList.add('valid');
            confirmMessage.textContent = 'Las contraseñas coinciden';
        }
        else{
            confirmMessage.classList.remove('valid');
            confirmMessage.classList.add('error');
            confirmMessage.textContent = 'Las contraseñas no coinciden';
        }
    }
        
    passwordInput.addEventListener('input', checkPassword);
    inpConfirm.addEventListener('input', checkConfirm)
</script>
