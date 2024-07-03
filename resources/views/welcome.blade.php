@extends('struct')
@section('Content')

<div class="background container-fluid min-vh-100">
    <div class="netw-inicio min-vh-80" style="">
        <div class="row" >
            <div class="col-md-7 col-12 circle d-flex align-items-center text-center">
            <div class="inner-circle d-flex align-items-center text-center">
                </div>
                <img width=50% class="img img-fluid mx-auto" src="{{asset('imgs/Forma 1.svg')}}" alt="EXPO LMAD 2023">
            </div>

            <div class="col-md-5 col-12 py-lg-0 py-5 px-5" style="align-self: center;">            
                <p style="text-align: center">
                    Una máquina puede hacer el trabajo de cincuenta hombres ordinarios. Ninguna máquina puede hacer el trabajo de un hombre extraordinario.
                    <br>
                    - Elbert Hubbard
                    <br>
                </p>
            </div>

        </div>
        <div class="row" >
            <div class="col-md-5 col-12 py-lg-0 py-5 px-5" style="align-self: center;">

                <p class="pt-2" style="text-align: center">

                    La conectividad es un derecho humano.
                    <br>
                    - Mark Zuckerberg
                    <br>
                </p>

                @php
                $id = session()->get('id');
                $user = new App\Models\User();
                $user = App\Models\User::where('id', '=', $id)->first();
                @endphp
            </div>

            <div class="outer-circle d-flex align-items-center text-center" style="align-self: center;">
                <div class="inner-circle d-flex align-items-center text-center" style="align-self: center;">
                </div>
                <p class="pt-2" style="text-align: center">
                        ¿QUÉ ES NETWORKING?
                        <br>
                        Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.
                        <br>
                    </p>
            </div>

        </div>

    </div>
</div>
@endsection
