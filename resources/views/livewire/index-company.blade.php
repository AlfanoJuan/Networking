


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
            @if (count($students)==0)
                <h5>No hay estudiantes</h5>
            @else
                @foreach ($students as $student)
                    <div class="card col-12 col-md-4 studentsCards">
                        <div class="d-lg-flex" style="height: -webkit-fill-available;">
                            <div class="px-3 d-flex align-items-center" style="background-color: #141424" >
                                <div class="">
                                    <img style="object-fit: cover; height:160px; width:160px; border-radius:50%;" 
                                    @if($student['image'] == null) src="https://api.dicebear.com/5.x/pixel-art/svg?seed={{$student['fullName']}}&backgroundColor=b6e3f4" 
                                    @else src="{{asset("/studentImages/".$student['image'])}}" @endif alt="avatar"/>
                                </div>
                            </div>
                            <div class="col" onclick="window.location.href = '{{route('verEstudiante', $student['id'])}}';" style="cursor:pointer">
                                <div class="card-body">
                                    <h5 class="card-title student-fullname"> {{$student['fullName']}}</h5>
                                    <div class="card-subtitle">
                                    <div class="text-white d-flex justify-content-evenly">
                                        @php
                                            if($student){
                                                $redes = new App\Models\studentNetworks;
                                                $redes = App\Models\studentNetworks::where('student', '=', $student->id)->get();
                                                $numRedes = count($redes);                                     
                                            }                                       
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
                                            <p class="mb-0" style="font-size:.9rem; ">No se han registrado redes sociales</p>
                                        @endif
                                    </div>
                                    </div>
                                    <div class="all-areas mt-1">
                                        @php
                                            $interests = new App\Models\studentInterests;
                                            $interests = App\Models\studentInterests::join('interests', 'interests.id', '=', 'student_interests.interests')
                                                                                    ->where('student', '=', $student['id'])->get();
                                        @endphp
    
                                    @if (count($interests) == 0)
                                        <p style="font-size:.9rem; ">No hay intereses</p>
                                    @endif
                                    @foreach ($interests as $interest )
                                        <button type="button" class="btn btn-primary my-1">{{$interest['name']}}</button>
                                    @endforeach
    
                                    </div>
    
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach 
            @endif

        </div>
        
             <div class="container col-12 col-md-10 mx-auto" style="height: 120px;">
                 <center>
                    <button type="button" wire:click="pagination(`{{$pag-1}}`)" id="btn-pag-ant" class="btn-pagination" style="/*background-color: #000000;border-radius: 8px;width: 5%;float:left;border: 2px solid #FFFFFF;color: #FFFFFF;*/" disabled=true><center><i class="gg-arrow-left" style="filter: drop-shadow(0 0 5px var(--shadow-color));"></i></center></button> 
                    <button type="button" wire:click="pagination(`{{$pag+1}}`)" id="btn-pag-sig" class="btn-pagination" style="/*background-color: #000000;border-radius: 8px;width: 5%;float:left;border: 2px solid #FFFFFF;color: #FFFFFF;*/"><center><i class="gg-arrow-right" style="filter: drop-shadow(0 0 5px var(--shadow-color));"></i></center></button>
                    <div class="numPagination">Página: <p class="PagNum">{{$pag+1}}</p></div>
                </center>
            </div>

    </div>

</div>


