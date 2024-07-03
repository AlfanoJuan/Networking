<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\company;
use App\Models\interests;
use App\Models\expo;
use App\Models\student;
use App\Models\studentExpo;
use App\Models\studentInterests;
use App\Models\studentNetworks;
use Illuminate\Support\Facades\Storage;
use App\Http\Livewire;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companies = new company();
        $companies = company::all();

        $allInterests = interests::all();

        $allExpos = expo::all();

        return view('students.index', compact('companies', 'allInterests', 'allExpos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $allInterests = interests::all();
        $allExpos = expo::all();
        return view('admin.register.student', compact('allInterests','allExpos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->regStudentName == null ||
           $request->regStudentExpos == null || 
           $request->regStudentMail == null)
        {
            session()->flash("status","Hubo un problema en el registro");
            return redirect()->route('admin.index');
        }
        
        if($request->regBtnStudentImg != null)
        {
            // Obtener la extensión del archivo
            $image = $request->file('regBtnStudentImg');
            $extension = $image->getClientOriginalExtension(); 
            // Definir las extensiones permitidas
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
            // Verificar si la extensión está en la lista permitida
            if (in_array(strtolower($extension), $allowedExtensions)) {
                // La extensión es válida, y continua en el código para procesar el archivo
            } else {
                 session()->flash("status","Hubo un problema en el registro");
                return redirect()->route('admin.index');
            }
        }
        
        $email = Str::lower(str_replace(" ", "",$request->regStudentMail));

        $userStudent = new User();
        $userStudent->email = $email;

        $salt = Str::random(10);
        $password = 'student123';

        $userStudent->password = bcrypt($salt . $password);
        $userStudent->salt = $salt;

        $userStudent->rol = 'student';

        $userStudentValidate = User::where('email', $email)->first();

        if($userStudentValidate)
        {
            session()->flash("status","Correo ya existente");
            return redirect()->route('admin.index');
        }

        if($userStudent->save()){
            $student = new student();

            $student->fullName = $request->regStudentName;
            $student->user = $userStudent->id;

            if($request->regBtnStudentImg != null) {
                $fileName = time().'_'.uniqid();
                //Guardar archivo
                Storage::disk('public')->put($fileName, file_get_contents($request->file('regBtnStudentImg')));
                $image = $request->file('regBtnStudentImg');
                $image->move(public_path('studentImages'), $fileName);
            } else {
                $fileName = null;
            }

            $student->image = $fileName;

            if($student->save()){

                if($request->regStudentRed1 != null){
                    $studentNetw = new studentNetworks();
                    $studentNetw->red = $request->red1;
                    $studentNetw->link = $request->regStudentRed1;
                    $studentNetw->student = $student->id;

                    if($studentNetw->save()) {
                        session()->flash("status","Estudiante registrado");
                    }
                    else {
                        session()->flash("status","Hubo un problema en el registro");
                    }
                }

                if($request->regStudentRed2 != null){
                    $studentNetw2 = new studentNetworks();
                    $studentNetw2->red = $request->red2;
                    $studentNetw2->link = $request->regStudentRed2;
                    $studentNetw2->student = $student->id;

                    if($studentNetw2->save()) {
                        session()->flash("status","Estudiante registrado");
                    }
                    else {
                        session()->flash("status","Hubo un problema en el registro");
                    }
                }

                if($request->regStudentRed3 != null){
                    $studentNetw3 = new studentNetworks();
                    $studentNetw3->red = $request->red3;
                    $studentNetw3->link = $request->regStudentRed3;
                    $studentNetw3->student = $student->id;

                    if($studentNetw3->save()) {
                        session()->flash("status","Estudiante registrado");
                    }
                    else {
                        session()->flash("status","Hubo un problema en el registro");
                    }
                }

                if($request->regStudentInterests != null) {
                    foreach($request->regStudentInterests as $regStudentInterest){
                        $studentInt = new studentInterests();
                        $studentInt->interests = $regStudentInterest;
                        $studentInt->student = $student->id;

                        if($studentInt->save()) {
                            session()->flash("status","Estudiante registrado");
                        }
                        else {
                            session()->flash("status","Hubo un problema en el registro");
                        }
                    }
                } else {
                    session()->flash("status","Estudiante registrado");
                }

                foreach($request->regStudentExpos as $regStudentExpo){
                    $studentExpo = new studentExpo();
                    $studentExpo->expo = $regStudentExpo;
                    $studentExpo->student = $student->id;

                    if($studentExpo->save()) {
                        session()->flash("status","Estudiante registrado");
                    }
                    else {
                        session()->flash("status","Hubo un problema en el registro");
                    }
                }

            } else {
                session()->flash("status","Hubo un problema en el registro");
            }
        } else {
            session()->flash("status","Hubo un problema en el registro");
        }

        return redirect()->route('admin.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //Validación si es el mismo usuario
        if(session()->get('id') == $id)
        {
            //Mostrar un estudiante
            $student = new student();
            $student = student::where('user', '=', $id)->first();

            //Redes del Estudiante
            $studentNetworks = new studentNetworks();
            $studentNetworks = studentNetworks::where('student', '=', $student->id)->get();
    
            //Mostrar intereses
            $interests = new studentInterests();
            $interests = studentInterests::join('interests', 'interests.id', '=', 'student_interests.interests')->where('student', '=', $student->id)->get();
    
            //Mostrar expos
            $allExpos = studentExpo::join('expos', 'expos.id', '=', 'student_expos.expo')->where('student', '=', $student->id)->get();
    
            return view('students.profile', compact('student', 'interests', 'allExpos', 'studentNetworks'));
        }
        else
        {
            return redirect()->route('estudiante.index');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
         //Validación si es el mismo usuario
        //if(true)
        //{
            //Vista de editar
    
            //Estudiante a Editar
            $student = new student();
            $student = student::where('id', '=', $id)->first();

            //Redes del Estudiante
            $studentNetworks = new studentNetworks();
            $studentNetworks = studentNetworks::where('student', '=', $student->id)->get();
    
            //Intereses del Estudiante
            $studentInterests = new studentInterests();
            $studentInterests = studentInterests::join('interests', 'interests.id', '=', 'student_interests.interests')->where('student', '=', $student->id)->get();
    
            //EXPOS del Estudiante
            $studentExpos = new studentExpo();
            $studentExpos = studentExpo::join('expos', 'expos.id', '=', 'student_expos.expo')->where('student', '=', $student->id)->get();
    
            $allExpos = expo::all();
            $allInterests = interests::all();
    
            $user = new User();
            $user = User::where('id', '=', $student->user)->first();
    
            return view('admin.edit.student', compact('student', 'studentNetworks', 'studentInterests', 'studentExpos', 'allInterests', 'allExpos', 'user'));
        //}
        //else
        //{
        //   return redirect()->route('estudiante.index');
        //}
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $student = student::find($id);

        if($request->adminEditStudentPassword != null){
            $userStudent = user::find($student->user);
            $salt = Str::random(10);
            $userStudent->password = bcrypt($salt . $request->adminEditStudentPassword);
            $userStudent->salt = $salt;

            $userStudent->save();
        }

        $student->fullName = $request->adminEditStudentName;
        //$student->linkedin = $request->adminEditStudentLinkedin;
        
        if($request->adminEditStudentEmail == null ||
           $request->adminEditStudentName == null)
        {
                session()->flash("status","Hubo un problema en el registro");
               return redirect()->route('admin.index');
        }

        if($request->adminEditBtnStudent != null) {
            
            // Obtener la extensión del archivo
            $image = $request->file('adminEditBtnStudent');
            $extension = $image->getClientOriginalExtension(); 
            // Definir las extensiones permitidas
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
            // Verificar si la extensión está en la lista permitida
            if (in_array(strtolower($extension), $allowedExtensions)) {
                // La extensión es válida, y continua en el código para procesar el archivo
            } else {
                session()->flash("status","Hubo un problema en la edición");
                return redirect()->route('admin.index');
            }
            
            
            //Nombre de archivo
            $fileName = time().'_'.uniqid();
            //Guardar archivo

            Storage::disk('public')->delete('/'.$student->image);

            Storage::disk('public')->put($fileName, file_get_contents($request->file('adminEditBtnStudent')));
            $image = $request->file('adminEditBtnStudent');
            $image->move(public_path('studentImages'), $fileName);
        } else {
            $fileName = $request->originalImage;
        }
        $student->image = $fileName;

        studentNetworks::where('student',$id)->delete();
        if($request->adminEditStudentRed1 != null){
            $studentNetw = new studentNetworks();
            $studentNetw->red = $request->red1;
            $studentNetw->link = $request->adminEditStudentRed1;
            $studentNetw->student = $student->id;

            if($studentNetw->save()) {
                session()->flash("status","Estudiante registrado");
            }
            else {
                session()->flash("status","Hubo un problema en el registro");
            }
        }

        if($request->adminEditStudentRed2 != null){
            $studentNetw2 = new studentNetworks();
            $studentNetw2->red = $request->red2;
            $studentNetw2->link = $request->adminEditStudentRed2;
            $studentNetw2->student = $student->id;

            if($studentNetw2->save()) {
                session()->flash("status","Estudiante registrado");
            }
            else {
                session()->flash("status","Hubo un problema en el registro");
            }
        }

        if($request->adminEditStudentRed3 != null){
            $studentNetw3 = new studentNetworks();
            $studentNetw3->red = $request->red3;
            $studentNetw3->link = $request->adminEditStudentRed3;
            $studentNetw3->student = $student->id;

            if($studentNetw3->save()) {
                session()->flash("status","Estudiante registrado");
            }
            else {
                session()->flash("status","Hubo un problema en el registro");
            }
        }

        if($request->adminEditStudentRed4 != null){
            $studentNetw4 = new studentNetworks();
            $studentNetw4->red = $request->red4;
            $studentNetw4->link = $request->adminEditStudentRed4;
            $studentNetw4->student = $student->id;

            if($studentNetw4->save()) {
                session()->flash("status","Estudiante registrado");
            }
            else {
                session()->flash("status","Hubo un problema en el registro");
            }
        }

        if($request->adminEditStudentRed5 != null){
            $studentNetw5 = new studentNetworks();
            $studentNetw5->red = $request->red5;
            $studentNetw5->link = $request->adminEditStudentRed5;
            $studentNetw5->student = $student->id;

            if($studentNetw5->save()) {
                session()->flash("status","Estudiante registrado");
            }
            else {
                session()->flash("status","Hubo un problema en el registro");
            }
        }

        studentInterests::where('student',$id)->delete();
        if($request->adminEditStudentInterests != null) {
            foreach($request->adminEditStudentInterests as $StudentInterest){
                $studentInt = new studentInterests();
                $studentInt->interests = $StudentInterest;
                $studentInt->student = $student->id;
                $studentInt->save();
            }
        }

        studentExpo::where('student',$id)->delete();
        if($request->regStudentExpos != null) {
            foreach($request->regStudentExpos as $StudentExpo){
                $studentExpo = new studentExpo();
                $studentExpo->expo = $StudentExpo;
                $studentExpo->student = $student->id;
                $studentExpo->save();
            }
        }

        if($student->save()) {
            session()->flash("status","Estudiante editado correctamente");
        }
        else {
            session()->flash("status","Hubo un problema en la edición");
        }

        return redirect()->route('admin.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Borrar la relacion con las redes
        $networks = new studentNetworks();
        $networks = studentNetworks::where('student', '=', $id)->get();
        foreach($networks as $network)
        {
            if(!($network->delete()))
            {
                session()->flash("status","Hubo un problema en la eliminación");
                return redirect()->back();
            }
        }

        // Borrar la relacion con los intereses
        $interests = new studentInterests();
        $interests = studentInterests::where('student', '=', $id)->get();
        foreach($interests as $interest)
        {
            if(!($interest->delete()))
            {
                session()->flash("status","Hubo un problema en la eliminación");
                return redirect()->back();
            }
        }

        //Borrar expos
        $expos = studentExpo::where('student', '=', $id)->get();

        foreach($expos as $expo)
        {
            if(!($expo->delete()))
            {
                session()->flash("status","Hubo un problema en la eliminación");
                return redirect()->back();
            }
        }
        // Encontrar y borrar al Estudiante
        $student = student::where('id', '=', $id)->first();

        $user = new user();
        $user = User::where('id', '=', $student->user)->first();

        if($student->delete()){
            if($user->delete()) {
                session()->flash("deleteStudent","Estudiante eliminado correctamente");
            } else {
                session()->flash("deleteStudent","Ha ocurrido un error");
            }
        }else{
            session()->flash("status","Hubo un problema en la eliminación");
            return redirect()->back();
        }


        return redirect()->back();

    }
    public function verEstudiante($id){
        //Mostrar un estudiante
        $sdt = new student();
        $sdt = student::where('id', '=', $id)->first();
        
        if($sdt == null)
        {
            return redirect()->route('empresa.index');
        }
        else
        {
            $networks = new studentNetworks();
            $networks = studentNetworks::where('student', '=', $id)->get();

            //Mostrar intereses
            $interests = new studentInterests();
            $interests = studentInterests::join('interests', 'interests.id', '=', 'student_interests.interests')->where('student', '=', $sdt->id)->get();
    
            //Mostrar expos
            $allExpos = studentExpo::join('expos', 'expos.id', '=', 'student_expos.expo')->where('student', '=', $sdt->id)->get();
    
            return view('company.studentProfile', compact('sdt', 'networks', 'interests', 'allExpos'));
        }
    }

    public function editarImagen(Request $request, $id){

        $student = student::find($id);

        if($request->regBtnStudentImg != null) {
            $fileName = time().'_'.uniqid();
            Storage::disk('public')->delete('/'.$student->image);

            Storage::disk('public')->put($fileName, file_get_contents($request->file('regBtnStudentImg')));
            $image = $request->file('regBtnStudentImg');
            $image->move(public_path('studentImages'), $fileName);
        }else{
            $fileName = $student->image;
        }
        $student->image = $fileName;

        if($student->save()) {
            session()->flash("status","Imagen cambiada");
        }
        else{
            session()->flash("status","Hubo un problema en la edición");
        }
        return redirect()->back();

    }
    
    public function editarPassword(Request $request, $id){
        if($request->input('editPassword') != null && $request->input('actualPassword') != null && $request->input('confirmPassword') != null ){
            
            $auxStudent = student::find($id);
            $userID = $auxStudent->user;
            
            $user = User::find($userID);
            
            if($user->salt != null){
                if(Hash::check($user->salt . $request->input('actualPassword'), $user->password)){
                    if($request->input('editPassword') == $request->input('confirmPassword')){
                        $editPassword = $request->input('editPassword');
                        if (preg_match('/^(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*.])[A-Za-z\d!@#$%^&*.]{6,}$/', $editPassword)) {
                            $salt = Str::random(10);
                            $user->password = bcrypt($salt . $request->input('editPassword'));
                            $user->salt = $salt;    
                            
                            if($user->save()){
                                session()->flash("status","Contraseña cambiada.");
                                
                            }else{
                                session()->flash("status","Hubo un problema con la edición.");               
                            }
                        }else{
                            session()->flash("status","La contraseña no cumple los requisitos.");
                        }                         
                    }else{
                        session()->flash("status","Las contraseñas no coinciden.");
                    }                  
                }else{
                    session()->flash("status","Contraseña incorrecta.");               
                }
            }else{
                if($request->input('actualPassword') == $user->password){
                    if($request->input('editPassword') == $request->input('confirmPassword')){
                        $editPassword = $request->input('editPassword');
                        if (preg_match('/^(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*.])[A-Za-z\d!@#$%^&*.]{6,}$/', $editPassword)) {
                            $salt = Str::random(10);
                            $user->password = bcrypt($salt . $request->input('editPassword'));
                            $user->salt = $salt;    
                            
                            if($user->save()){
                                session()->flash("status","Contraseña cambiada.");
                                
                            }else{
                                session()->flash("status","Hubo un problema con la edición.");               
                            }
                        }else{
                            session()->flash("status","La contraseña no cumple los requisitos.");
                        }                           
                    }else{
                        session()->flash("status","Las contraseñas no coinciden.");
                    }                      
                }else{
                    session()->flash("status","Contraseña incorrecta.");
                }
            }
            
        }
        else{
            session()->flash("status","Campos incompletos.");
        }
        return redirect()->back();

    }

    public function editarRedes(Request $request, $id){

        //Borrar todas las redes
        studentNetworks::where('student', $id)->delete();

        if($request->input('red1') != null){
            $studentNetw = new studentNetworks();
            $studentNetw->red = $request->input('select1');
            $studentNetw->link = $request->input('red1');
            $studentNetw->student = $id;

            if($studentNetw->save()) {
                session()->flash("status","Redes editadas");
            }
            else {
                session()->flash("status","Hubo un problema en el registro");
            }
        }
        if($request->input('red2') != null){
            $studentNetw2 = new studentNetworks();
            $studentNetw2->red = $request->input('select2');
            $studentNetw2->link = $request->input('red2');
            $studentNetw2->student = $id;

            if($studentNetw2->save()) {
                session()->flash("status","Redes editadas");
            }
            else {
                session()->flash("status","Hubo un problema en el registro");
            }
        }
        if($request->input('red3') != null){
            $studentNetw3 = new studentNetworks();
            $studentNetw3->red = $request->input('select3');
            $studentNetw3->link = $request->input('red3');
            $studentNetw3->student = $id;

            if($studentNetw3->save()) {
                session()->flash("status","Redes editadas");
            }
            else {
                session()->flash("status","Hubo un problema en el registro");
            }
        }
        
        return redirect()->back();
    }

    public function apiStore(Request $request){

        //Verificar que el estudiante no ha sido registrado previamente

        $studentTmp = student::where('fullName', '=',$request->regStudentName)->first();

        if($studentTmp != null) //Hay una persona con el mismo nombre
        {
            $userStudentTmp = User::where('id', '=', $studentTmp->user)->first();

            //Buscar el id del a;o de la expo
            $expoStudent = expo::where('year', '=', $request->regStudentExpos)->first();

            if($expoStudent != null){
                //El a;o que se puso si esta en la bd de networking

                //Preguntar si existe el resgistro de alumno expo
                $studentExpoTmp = studentExpo::where('expo', '=', $expoStudent->id)->where('student', '=', $studentTmp->id)->first();

                if($studentExpoTmp != null){
                    //Se intenta registrar el mismo alumno en la misma expo
                    return response()->json([
                    'status' => 'Alumno previamente registrado',
                    'correo' => $userStudentTmp->email,
                    'contraseña' => $userStudentTmp->password
                    ]);
                }else{
                    //Mismo alumno dif expo
                    $studentExpo = new studentExpo();
                    $studentExpo->expo = $expoStudent->id; //2018
                    $studentExpo->student = $studentTmp->id;

                    if($studentExpo->save()) {
                        return response()->json([
                        'status' => 'Expo añadida al alumno',
                        'correo' => $userStudentTmp->email,
                        'contraseña' => $userStudentTmp->password
                        ]);
                    }
                    else {
                        return response()->json(['status' => 'Hubo un problema en el registro']);
                    }

                }

            }else{
                //Puso un a;o que no esta en la bd
                return response()->json(['status' => 'Hubo un problema en el registro.', 'msg' => 'El año no se ha registrado previamente, por favor contáctese con soporte.']);
            }


        }else{
            //Email
            $email = Str::lower(str_replace(" ", "",$request->regStudentName));

            $userStudent = new User();
            $userStudent->email = $email.'@net.working.com';
            $userStudent->password = Str::random(13);
            $userStudent->rol = 'student';

            //Buscar el id del a;o de la expo
            $expoStudent = expo::where('year', '=', $request->regStudentExpos)->first();

            if($expoStudent != null)
            {
                //Se guarda usuario
                if($userStudent->save()){

                    //Se crea un estudiante
                    $student = new student();

                    $student->fullName = $request->regStudentName;
                    $student->user = $userStudent->id;
                    $student->image = null;

                    //Se guarda estudiante
                    if($student->save()){

                        $studentExpo = new studentExpo();
                        $studentExpo->expo = $expoStudent->id; //2018
                        $studentExpo->student = $student->id;

                        if($studentExpo->save()) {
                            return response()->json([
                                'status' => 'Estudiante registrado',
                                'correo' => $userStudent->email,
                                'contraseña' => $userStudent->password
                            ]);
                        }
                        else {
                            return response()->json(['status' => 'Hubo un problema en el registro']);
                        }

                    } else {
                        return response()->json(['status' => 'Hubo un problema en el registro']);
                    }

                } else {
                    return response()->json(['status' => 'Hubo un problema en el registro']);
                }
            }else{
                //Puso un a;o que no esta en la bd
                return response()->json(['status' => 'Hubo un problema en el registro.', 'msg' => 'El año no se ha registrado previamente, por favor contáctese con soporte.']);
            }

        }



    }
}
