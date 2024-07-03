@extends('struct')
@section('Content')

<script type="text/javascript">
    @if(session()->get('status') == "EXPO registrada")
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
    @if(session()->get('status') == "Hubo un problema en el registro")
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
    @endif
    @if(session()->get('status') == "EXPO eliminada")
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
    @if(session()->get('status') == "Hubo un problema en la eliminación")
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
    @endif
    @if(session()->get('status') == "La EXPO pertenece a alguien y no puede ser eliminada")
    document.addEventListener("DOMContentLoaded", function(){
        Swal.fire({
        position: 'center',
        icon: 'info',
        title: `{{ session()->get('status') }}`,
        showConfirmButton: false,
        timer: 1500
        })

    });
    @endif
</script>

<div class="background container-fluid min-vh-100">
    <div class="col-12 col-md-9 mx-auto">
        <div class="row pt-4">
            <h1 class="text-center"> Exposiciones </h1>
        </div>
        <form id="form" method="POST" enctype="multipart/form-data" action="{{route('adminExpo.store')}}">
            @csrf
            <div class="w-75 mx-auto mb-3 pt-2 d-flex">
                <input name="regExpo" id="regExpo" type="text" class="form-control" placeholder="Año de la nueva expo" required/>
                <button style="margin-left: -42px;" type="button" class="btn" data-mdb-ripple-init>
                    <i style="font-size: large; color: snow" class="bi bi-plus-lg"></i>
                </button>
            </div>
        </form>

            <table class="table w-75 mx-auto" id="table">
                <thead>
                    <tr>
                        <th>Expos</th>
                        <th>Borrar</th>
                    </tr>
                </thead>
                <tbody id="tbody">
                @foreach ($allExpos as $ex)
                <form id="delete" method="post" enctype="multipart/form-data" action="{{route('adminExpo.destroy', [$ex->id])}}">
                @method('DELETE')
                @csrf
                <tr>
                      <td>{{$ex->year}}</td>
                      <td><button type="submit" class="btn btn-primary"><i class="bi bi-trash"></button></td>
                  </tr>
                </form>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
