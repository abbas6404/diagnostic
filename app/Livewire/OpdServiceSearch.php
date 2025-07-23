<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\OpdService;
use Illuminate\Support\Facades\DB;

class OpdServiceSearch extends Component
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
        $this->dispatch('searchTypeChanged', 'OPD Service');
        $this->dispatch('showOpdServiceResults', $this->search);
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
    
    public function selectService($serviceId)
    {
        $service = OpdService::find($serviceId);
        
        if ($service) {
            $this->dispatch('opd-service-selected', $service->toArray());
            $this->reset('search', 'searchResults');
            $this->dispatch('clearResults');
        }
    }
    
    public function render()
    {
        return view('livewire.opd-service-search');
    }
} 