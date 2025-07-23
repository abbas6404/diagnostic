<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;

class PcpSearch extends Component
{
    public $search = '';
    
    protected $listeners = [
        'pcp-selected' => 'pcpSelected'
    ];
    
    public function updatedSearch()
    {
        if (strlen($this->search) >= 2) {
            $this->dispatch('showPcpResults', $this->search);
        } else {
            $this->dispatch('clearResults');
        }
    }
    
    public function pcpSelected($pcp)
    {
        $this->search = $pcp['code'];
    }
    
    public function render()
    {
        return view('livewire.pcp-search');
    }
} 