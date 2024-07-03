<div class="col-md-6">
    <div class="p-3 card-profile">
 
        Mis areas de interés:

        <div class="d-flex flex-wrap justify-content-center mt-2">

            @foreach ( $interests as $interest)
                <div class="col-12 col-md-4">
                    <div class="interests px-1 my-2 mx-1 py-1" style="border-radius: 15px; display: flex; justify-content: center;">
                        
                        <p class="card-title text-center"> {{$interest->name}}</p>                       

                    </div>
                    
                </div>
            @endforeach
        </div>
        <hr class="mt-4 mb-4">
        Agregar áreas de interés:
        <div class="d-flex flex-wrap justify-content-center mt-2 mb-3">
        
            @php
                $allInterests = App\Models\Interests::all();
            @endphp
            @foreach ( $allInterests as $interest)
                <div class="col-12 col-md-4">
                    <div class="interests px-1 my-2 mx-1 py-1" style="border-radius: 15px; display: flex; justify-content: center;">
                        
                        <p class="card-title text-center"> {{$interest->name}}</p>
                        
                        <div class="text-center">

                            @php
                                $original = App\Models\studentInterests::join('interests', 'interests.id', '=', 'student_interests.interests')->where('student', '=', $idStudent)->get();
                            @endphp

                            @foreach ($original as $item)
                                @if ($interest->id == $item->id)
                                <div wire:click="deleteRegister({{ $item->id }})">
                                    <button style="color:white; cursor: pointer; text-decoration:underline;background-color:transparent; border:unset; "><i class="bi bi-x-circle"></i></button>
                                </div>
                                @endif
                            @endforeach

                            @php

                                $originalTemp= array(); $interestsTemp = array();

                                foreach ($original as $item){
                                    array_push($originalTemp, $item->id);
                                }

                                foreach ($allInterests as $item){
                                    array_push($interestsTemp, $item->id);
                                }

                                $list = array_diff($interestsTemp, $originalTemp);
                            @endphp

                            @foreach ($list as $item)
                                @if ($interest->id == $item)
                                <div wire:click="updateRegister({{ $item }})">
                                    <button style="color:white; cursor: pointer; text-decoration:underline;background-color:transparent; border:unset;" ><i class="bi bi-plus-circle"></i></button>
                                </div>
                                @endif
                            @endforeach

                        </div>

                    </div>
                    
                </div>
            @endforeach
        </div>
    </div>       
</div>