@extends('struct')
@section('Content')

<style>
    /* Define un estilo CSS personalizado para aplicar position absolute en pantallas medianas */
    @media (min-width: 768px) {
        .position-md-absolute {
            position: absolute;
            width: 36%; /* Puedes ajustar el ancho según tus necesidades */
        }
    }
</style>

<script src="{{asset('js/format.js')}}"></script>

<script>
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
</script>

<div class="background container-fluid min-vh-100">
    <div class="netw-inicio">

        <div class="col-12 col-md-9 pt-4 pb-5 mx-auto">

            <livewire:profile-company :company="$company" :idCompany="$company->id" :networks="$networks"/>

            <div class="row mt-4 mt-md-4">
                <livewire:interesting-areas :interests="$interests" :idCompany="$company->id" :isSetting="false"/>
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
    
    function submitFormRedes(){
        document.getElementById("submitFormRedesUpdate").submit();
    }

    function submitFormPassword(){
        document.getElementById("submitFormPasswordUpdate").submit();
    }
 
    document.addEventListener("livewire:load", function(event) {
        aplicaEstilos();
    });

    document.addEventListener("livewire:update", function(event) {
        aplicaEstilos();
    });

    $('#editP').click(function(){
        $('#modalChangePassword').hide();
        $("#formEditPassword").show();
    });  

    $('#stopEditing').click(function(){
        $('#modalChangePassword').show();
        $("#formEditPassword").hide();
    });

    $('#editL').click(function(){
        $('#notFormEditLinkedin').hide();
        $("#formEditLinkedin").show();
    });

    $('#buttonEditB').click(function(){
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


</script>

@endsection
