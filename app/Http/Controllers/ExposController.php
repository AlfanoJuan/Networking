<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\expo;
use App\Models\studentExpo;

class ExposController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $allExpos = expo::all();

        return view('admin.expos', compact('allExpos'));
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $expo = new expo();

        if(is_numeric($request->regExpo))
        {
            $expo->year = $request->regExpo;

            if($expo->save()) {
                session()->flash("status","EXPO registrada");
            }
            else {
                session()->flash("status","Hubo un problema en el registro");
            }
    
            return redirect()->route('adminExpo.index');
        }
        else
        {
            session()->flash("status","Hubo un problema en el registro");
            return redirect()->route('adminExpo.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $expos = expo::find($id);

        if(count(studentExpo::where('expo',$id)->get()) > 0) {
            session()->flash("status","La EXPO pertenece a alguien y no puede ser eliminada");
        }else{
            if($expos->delete()){
                session()->flash("status","EXPO eliminada");
            }else{
                session()->flash("status","Hubo un problema en la eliminación");
            }
        }

        return redirect()->route('adminExpo.index');
    }
}
