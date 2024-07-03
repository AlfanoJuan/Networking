<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\interests;
use App\Models\companyInterests;
use App\Models\student;
use App\Models\studentInterests;
use Illuminate\Support\Facades\Storage;

class InterestsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Regresar los invitados
        $interests = \App\Models\interests::all();
        //Vista de eventos

        return view('admin.interests', compact('interests'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function show($id)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $interests = new interests();
        
        if($request->interest == null)
        {
            session()->flash("status","Hubo un problema en el registro");
            return redirect()->route('adminInterests.index');
        }

        //Nombre de archivo

        $interests->name =  $request->interest;

        if($interests->save()){
            session()->flash("status","Interés registrado");
        }else{
            session()->flash("status","Hubo un problema en el registro");
        }
        return redirect()->route('adminInterests.index');
    }

    public function destroy($id)
    {
        $interest = interests::find($id);

        if(count(studentInterests::where('interests',$id)->get()) > 0 || count(companyInterests::where('interests',$id)->get()) > 0 ) {
            session()->flash("status","El interés pertenece a alguien y no puede ser eliminado");
        }else{
            if($interest->delete()){
                session()->flash("status","Interés eliminado");
            }else{
                session()->flash("status","Hubo un problema en la eliminación");
            }
        }


        return redirect()->route('adminInterests.index');
    }
}
