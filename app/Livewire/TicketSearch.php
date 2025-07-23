<?php

namespace App\Livewire;

use Livewire\Component;

class TicketSearch extends Component
{
    public $search = '';
    
    protected $listeners = [
        'ticket-selected' => 'ticketSelected'
    ];
    
    public function updatedSearch()
    {
        if (strlen($this->search) >= 2) {
            $this->dispatch('showTicketResults', $this->search);
            $this->dispatch('searchTypeChanged', 'Ticket');
        } else {
            $this->dispatch('clearResults');
        }
    }
    
    public function ticketSelected($ticket)
    {
        $this->search = $ticket['ticketNo'];
    }
    
    public function render()
    {
        return view('livewire.ticket-search');
    }
} 