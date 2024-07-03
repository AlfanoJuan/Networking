@extends('struct')
@section('Content')

<script src="{{asset('js/format.js')}}"></script>

<div class="background container-fluid min-vh-100">
    <div class="netw-inicio" style="">
        <div class="col-12 col-md-9 mx-auto">

            <div class="col-12 text-center">
                <img class="mt-4 mb-2" style="object-fit: cover; height:200px; width:200px; border-radius:50%;" @if(is_null($sdt->image)) src="https://api.dicebear.com/5.x/pixel-art/svg?seed={{$sdt->fullName}}&backgroundColor=b6e3f4" @else src="{{asset("/studentImages/".$sdt->image)}}" @endif alt="avatar"/>
            </div>

            <h1 class="my-3 text-center">
                {{$sdt->fullName}}
            </h1>

            <hr class="" style="border: 1px solid; border-image: linear-gradient(to left, #0000, #C53AFF, #0000); border-image-slice: 1; border-radius:50%; opacity:100%">

            <div class="row">
                <div class="col-md-6">
                    <div class="p-3 card-profile">
                        <div class="text-white p-2">Redes sociales: <br>

                            <div class="mt-2" id="notFormEditLinkedin">
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
                            </div>

                        </div>
                    </div>
 

                </div>
                <div class="col-md-6">
                    <div class="p-3 mt-4 mt-lg-0 card-profile">
                        <div class="text-white p-2">Exposiciones: <br>
                            <div class="mt-2 d-flex justify-content-center">
                                @foreach ($allExpos as $ex)
                                <div class="w-25 col-md-2 mx-auto">
                                    <div style="background: linear-gradient(to left, rgba(196, 0, 0, .38), #ff3a3ad1); border-radius: 15px" class="text-center py-1">
                                        <a href="https://expolmad.sistemaregistrofcfm.com/Portfolio/student/{{$sdt->fullName}}" target="_blank" class="LinkEXPO" ><b style="color: white">{{$ex->year}}</b></a>
                                    </div>
                                </div>
                            @endforeach
                            </div>                      
                        </div>
                    </div>
                    
                </div>

            </div>

            <div class="col-md-6 pb-5 mx-auto">
                <div class="mt-5 p-3 card-profile">
    
                    Áreas de interés:

                    <div class="d-flex flex-wrap justify-content-center mt-2">

                        @foreach ( $interests as $interest)
                            <div class="col-md-4">
                                <div class="interests px-1 my-2 mx-1 py-1" style="border-radius: 15px; display: flex; justify-content: center;">
                                    
                                    <p class="card-title text-center"> {{$interest->name}}</p>

                                </div>
                                
                            </div>
                        @endforeach
                        </div>
                    </div>       

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
 
    aplicaEstilos();

</script>
@endsection
