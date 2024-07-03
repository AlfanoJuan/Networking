<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\companyInterests;
use App\Models\company;

class IndexStudent extends Component
{
    protected $listeners = ['deleteFilter' => 'delete'];

    public $allInterests;
    public $companies;
    public $searchTxt = "";
    public $usedIndex = false;
    public $pag = 0;
    public $inicio = 0;
    public $fin = 20;

    public function render()
    {
        $this->emit('load');

        return view('livewire.index-student');
    }
    
    public function pagination($pagcont)
    {
        
        if (is_numeric($pagcont)) {
            if (strpos($pagcont, '.') !== false) {
                $pagcont = intval($pagcont);
            }
            if($pagcont < 0)
            { 
                
            }
            else
            {
                if($pagcont-1 >= 0)
                {
                    $this->emit('unlock-btn');
                }
                $this->inicio = $pagcont * 20;
                $this->fin = $pagcont * 20 + 20;
                //$this->students = student::all()->take(20 * $pagcont+1);
                if(empty($this->searchTxt))
                {
                    $this->companies = company::skip($this->inicio)->take(20)->get();
                    if(count($this->companies) < 20)
                    {
                         $this->emit('lock-btn');
                    }
                }
                else
                {
                    $this->search();
                }
                $this->pag = $pagcont;
            }
        } else {
            // La variable no es un número válido
        }
        
        
    }

    public function addFilter($txt, $index){
        $this->searchTxt = $txt;
        if(!empty($index))
        {
            $this->usedIndex = true;
        }
        $this->emit('filter', $txt, $index);
        $this->search();
    }

    public function search(){

        $companyInterestsTemp = companyInterests::select('company_interests.company')
                                    ->join('interests', 'interests.id', '=', 'company_interests.interests')
                                    ->where('interests.name','like', '%'.$this->searchTxt.'%')->distinct()->skip($this->inicio)->take(20)->get();

        $companyNameTemp = company::select('companies.fullName', 'companies.id')->where('companies.fullName','like', '%'.$this->searchTxt.'%')->distinct()->skip($this->inicio)->take(20)->get();
        $companyTemp = array();

        for($i= 0; $i< count($companyInterestsTemp); $i++){

            array_push($companyTemp, company::where('id', '=', $companyInterestsTemp[$i]->company)->first());
        }
        
        for($j= 0; $j< count($companyNameTemp); $j++)
        {
            $duplicated = false;
            for($c= 0; $c< count($companyTemp); $c++)
            {
                if($companyTemp[$c]->id == $companyNameTemp[$j]->id)
                {
                    $duplicated = true;
                }
            }
            if(!$duplicated && $this->usedIndex == false)
            {
               array_push($companyTemp, company::where('id', '=', $companyNameTemp[$j]->id)->first()); 
            }
        }

        $this->companies = $companyTemp;
        
        if(count($this->companies) < 20)
        {
            $this->emit('lock-btn');
        }

        $this->dispatchBrowserEvent('contentChanged');
    }

    public function delete(){
        $this->searchTxt = "";
        $this->usedIndex = false;
        $this->companies = company::all()->take(20);
        $this->pag = 0;
        $this->inicio = 0;
        $this->fin = 20;
    }

}
