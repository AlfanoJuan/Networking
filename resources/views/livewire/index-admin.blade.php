<div class="background-2 container-fluid min-vh-100">

    <div class="">
        <div class="container-fluid">
            <div class="row navbar sticky-top" style="top: 70px; background-color: #121b2b">
                <ul class="nav justify-content-center gap-4" id="tabAdminIndex" role="admin-index">
                    <li class="nav-item" role="admin-index" style="width: 20%;">
                        <button wire:click="mostrarEstudiantes()" onclick="window.scrollTo(0, 0);" style="color:#fff; background: linear-gradient(to right, rgba(0, 175, 196, 0), #00AFC4);" class=" btn-secondary p-2 w-100" id="all-students-tab" data-bs-toggle="tab" type="button" role="tab">Estudiantes</button>
                    </li>
                    <li class="nav-item" role="admin-index" style="width: 20%;">
                        <button wire:click="mostrarEmpresas()" onclick="window.scrollTo(0, 0);" style="color:#fff; background: linear-gradient(to left, rgba(0, 175, 196, 0), #C53AFF);" class="btn-secondary active p-2 w-100" id="admin-index-companies" data-bs-toggle="tab" type="button" role="tab">Empresas</button>
                    </li>
                </ul>
            </div>
            <div class="row" >
                <div style="padding-top: 20px; width: 50%; margin: auto;" class="input-group rounded">
                    <input class="form-control rounded" placeholder="Buscar..." aria-label="Buscar" aria-describedby="buscar-addon" name="search" id="search-input" wire:model="searchTxt" wire:keyup="search" />
                    <button style="margin-left: -42px;" type="button" class="btn" data-mdb-ripple-init>
                        <i style="color: snow" class="fas fa-search"></i>
                    </button>
                </div>
                <div class="tab-content">
                @if ($tablaMostrada == 'Empresa')
                    <div class="tab-pane show active" id="all-companies" role="tabpanel" aria-labelledby="admin-index-companies">

                        <div class="table-responsive">
                            <table class="table" style="text-align-last:center;">
                                <thead>
                                    <tr>
                                        <th>Empresa</th>
                                        <th>Redes Sociales</th>
                                        <th>Correo</th>
                                        <th>Contraseña</th>
                                        <th>Intereses</th>
                                        <th>Editar</th>
                                        <th>Borrar</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($companies as $cmpy)
                                        <tr>
                                            <td> {{$cmpy->fullName}} </td>
                                            <td>
                                                @php
                                                    $redes = new App\Models\companyNetworks;
                                                    $redes = App\Models\companyNetworks::where('company', '=', $cmpy->id)->get();
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
                                                    <p class="mb-0" style="font-size:.9rem; ">No se han registrado redes sociales</p>
                                                @endif
                                            </td>
                                            <td>
                                                @php
                                                    $user = new App\Models\User;
                                                    $user = App\Models\User::join('companies', 'companies.user', '=', 'users.id')
                                                                                            ->where('companies.user', '=', $cmpy->user)->first();
                                                @endphp
                                                <p class="mb-0">{{$user->email}}</p>
                                            </td>
                                            <td>
                                            @if ($user->salt == null)
                                                    <p class="mb-0">{{$user->password}}</p>
                                                @else
                                                    <p class="mb-0">#Encriptada#</p>
                                                @endif
                                            </td>
                                            <td>
                                                @php
                                                $interests = new App\Models\companyInterests;
                                                $interests = App\Models\companyInterests::join('interests', 'interests.id', '=', 'company_interests.interests')
                                                                                        ->where('company', '=', $cmpy->id)->get();
                                                    @endphp
                                                @if (count($interests) == 0)
                                                    <p class="mb-0" style="font-size:.9rem; ">No hay intereses</p>
                                                @endif
                                                @foreach ($interests as $interest )
                                                    <p class="mb-0">{{$interest->name}}</p>
                                                @endforeach
                                            </td>
                                            <td>
                                                <a href="{{route('adminEmpresa.edit', [$cmpy->id])}}" class="btn-table btn btn-primary col-12 m-auto"><i class="bi bi-pencil"></i></a>
                                            </td>
                                            <td>
                                                <form action="{{route('adminEmpresa.destroy', [$cmpy->id])}}" method="POST" hidden>
                                                    @method('DELETE')
                                                    @csrf
                                                        <button id="delete_{{$cmpy->id}}" type="submit"> DESTROY </button>
                                                </form>
                                                <a onclick="confirmDialog(`delete_{{$cmpy->id}}`)" class="btn-table btn btn-primary col-12 m-auto"><i class="bi bi-trash"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach

                                    <tr>
                                        <td colspan="12"> <a href="{{route('adminEmpresa.create')}}" > <i class="bi bi-plus-circle"> Agregar Empresa </i></a></td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>

                    </div>
                    @else
                    <div class="tab-pane show active" id="all-students" aria-labelledby="all-students-tab">

                        <div class="table-responsive">
                            <table class="table" style="text-align-last:center;">
                                <thead>
                                    <tr>
                                        <th>Imagen</th>
                                        <th>Estudiante</th>
                                        <th>Redes Sociales</th>
                                        <th>Correo</th>
                                        <th>Contraseña</th>
                                        <th>Intereses</th>
                                        <th>EXPOS</th>
                                        <th>Editar</th>
                                        <th>Borrar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($students as $student)

                                        <tr>
                                            <td> <img style="object-fit: cover"
                                                @if(is_null($student->image))
                                                src="https://api.dicebear.com/5.x/pixel-art/svg?seed={{$student->fullName}}&backgroundColor=b6e3f4"
                                                @else src="{{asset("/studentImages/".$student->image)}}"
                                                @endif alt="avatar"/> </td>
                                            <td> {{$student->fullName}} </td>
                                            <td>
                                                @php
                                                    $redes = new App\Models\studentNetworks;
                                                    $redes = App\Models\studentNetworks::where('student', '=', $student->id)->get();
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
                                                    <p class="mb-0" style="font-size:.9rem; ">No se han registrado redes sociales</p>
                                                @endif
                                            <td>
                                                @php
                                                    $user = new App\Models\User;
                                                    $user = App\Models\User::join('students', 'students.user', '=', 'users.id')
                                                                                            ->where('students.user', '=', $student->user)->first();
                                                @endphp
                                                <p class="mb-0">{{$user->email}}</p>
                                            </td>
                                            <td>
                                                @if ($user->salt == null)
                                                    <p class="mb-0">{{$user->password}}</p>
                                                @else
                                                    <p class="mb-0">#Encriptada#</p>
                                                @endif
                                                
                                            </td>
                                            <td>
                                                @php
                                                    $interests = new App\Models\studentInterests;
                                                    $interests = App\Models\studentInterests::join('interests', 'interests.id', '=', 'student_interests.interests')
                                                                                            ->where('student', '=', $student->id)->get();
                                                @endphp
                                                @if (count($interests) == 0)
                                                    <p class="mb-0" style="font-size:.9rem; ">No hay intereses</p>
                                                @endif
                                                @foreach ($interests as $interest )
                                                    <p class="mb-0">{{$interest->name}}</p>
                                                @endforeach
                                            </td>
                                            <td>
                                                @php
                                                    $expos = new App\Models\studentExpo;
                                                    $expos = App\Models\studentExpo::join('expos', 'expos.id', '=', 'student_expos.expo')
                                                                                            ->where('student', '=', $student->id)->get();
                                                @endphp
                                                @if (count($expos) == 0)
                                                    <h5 style="font-size:.9rem; ">NINGUNA (Esto no debería verse)</h5>
                                                @endif
                                                @foreach ($expos as $expo )
                                                    <p class="mb-0">{{$expo->year}}</p>
                                                @endforeach
                                            </td>
                                            <td>
                                                <a href="{{route('adminEstudiante.edit', [$student->id])}}" class="btn-table btn btn-primary col-12 m-auto"><i class="bi bi-pencil"></i></a>
                                            </td>
                                            <td>
                                                <form action="{{route('adminEstudiante.destroy', [$student->id])}}" method="POST" hidden>
                                                    @method('DELETE')
                                                    @csrf
                                                        <button id="delete_{{$student->id}}" type="submit"> DESTROY </button>
                                                </form>
                                                <a onclick="confirmDialog(`delete_{{$student->id}}`)" class="btn-table btn btn-primary col-12 m-auto"><i class="bi bi-trash"></i></a>
                                            </td>
                                        </tr>

                                    @endforeach
                                    <tr>
                                        <td colspan="12"> <a href="{{route('adminEstudiante.create')}}" > <i class="bi bi-plus-circle"> Agregar Estudiante </i></a></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                @endif
                    {{--  <div class="tab-pane show" id="all-graduates" aria-labelledby="all-students-tab">

                        <div class="table-responsive">
                            <table class="table" style="text-align-last:center;">
                                <thead>
                                    <tr>
                                        <th>Imagen</th>
                                        <th>Egresado</th>
                                        <th>LinkedIn</th>
                                        <th>Intereses</th>
                                        <th>Editar</th>
                                        <th>Borrar</th>
                                        <th>Info</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <!-- img ... svg?seed=" Nombre del Egresado "-->
                                        <td> <img src="https://api.dicebear.com/5.x/pixel-art/svg?seed=lmad&backgroundColor=b6e3f4" alt="avatar"/> </td>
                                        <td> Egresado </td>
                                        <td> <a href="" style="text-decoration: none;"> <i class="bi bi-linkedin" style="font-style:normal;"> Egresado </i></a> </td>
                                        <td> <a href="" style="text-decoration: none;"> <i class="bi bi-search" style="font-style:normal;"> Intereses </i></a> </td>
                                        <td>
                                            <a href="#" class="btn-table btn btn-primary col-12 m-auto"><i class="bi bi-pencil"></i></a>
                                        </td>
                                        <td>
                                            <a href="#" class="btn-table btn btn-primary col-12 m-auto"><i class="bi bi-trash"></i></a>
                                        </td>
                                        <td>
                                            <a href="#" class="btn-table btn btn-primary col-12 m-auto"><i class="bi bi-eye"></i></a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="12"> <a href="" > <i class="bi bi-plus-circle"> Agregar Egresado </i></a></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>  --}}

                </div>
            </div>
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
