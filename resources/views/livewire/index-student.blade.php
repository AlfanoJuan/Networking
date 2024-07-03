<div class="background-2 container-fluid min-vh-100">

    <div class="container col-md-6 col-sm-12 pt-4 d-flex justify-content-center">

        <input type="text" class="form-control" name="search" id="search-input" placeholder="Búsqueda" required autocomplete="false"  wire:model="searchTxt" wire:keyup="search">

        <button style="margin-left: -42px;" type="button" class="btn" data-mdb-ripple-init>
            <i style="color: snow" class="fas fa-search"></i>
        </button>

    </div>

    <div class="row mt-4">
        <div class="container col-12 mx-auto">

            <div class="all-areas col-md-6 mx-auto">
                @foreach ($allInterests as $singleInterest)
                <button type="button" wire:click="addFilter(`{{$singleInterest->name}}`,{{$loop->index}})" onclick='document.getElementById("search-input").innerHTML="<input readonly />"' id="{{$loop->index}}" class="btn btn-primary" >{{$singleInterest->name}}</button>
                @endforeach
            </div>

            <hr class="" style="border: 1px solid; border-image: linear-gradient(to left, #fff0, #4A69E6, #fff0); border-image-slice: 1; border-radius:50%; opacity:100%">

            <div class="selected-area col-md-8 mx-auto" id="selected-area">


            </div>
        </div>
 
        

        <div class="d-flex flex-wrap justify-content-center">
            @if (count($companies)==0)
                <h5>No hay empresas</h5>
                @else
                    @foreach ($companies as $company)
                        <div class="card col-12 col-md-4 studentsCards">
                            <div class="d-lg-flex">
                                <div class="col" onclick="window.location.href = '{{route('verEmpresa', $company['id'])}}';" style="cursor:pointer">
                                    <div class="card-body text-white">
                                        <h5 class="mb-3 card-title text-center student-fullname"> {{$company['fullName']}}</h5>
                                        <div class="card-subtitle">
                                            
                                            <div class="text-white d-flex justify-content-evenly">
                                                @php
                                                    $redes = new App\Models\companyNetworks;
                                                    $redes = App\Models\companyNetworks::where('company', '=', $company->id)->get();
                                                    $numRedes = count($redes);
                                                @endphp
                                                @if($numRedes != 0)
                                                    @foreach ($redes as $red)
                                                        @if($red->red == 'artstation')
                                                            <div class="my-2">
                                                                <a target="_blank" href="{{$red->link}}" style="text-decoration: none;">
                                                                    <i class="pt-1 fa-brands fa-artstation"></i>
                                                                    {{$red->link}}
                                                                </a>
                                                            </div>
                                                        @else                       
                                                            <div class="my-2">
                                                                <a target="_blank" href="{{$red->link}}" style="text-decoration: none;">
                                                                    <i class="bi bi-{{$red->red}}" style="font-style:normal;"></i>
                                                                    {{$red->link}}
                                                                </a>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                @else
                                                    <p class="my-2" style="font-size:.9rem; ">No se han registrado redes sociales</p>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="mt-2">
                                                                                    
                                            <div class="all-areas d-flex justify-content-evenly mt-1">
                                                @php
                                                    $interests = new App\Models\companyInterests;
                                                    $interests = App\Models\companyInterests::join('interests', 'interests.id', '=', 'company_interests.interests')
                                                                                            ->where('company', '=', $company['id'])->get();
                                                @endphp
                                                @if (count($interests) == 0)
                                                    <p class="my-1" style="font-size:.9rem; ">No hay intereses</h5>
                                                @endif
                                                @foreach ($interests as $interest )
                                                    <button type="button" class="btn btn-primary my-1">{{$interest->name}}</button>
                                                @endforeach
            
                                            </div>
                                        </div>
     
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
            @endif

        </div>
        
        <div class="row mt-5">
            <center>
                <button type="button" wire:click="pagination(`{{$pag-1}}`)" id="btn-pag-ant" class="btn-pagination" style="/*background-color: #000000;border-radius: 8px;width: 5%;float:left;border: 2px solid #FFFFFF;color: #FFFFFF;*/" disabled=true><center><i class="gg-arrow-left" style="filter: drop-shadow(0 0 5px var(--shadow-color));"></i></center></button> 
                <button type="button" wire:click="pagination(`{{$pag+1}}`)" id="btn-pag-sig" class="btn-pagination" style="/*background-color: #000000;border-radius: 8px;width: 5%;float:left;border: 2px solid #FFFFFF;color: #FFFFFF;*/"><center><i class="gg-arrow-right" style="filter: drop-shadow(0 0 5px var(--shadow-color));"></i></center></button>
                <div class="numPagination">Página: <p class="PagNum">{{$pag+1}}</p></div>
            </center>
        </div>

    </div>



</div>
