<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\companyInterests;
use App\Models\company;
use App\Models\studentInterests;
use App\Models\student;

class IndexAdmin extends Component
{
    public $companies;
    public $students;
    public $searchTxt = "";
    public $pag = 0;
    public $inicio = 0;
    public $fin = 20;
    public $tablaMostrada = 'Estudiante'; 

    public function render()
    {
        return view('livewire.index-admin');
    }

    public function mostrarEmpresas()
    {
        $this->tablaMostrada = 'Empresa';
    }

    public function mostrarEstudiantes()
    {
        $this->tablaMostrada = 'Estudiante';
    }

    public function search(){
        if($this->tablaMostrada == 'Empresa'){
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
                if(!$duplicated)
                {
                array_push($companyTemp, company::where('id', '=', $companyNameTemp[$j]->id)->first()); 
                }
            }

            $this->companies = $companyTemp;
            
            if(count($this->companies) < 20)
            {
                $this->emit('lock-btn');
            }
        }
        else{
            $studentInterestsTemp = studentInterests::select('student_interests.student')
                                    ->join('interests', 'interests.id', '=', 'student_interests.interests')
                                    ->where('interests.name','like', '%'.$this->searchTxt.'%')->distinct()->skip($this->inicio)->take(20)->get();

            $studentNameTemp = student::select('students.fullName', 'students.id')->where('students.fullName','like', '%'.$this->searchTxt.'%')->distinct()->skip($this->inicio)->take(20)->get();
            $studentTemp = array();

            for($i= 0; $i< count($studentInterestsTemp); $i++){

                array_push($studentTemp, student::where('id', '=', $studentInterestsTemp[$i]->student)->first());
            }
            
            for($j= 0; $j< count($studentNameTemp); $j++)
            {
                $duplicated = false;
                for($c= 0; $c< count($studentTemp); $c++)
                {
                    if($studentTemp[$c]->id == $studentNameTemp[$j]->id)
                    {
                        $duplicated = true;
                    }
                }
                if(!$duplicated)
                {
                array_push($studentTemp, student::where('id', '=', $studentNameTemp[$j]->id)->first()); 
                }
            }

            $this->students = $studentTemp;
            
            if(count($this->students) < 20)
            {
                $this->emit('lock-btn');
            }
        }
        

        $this->dispatchBrowserEvent('contentChanged');
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
                    if($this->tablaMostrada == 'Empresa'){
                        $this->companies = company::skip($this->inicio)->take(20)->get();
                        if(count($this->companies) < 20)
                        {
                            $this->emit('lock-btn');
                        }
                    }
                    else{
                        $this->students = student::skip($this->inicio)->take(20)->get();
                        if(count($this->companies) < 20)
                        {
                            $this->emit('lock-btn');
                        }
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
}
