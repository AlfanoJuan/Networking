<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\interests;
use App\Models\student;
use App\Models\studentInterests;

class IndexCompany extends Component
{
    protected $listeners = ['deleteFilter' => 'delete'];

    public $students;
    public $allInterests;
    public $searchTxt = "";
    public $pag = 0;
    public $inicio = 0;
    public $fin = 20;
    public $usedIndex = false;

    public function render()
    {
        $this->emit('load');

        return view('livewire.index-company');
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
                    $this->students = student::skip($this->inicio)->take(20)->get();
                    if(count($this->students) < 20)
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
    
    public function trimSpaces($cadena) {
      // Eliminar espacios en blanco al inicio y al final de la cadena
      $cadena = trim($cadena);
    
      // Verificar si hay texto antes o después de los espacios eliminados
      $espaciosInicio = strlen($cadena) - strlen(ltrim($cadena));
      $espaciosFinal = strlen($cadena) - strlen(rtrim($cadena));
    
      // Si no hay texto antes o después de los espacios, eliminarlos
      if ($espaciosInicio > 0 && $espaciosFinal > 0) {
        $cadena = trim($cadena);
      }
    
      return $cadena;
    }

    public function search(){

        $studentsInterestsTemp = studentInterests::select('student_interests.student')
                                    ->join('interests', 'interests.id', '=', 'student_interests.interests')
                                    ->where('interests.name','like', '%'.$this->searchTxt.'%')->distinct()->skip($this->inicio)->take(20)->get();
                                    
        $studentNameTemp = student::select('students.fullName', 'students.image')->where('students.fullName','like', '%'.$this->searchTxt.'%')->distinct()->skip($this->inicio)->take(20)->get();

        $studentsTemp = array();

        for($i= 0; $i< count($studentsInterestsTemp); $i++){

            array_push($studentsTemp, student::where('id', '=', $studentsInterestsTemp[$i]->student)->first());
        }
        
        for($j= 0; $j< count($studentNameTemp); $j++)
        {
            $keys = array_keys($studentsTemp, $studentNameTemp[$j]->fullName);
            if(empty($keys) && $this->usedIndex == false)
            {
               array_push($studentsTemp, student::where('fullName', '=', $studentNameTemp[$j]->fullName)->first());
               
            }
        }

        $this->students = $studentsTemp;
        
        if(count($this->students) < 20)
        {
            $this->emit('lock-btn');
        }
        
        $this->dispatchBrowserEvent('contentChanged');


        //dd($studentsTemp);
    }

    public function delete(){
        $this->searchTxt = "";
        $this->usedIndex = false;
        $this->students = student::all()->take(20);
        $this->pag = 0;
        $this->inicio = 0;
        $this->fin = 20;
    }

}
