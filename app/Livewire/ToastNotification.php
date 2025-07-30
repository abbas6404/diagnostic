<?php

namespace App\Livewire;

use Livewire\Component;

class ToastNotification extends Component
{
    public $show = false;
    public $message = '';
    public $type = 'info'; // success, error, info, warning
    public $invoiceNo = '';
    public $ticketNo = '';

    protected $listeners = [
        'showToast' => 'showToast',
        'showSuccess' => 'showSuccess',
        'showError' => 'showError',
        'showInfo' => 'showInfo',
        'showWarning' => 'showWarning',
        'showInvoiceSuccess' => 'showInvoiceSuccess',
        'showPaymentSuccess' => 'showPaymentSuccess'
    ];

    public function showToast($message, $type = 'info', $invoiceNo = '', $ticketNo = '')
    {
        $this->message = $message;
        $this->type = $type;
        $this->invoiceNo = $invoiceNo;
        $this->ticketNo = $ticketNo;
        $this->show = true;
    }

    public function showSuccess($message, $invoiceNo = '', $ticketNo = '')
    {
        $this->showToast($message, 'success', $invoiceNo, $ticketNo);
    }

    public function showError($message)
    {
        $this->showToast($message, 'error');
    }

    public function showInfo($message)
    {
        $this->showToast($message, 'info');
    }

    public function showWarning($message)
    {
        $this->showToast($message, 'warning');
    }

    public function showInvoiceSuccess($message, $invoiceNo, $ticketNo = '')
    {
        $this->showToast($message, 'success', $invoiceNo, $ticketNo);
    }

    public function showPaymentSuccess($message, $invoiceNo = '')
    {
        $this->showToast($message, 'success', $invoiceNo);
    }

    public function hideToast()
    {
        $this->show = false;
        $this->message = '';
        $this->invoiceNo = '';
        $this->ticketNo = '';
        
        // Reload the page when toast is closed
        $this->dispatch('reloadPage');
    }

    public function render()
    {
        return view('livewire.toast-notification');
    }
} 