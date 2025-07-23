<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\LabTest;
use Illuminate\Support\Facades\DB;

class LabTestSearch extends Component
{
    public $search = '';
    public $searchResults = [];
    
    public function updatedSearch()
    {
        if (strlen($this->search) < 2) {
            $this->searchResults = [];
            $this->dispatch('clearResults');
            return;
        }
        
        // We're no longer using this array since we're showing results in the SearchResults component
        $this->searchResults = [];
        
        // Dispatch events to update the SearchResults component
        $this->dispatch('searchTypeChanged', 'Lab Test');
        $this->dispatch('showLabTestResults', $this->search);
    }
    
    public function handleEnterKey()
    {
        // If there's no search text or it's too short, focus on the discount input
        if (strlen($this->search) < 2) {
            $this->dispatch('focus-discount');
        } else {
            // Otherwise, keep focus on the search field
            $this->dispatch('focus-search');
        }
    }
    
    public function selectTest($testId)
    {
        $test = LabTest::with('department')->find($testId);
        
        if ($test) {
            $this->dispatch('lab-test-selected', $test->toArray());
            $this->reset('search', 'searchResults');
            $this->dispatch('clearResults');
        }
    }
    
    public function render()
    {
        return view('livewire.lab-test-search');
    }
}
