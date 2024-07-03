<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\company;

class ProfileCompany extends Component
{
    public $company;
    public $idCompany;
    public $networks;

    public function render()
    {
        return view('livewire.profile-company');
    }

    public function editLinkedin(){
        $this->emit('editLinkedin');
    }

    public function stopEditing(){
        $this->emit('stopEditing');
    }
}
