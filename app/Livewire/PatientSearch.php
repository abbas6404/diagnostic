<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class PatientSearch extends Component
{
    public $search = '';
    
    protected $listeners = [
        'patient-selected' => 'patientSelected'
    ];
    
    public function updatedSearch()
    {
        if (strlen($this->search) >= 2) {
            $this->dispatch('showPatientResults', $this->search);
        } else {
            $this->dispatch('clearResults');
        }
    }
    
    public function patientSelected($patient)
    {
        $this->search = $patient['patientId'];
    }
    
    public function render()
    {
        return view('livewire.patient-search');
    }
}
