@extends('struct')
@section('Content')

<script src="{{asset('js/format.js')}}"></script>

<script type="text/javascript">
    @if(session()->get('status') == "Imagen cambiada")
    document.addEventListener("DOMContentLoaded", function(){
        Swal.fire({
        position: 'center',
        icon: 'success',
        iconColor: '#0de4fe',
        title: `{{ session()->get('status') }}`,
        showConfirmButton: false,
        timer: 1500
        })

    });
    @endif

    @if(session()->get('status') == "Redes editadas")
    document.addEventListener("DOMContentLoaded", function(){
        Swal.fire({
        position: 'center',
        icon: 'success',
        iconColor: '#0de4fe',
        title: `{{ session()->get('status') }}`,
        showConfirmButton: false,
        timer: 1500
        })

    });
    @endif

    @if(session()->get('status') == "Contraseña cambiada.")
    document.addEventListener("DOMContentLoaded", function(){
        Swal.fire({
        position: 'center',
        icon: 'success',
        iconColor: '#0de4fe',
        title: `{{ session()->get('status') }}`,
        showConfirmButton: false,
        timer: 1500
        })

    });
    @endif

    @if(session()->get('status') == "Contraseña incorrecta.")
    document.addEventListener("DOMContentLoaded", function(){
        Swal.fire({
        position: 'center',
        icon: 'error',
        iconColor: '#a70202',
        title: `{{ session()->get('status') }}`,
        showConfirmButton: false,
        timer: 1500
        })

    });
    @endif

    @if(session()->get('status') == "Campos incompletos.")
    document.addEventListener("DOMContentLoaded", function(){
        Swal.fire({
        position: 'center',
        icon: 'error',
        iconColor: '#a70202',
        title: `{{ session()->get('status') }}`,
        showConfirmButton: false,
        timer: 1500
        })

    });
    @endif

    @if(session()->get('status') == "Las contraseñas no coinciden.")
    document.addEventListener("DOMContentLoaded", function(){
        Swal.fire({
        position: 'center',
        icon: 'error',
        iconColor: '#a70202',
        title: `{{ session()->get('status') }}`,
        showConfirmButton: false,
        timer: 1500
        })

    });
    @endif

    @if(session()->get('status') == "La contraseña no cumple los requisitos.")
        document.addEventListener("DOMContentLoaded", function(){
            Swal.fire({
            position: 'center',
            icon: 'error',
            iconColor: '#a70202',
            title: `{{ session()->get('status') }}`,
            showConfirmButton: false,
            timer: 1500
            })

        });
    @endif

    @if(session()->get('status') == "Hubo un problema en la edición")
    document.addEventListener("DOMContentLoaded", function(){
        Swal.fire({
        position: 'center',
        icon: 'error',
        iconColor: '#a70202',
        title: `{{ session()->get('status') }}`,
        showConfirmButton: false,
        timer: 1500
        })

    });
    @endif


    @php
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
    @endphp


    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#regStudentImg').attr('src', e.target.result).width(200).height(200);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }

</script>

<div class="background container-fluid min-vh-100">
    <div class="netw-inicio">

        <div class="col-12 col-md-9 pt-4 pb-5 mx-auto">

            <livewire:profile-student :student="$student" :idStudent="$student->id" :networks="$studentNetworks" :allExpos="$allExpos"/>

            <div class="row mt-4">
                <livewire:interesting-areas-students :interests="$interests" :idStudent="$student->id" :isSetting="false"/>
            </div>

        </div>
    </div>
</div>

<script>

    function aplicaEstilos() {
        $(".interests").each(function(){
            let hash = "#"
            let c = hash.concat(intToRGB(hashCode($(this)[0].innerText)));
            let gradient = `linear-gradient(to left, ${c}, transparent)`;
            $(this)[0].style.background = gradient;
        });
    }
    
    Livewire.on('applyStylesToInterests', () => {
        aplicaEstilos();
    });
 
    document.addEventListener("livewire:load", function(event) {
        aplicaEstilos();
    });

    document.addEventListener("livewire:update", function(event) {
        aplicaEstilos();
    });

    Livewire.on('editLinkedin', function (filter, index){
        $('#notFormEditLinkedin').hide();
        $("#formEditLinkedin").show();
    });

    Livewire.on('stopEditing', function (filter, index){
        $('#notFormEditLinkedin').show();
        $("#formEditLinkedin").hide();
    });

    Livewire.on('saveEditingSuccess', function (filter, index){
        Swal.fire({
        position: 'center',
        icon: 'success',
        iconColor: '#0de4fe',
        title: `Editado exitoso`,
        showConfirmButton: false,
        timer: 1500
        })
    });

    Livewire.on('saveEditingFail', function (filter, index){
        Swal.fire({
        position: 'center',
        icon: 'error',
        iconColor: '#a70202',
        title: `Editado exitoso`,
        showConfirmButton: false,
        timer: 1500
        })
    });

    function submitFormRedes(){
        document.getElementById("submitFormRedesUpdate").submit();
    }

    function submitFormImg() {
        document.getElementById("editarImagenEstudiante").submit();
    }
    
    function submitFormPassword(){
        document.getElementById("submitFormPasswordUpdate").submit();
    }
    
    $('#fEditImage').click(function(){
        $('#fEditImage').hide();
        $('#originalImg').hide();
        $('#formEdit').show();
        $('#tempImg').show();
    });
    
    $('#editP').click(function(){
        $('#modalChangePassword').hide();
        $("#formEditPassword").show();
    });  

    $('#editL').click(function(){
        $('#notFormEditLinkedin').hide();
        $("#formEditLinkedin").show();
    });
    
    //stopEditing
    $('#stopEditing').click(function(){
        $('#modalChangePassword').show();
        $("#formEditPassword").hide();
    });
    
    $('#buttonEditB').click(function(){
        $('#notFormEditLinkedin').show();
        $("#formEditLinkedin").hide();
    });

    $('#buttonEditC').click(function(){
        $('#fEditImage').show();
        $("#formEdit").hide();
    });

</script>

@endsection
