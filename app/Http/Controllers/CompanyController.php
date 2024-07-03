<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\company;
use App\Models\companyInterests;
use App\Models\companyNetworks;
use App\Models\student;
use App\Models\interests;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Lista de estudiantes
        $students = new student();
        $students = student::all()->take(20);

        $allInterests = interests::all();


        return view('company.index', compact('students', 'allInterests'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $allInterests = interests::all();
        return view('admin.register.company', compact('allInterests'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->regCompanyName == null ||
            $request->regCompanyMail == null)
        {
            session()->flash("status","Hubo un problema en el registro");
            return redirect()->route('admin.index');
        }
        
        $email = Str::lower(str_replace(" ", "",$request->regCompanyMail));

        $userCompany = new User();
        $userCompany->email = $email;

        $salt = Str::random(10);
        $password = 'company123';

        $userCompany->password = bcrypt($salt . $password);
        $userCompany->salt = $salt;

        $userCompany->rol = 'company';

        $userCompanyValidate = User::where('email', $email)->first();

        if($userCompanyValidate)
        {
            session()->flash("status", "Correo ya existente");
            return redirect()->route('admin.index');
        }
        
        if($userCompany->save()){
            $company = new company();

            $company->fullName = $request->regCompanyName;
            //$company->linkedin = $request->regCompanyLinkedin;
            $company->user = $userCompany->id;

            if($company->save()){

                if($request->regCompanyRed1 != null){
                    $companyNetw = new companyNetworks();
                    $companyNetw->red = $request->red1;
                    $companyNetw->link = $request->regCompanyRed1;
                    $companyNetw->company = $company->id;
        
                    if($companyNetw->save()) {
                        session()->flash("status","Empresa registrada");
                    }
                    else {
                        session()->flash("status","Hubo un problema en el registro");
                    }
                }

                if($request->regCompanyRed2 != null){
                    $companyNetw2 = new companyNetworks();
                    $companyNetw2->red = $request->red2;
                    $companyNetw2->link = $request->regCompanyRed2;
                    $companyNetw2->company = $company->id;
        
                    if($companyNetw2->save()) {
                        session()->flash("status","Empresa registrada");
                    }
                    else {
                        session()->flash("status","Hubo un problema en el registro");
                    }
                }

                if($request->regCompanyRed3 != null){
                    $companyNetw3 = new companyNetworks();
                    $companyNetw3->red = $request->red3;
                    $companyNetw3->link = $request->regCompanyRed3;
                    $companyNetw3->company = $company->id;
        
                    if($companyNetw3->save()) {
                        session()->flash("status","Empresa registrada");
                    }
                    else {
                        session()->flash("status","Hubo un problema en el registro");
                    }
                }

                if($request->regCompanyInterests != null){
                    foreach($request->regCompanyInterests as $regCompanyInterest){
                        $companyInt = new companyInterests();
                        $companyInt->interests = $regCompanyInterest;
                        $companyInt->company = $company->id;

                        if($companyInt->save())
                            session()->flash("status","Empresa registrada");
                        else
                            session()->flash("status","Hubo un problema en el registro");
                    }
                }else{
                    session()->flash("status","Empresa registrada");
                }

            }else{
                session()->flash("status","Hubo un problema en el registro");
            }
        }else{
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
        //Validación de si es la misma empresa
        if(session()->get('id') == $id)
        {
            //Mostrar una empresa
            $company = new company();
            $company = company::where('user', '=', $id)->first();

            //Mostrar redes
            $networks = new companyNetworks();
            $networks = companyNetworks::where('company', '=', $company->id)->get();
    
            //Mostrar intereses
            $interests = new companyInterests();
            $interests = companyInterests::join('interests', 'interests.id', '=', 'company_interests.interests')->where('company', '=', $company->id)->get();
    
            return view('company.profile', compact('company', 'interests', 'networks'));
        }
        else
        {
            return redirect()->route('empresa.index');
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
        //if(session()->get('id') == $id)
        //{
            //Vista de editar
            $cmpy = new company();
            $cmpy = company::where('id', '=', $id)->first();
    
            $companyNetworks = new companyNetworks();
            $companyNetworks = companyNetworks::where('company', '=', $id)->get();

            //Mostrar intereses
            $interests = new companyInterests();
            $interests = companyInterests::join('interests', 'interests.id', '=', 'company_interests.interests')->where('company', '=', $cmpy->id)->get();
    
            $allInterests = interests::all();
    
            $user = new User();
            $user = User::where('id', '=', $cmpy->user)->first();
    
            return view('admin.edit.company', compact('cmpy', 'companyNetworks', 'interests', 'allInterests', 'user'));
        //}
        //else
        //{
        //    return redirect()->route('empresa.index');
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
        //Editar
        $cmpy = new company();
        $cmpy = company::where('id', '=', $id)->first();
        
        if($request->regCompanyName == null)
        {
            session()->flash("status","Hubo un problema en el registro");
            return redirect()->route('admin.index');
        }

        $cmpy->fullName = $request->regCompanyName;
        //$cmpy->linkedin = $request->regCompanyLinkedin;

        $user = new User();
        $user = User::where('id', '=', $cmpy->user)->first();

        if($request->regCompanyPass != null){
            $salt = Str::random(10);
            $user->password = bcrypt($salt . $request->regCompanyPass);
            $user->salt = $salt;    
        }
        
        companyNetworks::where('company', '=', $id)->delete();
        if($request->regCompanyRed1 != null){
            $companyNetw = new companyNetworks();
            $companyNetw->red = $request->red1;
            $companyNetw->link = $request->regCompanyRed1;
            $companyNetw->company = $cmpy->id;

            if($companyNetw->save()) {
                session()->flash("status","Empresa registrada");
            }
            else {
                session()->flash("status","Hubo un problema en el registro");
            }
        }

        if($request->regCompanyRed2 != null){
            $companyNetw2 = new companyNetworks();
            $companyNetw2->red = $request->red2;
            $companyNetw2->link = $request->regCompanyRed2;
            $companyNetw2->company = $cmpy->id;

            if($companyNetw2->save()) {
                session()->flash("status","Empresa registrada");
            }
            else {
                session()->flash("status","Hubo un problema en el registro");
            }
        }

        if($request->regCompanyRed3 != null){
            $companyNetw3 = new companyNetworks();
            $companyNetw3->red = $request->red3;
            $companyNetw3->link = $request->regCompanyRed3;
            $companyNetw3->company = $cmpy->id;

            if($companyNetw3->save()) {
                session()->flash("status","Empresa registrada");
            }
            else {
                session()->flash("status","Hubo un problema en el registro");
            }
        }

        if($request->regCompanyRed4 != null){
            $companyNetw4 = new companyNetworks();
            $companyNetw4->red = $request->red4;
            $companyNetw4->link = $request->regCompanyRed4;
            $companyNetw4->company = $cmpy->id;

            if($companyNetw4->save()) {
                session()->flash("status","Empresa registrada");
            }
            else {
                session()->flash("status","Hubo un problema en el registro");
            }
        }

        if($request->regCompanyRed5 != null){
            $companyNetw5 = new companyNetworks();
            $companyNetw5->red = $request->red5;
            $companyNetw5->link = $request->regCompanyRed5;
            $companyNetw5->company = $cmpy->id;

            if($companyNetw5->save()) {
                session()->flash("status","Empresa registrada");
            }
            else {
                session()->flash("status","Hubo un problema en el registro");
            }
        }

        $interests = new companyInterests();
        $interests = companyInterests::where('company', '=', $id)->get();

        foreach($interests as $interest)
        {
            if(!($interest->delete()))
            {
                session()->flash("status","Hubo un problema en la edición");
                return redirect()->route('admin.index');
            }
        }

        if($request->regCompanyInterests != null){
            foreach($request->regCompanyInterests as $regCompanyInterest){
                $companyInt = new companyInterests();
                $companyInt->interests = $regCompanyInterest;
                $companyInt->company = $cmpy->id;

                if(!($companyInt->save())){
                    session()->flash("status","Hubo un problema en la edición");
                    return redirect()->route('admin.index');
                }

            }
        }else{
            session()->flash("status","Se editó correctamente");
        }

        if($user->save() && $cmpy->save()){
            session()->flash("status","Se editó correctamente");
        }else{
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
        //Eliminar company interests
        //Eliminar usuario
        //Eliminar empresa

        $interests = new companyInterests();
        $interests = companyInterests::where('company', '=', $id)->get();

        foreach($interests as $interest)
        {
            if(!($interest->delete()))
            {
                session()->flash("status","Hubo un problema en el registro");
                return redirect()->route('admin.index');
            }
        }

        $company = new company();
        $company = company::where('id', '=', $id)->first();

        $user = new user();
        $user = User::where('id', '=', $company->user)->first();

        if($company->delete()){

            if($user->delete()){
                session()->flash("status","Se eliminó correctamente");
            }else{
                session()->flash("status","Hubo un problema en la eliminación");
                return redirect()->route('admin.index');
            }
        }else{
            session()->flash("status","Hubo un problema en la eliminación");
            return redirect()->route('admin.index');
        }

        return redirect()->route('admin.index');

    }
    public function verEmpresa($id){

        //Mostrar una empresa
        $compy = new company();
        $compy = company::where('id', '=', $id)->first();
        
        if($compy == null)
        {
            return redirect()->route('estudiante.index');
        }
        else
        {
            $networks = new companyNetworks();
            $networks = companyNetworks::where('company', '=', $id)->get();

            //Mostrar intereses
            $interests = new companyInterests();
            $interests = companyInterests::join('interests', 'interests.id', '=', 'company_interests.interests')->where('company', '=', $compy->id)->get();
    
    
            return view('students.companyProfile', compact('compy', 'networks', 'interests'));
        }

    }

    public function editarRedes(Request $request, $id){

        //Borrar todas las redes
        companyNetworks::where('company', $id)->delete();

        if($request->input('red1') != null){
            $companyNetw = new companyNetworks();
            $companyNetw->red = $request->input('select1');
            $companyNetw->link = $request->input('red1');
            $companyNetw->company = $id;

            if($companyNetw->save()) {
                session()->flash("status","Redes editadas");
            }
            else {
                session()->flash("status","Hubo un problema en el registro");
            }
        }
        if($request->input('red2') != null){
            $companyNetw2 = new companyNetworks();
            $companyNetw2->red = $request->input('select2');
            $companyNetw2->link = $request->input('red2');
            $companyNetw2->company = $id;

            if($companyNetw2->save()) {
                session()->flash("status","Redes editadas");
            }
            else {
                session()->flash("status","Hubo un problema en el registro");
            }
        }
        if($request->input('red3') != null){
            $companyNetw3 = new companyNetworks();
            $companyNetw3->red = $request->input('select3');
            $companyNetw3->link = $request->input('red3');
            $companyNetw3->company = $id;

            if($companyNetw3->save()) {
                session()->flash("status","Redes editadas");
            }
            else {
                session()->flash("status","Hubo un problema en el registro");
            }
        }
        
        return redirect()->back();
    }

    public function editarPass(Request $request, $id){
        if($request->input('editPassword') != null && $request->input('actualPassword') != null && $request->input('confirmPassword') != null ){
            
            $auxCompany = company::find($id);
            $userID = $auxCompany->user;
            
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
            
        }else{
            session()->flash("status","Campos incompletos.");
        }
        return redirect()->back();

    }

}
