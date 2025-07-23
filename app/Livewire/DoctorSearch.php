<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;

class DoctorSearch extends Component
{
    public $search = '';
    
    protected $listeners = [
        'doctor-selected' => 'doctorSelected'
    ];
    
    public function updatedSearch()
    {
        if (strlen($this->search) >= 2) {
            $this->dispatch('showDoctorResults', $this->search);
        } else {
            $this->dispatch('clearResults');
        }
    }
    
    public function doctorSelected($doctor)
    {
        $this->search = $doctor['code'];
    }
    
    public function render()
    {
        return view('livewire.doctor-search');
    }
} 