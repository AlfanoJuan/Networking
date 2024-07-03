<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\interests;
use App\Models\companyInterests;

class InterestingAreas extends Component
{
    public $interests;
    public $allInterests;
    public $idCompany;
    public $isSetting = false;

    protected $listeners = ['updateInterests'];

    public function render()
    {
        return view('livewire.interesting-areas');
    }

    public function updateInterests()
    {
        $this->interests = companyInterests::join('interests', 'interests.id', '=', 'company_interests.interests')->where('company', '=', $this->idCompany)->get();
        
        $this->emit('applyStylesToInterests');
    }

    // public function initialAreas(){

    //     $this->isSetting = false;
    //     $this->interests = companyInterests::join('interests', 'interests.id', '=', 'company_interests.interests')->where('company', '=', $this->idCompany)->get();
    // }

    // public function configAreas(){
    //     //Cambio los intereses que se muestran
    //     $this->interests = interests::all();
    //     $this->emit('backFnc');

    //     $this->isSetting = true;
    // }

    public function updateRegister($id){

        $companyInt = new companyInterests();
        $companyInt->interests = $id;
        $companyInt->company = $this->idCompany;
        $interests = interests::where('id', '=', $id)->first();

        if($interests == null)
        {
            session()->flash("status","Hubo un problema editando el interés.");
            return redirect()->back();
        }
        $companyInt->save();

        $this->emit('updateInterests');
    }

    public function deleteRegister($id){

        $interests = companyInterests::where('interests', '=', $id)->where('company', '=', $this->idCompany)->first();
        if($interests == null)
        {
            session()->flash("status","Hubo un problema editando el interés.");
            return redirect()->back();
        }
        $interests->delete();

        $this->emit('updateInterests');
    }
}
