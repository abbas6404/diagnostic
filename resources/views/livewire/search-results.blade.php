<div>
    <style>
        .address-cell {
            max-width: 150px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .search-item {
            cursor: pointer;
        }
        .search-item:hover {
            background-color: rgba(0, 123, 255, 0.1);
        }
        .search-item.selected {
            background-color: rgba(0, 123, 255, 0.2);
        }
        .triangle-indicator {
            width: 0;
            height: 0;
            border-top: 5px solid transparent;
            border-left: 8px solid #000;
            border-bottom: 5px solid transparent;
            display: inline-block;
            margin-right: 5px;
            visibility: hidden;
        }
        .search-item:hover .triangle-indicator {
            visibility: visible;
        }
        .search-item.selected .triangle-indicator {
            visibility: visible !important;
        }
    </style>
    
    @if($searchType == 'none')
        <div class="p-3 text-center text-muted">
            <i class="fas fa-info-circle me-2"></i> Type in Patient ID, Doctor, or PCP field to search
        </div>
    @elseif($searchType == 'patient')
        @if(count($results) > 0)
            <table class="table table-sm table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width: 20px;"></th>
                        <th style="width: 100px;">Patient ID</th>
                        <th style="width: 150px;">Patient Name</th>
                        <th style="width: 100px;">Contact</th>
                        <th>Address</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($results as $index => $patient)
                        <tr class="search-item {{ $index === 0 ? 'first-result' : '' }}" 
                            id="{{ $index === 0 ? 'first-patient-result' : '' }}"
                            wire:click="selectPatient(
                                '{{ is_object($patient) ? $patient->id : $patient['id'] }}', 
                                '{{ is_object($patient) ? $patient->patient_id : $patient['patient_id'] }}', 
                                '{{ is_object($patient) ? $patient->name_en : $patient['name_en'] }}', 
                                '{{ is_object($patient) ? ($patient->phone ?? '') : ($patient['phone'] ?? '') }}', 
                                '{{ is_object($patient) ? ($patient->address ?? '') : ($patient['address'] ?? '') }}'
                            )">
                            <td><div class="triangle-indicator"></div></td>
                            <td>{{ is_object($patient) ? $patient->patient_id : $patient['patient_id'] }}</td>
                            <td>{{ is_object($patient) ? $patient->name_en : $patient['name_en'] }}</td>
                            <td>{{ is_object($patient) ? ($patient->phone ?? 'N/A') : ($patient['phone'] ?? 'N/A') }}</td>
                            <td class="address-cell" title="{{ is_object($patient) ? ($patient->address ?? 'N/A') : ($patient['address'] ?? 'N/A') }}">
                                {{ is_object($patient) ? ($patient->address ?? 'N/A') : ($patient['address'] ?? 'N/A') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="p-3 text-center">
                <div class="alert alert-info py-2 mb-0">
                    @if(empty($query))
                        No recent patients found
                    @else
                        No patients found matching "{{ $query }}"
                    @endif
                </div>
            </div>
        @endif
    @elseif($searchType == 'doctor')
        @if(count($results) > 0)
            <table class="table table-sm table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width: 20px;"></th>
                        <th>Code</th>
                        <th>Name</th>
                        <th>Specialty</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($results as $index => $doctor)
                        <tr class="search-item {{ $index === 0 ? 'first-result' : '' }}" 
                            id="{{ $index === 0 ? 'first-doctor-result' : '' }}"
                            wire:click="selectDoctor('{{ $doctor['id'] }}', '{{ $doctor['code'] ?? 'N/A' }}', '{{ $doctor['name'] }}')">
                            <td><div class="triangle-indicator"></div></td>
                            <td>{{ $doctor['code'] ?? 'N/A' }}</td>
                            <td>{{ $doctor['name'] }}</td>
                            <td>{{ $doctor['description'] ?? '' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="p-3 text-center">
                <div class="alert alert-info py-2 mb-0">No doctors found matching "{{ $query }}"</div>
            </div>
        @endif
    @elseif($searchType == 'pcp')
        @if(count($results) > 0)
            <table class="table table-sm table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width: 20px;"></th>
                        <th>Code</th>
                        <th>Name</th>
                        <th>Description</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($results as $index => $pcp)
                        <tr class="search-item {{ $index === 0 ? 'first-result' : '' }}" 
                            id="{{ $index === 0 ? 'first-pcp-result' : '' }}"
                            wire:click="selectPcp('{{ $pcp['id'] }}', '{{ $pcp['code'] ?? 'N/A' }}', '{{ $pcp['name'] }}')">
                            <td><div class="triangle-indicator"></div></td>
                            <td>{{ $pcp['code'] ?? 'N/A' }}</td>
                            <td>{{ $pcp['name'] }}</td>
                            <td>{{ $pcp['description'] ?? '' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="p-3 text-center">
                <div class="alert alert-info py-2 mb-0">No PCPs found matching "{{ $query }}"</div>
            </div>
        @endif
    @elseif($searchType == 'ticket')
        @if(count($results) > 0)
            <table class="table table-sm table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width: 20px;"></th>
                        <th>Ticket No</th>
                        <th>Date</th>
                        <th>Patient</th>
                        <th>Doctor</th>
                        <th>Fee</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($results as $index => $ticket)
                        <tr class="search-item {{ $index === 0 ? 'first-result' : '' }}" 
                            id="{{ $index === 0 ? 'first-ticket-result' : '' }}"
                            wire:click="selectTicket(
                                '{{ is_object($ticket) ? $ticket->id : $ticket['id'] }}', 
                                '{{ is_object($ticket) ? $ticket->ticket_no : $ticket['ticket_no'] }}', 
                                '{{ is_object($ticket) ? $ticket->patient_name : $ticket['patient_name'] }}', 
                                '{{ is_object($ticket) ? $ticket->doctor_name : $ticket['doctor_name'] }}', 
                                '{{ is_object($ticket) ? $ticket->doctor_fee : $ticket['doctor_fee'] }}'
                            )">
                            <td><div class="triangle-indicator"></div></td>
                            <td>{{ is_object($ticket) ? $ticket->ticket_no : $ticket['ticket_no'] }}</td>
                            <td>{{ is_object($ticket) ? $ticket->ticket_date : $ticket['ticket_date'] }}</td>
                            <td>{{ is_object($ticket) ? $ticket->patient_name : $ticket['patient_name'] }}</td>
                            <td>{{ is_object($ticket) ? $ticket->doctor_name : $ticket['doctor_name'] }}</td>
                            <td>{{ is_object($ticket) ? $ticket->doctor_fee : $ticket['doctor_fee'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="p-3 text-center">
                <div class="alert alert-info py-2 mb-0">No tickets found matching "{{ $query }}"</div>
            </div>
        @endif
    @elseif($searchType == 'labtest')
        @if(count($results) > 0)
            <table class="table table-sm table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width: 20px;"></th>
                        <th>Code</th>
                        <th>Test Name</th>
                        <th>Department</th>
                        <th>Charge</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($results as $index => $test)
                        <tr class="search-item {{ $index === 0 ? 'first-result' : '' }}" 
                            id="{{ $index === 0 ? 'first-labtest-result' : '' }}"
                            wire:click="selectLabTest(
                                {{ is_object($test) ? $test->id : $test['id'] }}, 
                                '{{ addslashes(is_object($test) ? $test->code : $test['code']) }}', 
                                '{{ addslashes(is_object($test) ? $test->test_name : $test['test_name']) }}', 
                                {{ is_object($test) ? $test->charge : $test['charge'] }},
                                '{{ addslashes(is_object($test) ? $test->department_name : $test['department_name']) }}'
                            )">
                            <td><div class="triangle-indicator"></div></td>
                            <td>{{ is_object($test) ? $test->code : $test['code'] }}</td>
                            <td>{{ is_object($test) ? $test->test_name : $test['test_name'] }}</td>
                            <td>{{ is_object($test) ? $test->department_name : $test['department_name'] }}</td>
                            <td>{{ is_object($test) ? $test->charge : $test['charge'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="p-3 text-center">
                <div class="alert alert-info py-2 mb-0">No lab tests found matching "{{ $query }}"</div>
            </div>
        @endif
    @elseif($searchType == 'opdservice')
        @if(count($results) > 0)
            <table class="table table-sm table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width: 20px;"></th>
                        <th>Code</th>
                        <th>Service Name</th>
                        <th>Department</th>
                        <th>Charge</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($results as $index => $service)
                        <tr class="search-item {{ $index === 0 ? 'first-result' : '' }}" 
                            id="{{ $index === 0 ? 'first-opdservice-result' : '' }}"
                            wire:click="selectOpdService(
                                {{ is_object($service) ? $service->id : $service['id'] }}, 
                                '{{ addslashes(is_object($service) ? $service->code : $service['code']) }}', 
                                '{{ addslashes(is_object($service) ? $service->service_name : $service['service_name']) }}', 
                                {{ is_object($service) ? $service->charge : $service['charge'] }},
                                '{{ addslashes(is_object($service) ? $service->department_name : $service['department_name']) }}'
                            )">
                            <td><div class="triangle-indicator"></div></td>
                            <td>{{ is_object($service) ? $service->code : $service['code'] }}</td>
                            <td>{{ is_object($service) ? $service->service_name : $service['service_name'] }}</td>
                            <td>{{ is_object($service) ? $service->department_name : $service['department_name'] }}</td>
                            <td>{{ is_object($service) ? $service->charge : $service['charge'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="p-3 text-center">
                <div class="alert alert-info py-2 mb-0">No OPD services found matching "{{ $query }}"</div>
            </div>
        @endif
    @elseif($searchType == 'invoice')
        @if(count($results) > 0)
            <table class="table table-sm table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width: 20px;"></th>
                        <th>Invoice No</th>
                        <th>Patient Name</th>
                        <th>Date</th>
                        <th>Total</th>
                        <th>Due</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($results as $index => $invoice)
                        <tr class="search-item {{ $index === 0 ? 'first-result' : '' }}"
                            id="{{ $index === 0 ? 'first-invoice-result' : '' }}"
                            wire:click="selectInvoice(
                                '{{ is_object($invoice) ? $invoice->id : $invoice['id'] }}',
                                '{{ is_object($invoice) ? $invoice->invoice_no : $invoice['invoice_no'] }}',
                                '{{ is_object($invoice) ? $invoice->patient_name : $invoice['patient_name'] }}',
                                '{{ is_object($invoice) ? $invoice->invoice_date : $invoice['invoice_date'] }}',
                                '{{ is_object($invoice) ? $invoice->total_amount : $invoice['total_amount'] }}',
                                '{{ is_object($invoice) ? $invoice->due_amount : $invoice['due_amount'] }}'
                            )">
                            <td><div class="triangle-indicator"></div></td>
                            <td>{{ is_object($invoice) ? $invoice->invoice_no : $invoice['invoice_no'] }}</td>
                            <td>{{ is_object($invoice) ? $invoice->patient_name : $invoice['patient_name'] }}</td>
                            <td>{{ is_object($invoice) ? $invoice->invoice_date : $invoice['invoice_date'] }}</td>
                            <td>{{ is_object($invoice) ? $invoice->total_amount : $invoice['total_amount'] }}</td>
                            <td>{{ is_object($invoice) ? $invoice->due_amount : $invoice['due_amount'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="p-3 text-center">
                <div class="alert alert-info py-2 mb-0">No invoices found matching "{{ $query }}"</div>
            </div>
        @endif
    @endif

    <script>
        document.addEventListener('livewire:init', function() {
            Livewire.on('focusFirstResult', (type) => {
                // Increase timeout to ensure DOM is fully updated
                setTimeout(() => {
                    let firstRow;
                    
                    if (type === 'patient') {
                        firstRow = document.getElementById('first-patient-result');
                    } else if (type === 'doctor') {
                        firstRow = document.getElementById('first-doctor-result');
                    } else if (type === 'pcp') {
                        firstRow = document.getElementById('first-pcp-result');
                    } else if (type === 'labtest') {
                        firstRow = document.getElementById('first-labtest-result');
                    } else if (type === 'opdservice') {
                        firstRow = document.getElementById('first-opdservice-result');
                    }
                    
                    if (firstRow) {
                        // Remove selected class from all items
                        document.querySelectorAll('.search-item').forEach(item => {
                            item.classList.remove('selected');
                        });
                        
                        // Add selected class to first row
                        firstRow.classList.add('selected');
                        
                        // Make the triangle indicator visible
                        const triangle = firstRow.querySelector('.triangle-indicator');
                        if (triangle) {
                            triangle.style.visibility = 'visible';
                        }
                        
                        // Scroll to the first row if needed
                        firstRow.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                        
                        // Add keyboard event listener for Enter key
                        document.addEventListener('keydown', function enterKeyHandler(e) {
                            if (e.key === 'Enter' && document.querySelector('.search-item.selected')) {
                                e.preventDefault();
                                document.querySelector('.search-item.selected').click();
                                document.removeEventListener('keydown', enterKeyHandler);
                            }
                        });
                    } else {
                        // Fallback: if ID-based selection fails, try class-based selection
                        const firstResult = document.querySelector('.first-result');
                        if (firstResult) {
                            // Remove selected class from all items
                            document.querySelectorAll('.search-item').forEach(item => {
                                item.classList.remove('selected');
                            });
                            
                            // Add selected class to first row
                            firstResult.classList.add('selected');
                            
                            // Make the triangle indicator visible
                            const triangle = firstResult.querySelector('.triangle-indicator');
                            if (triangle) {
                                triangle.style.visibility = 'visible';
                            }
                            
                            // Scroll to the first row if needed
                            firstResult.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                        }
                    }
                }, 300); // Increased timeout to ensure DOM is ready
            });
        });
        
        document.addEventListener('DOMContentLoaded', function() {
            // Add click event to all search items
            document.querySelectorAll('.search-item').forEach(item => {
                item.addEventListener('click', function() {
                    // Remove selected class from all items
                    document.querySelectorAll('.search-item').forEach(i => {
                        i.classList.remove('selected');
                        // Hide all triangle indicators
                        const triangle = i.querySelector('.triangle-indicator');
                        if (triangle) {
                            triangle.style.visibility = 'hidden';
                        }
                    });
                    
                    // Add selected class to clicked item
                    this.classList.add('selected');
                    
                    // Show triangle indicator for selected item
                    const triangle = this.querySelector('.triangle-indicator');
                    if (triangle) {
                        triangle.style.visibility = 'visible';
                    }
                });
            });
            
            // Immediately select the first result if available
            const firstResult = document.querySelector('.first-result');
            if (firstResult) {
                firstResult.classList.add('selected');
                const triangle = firstResult.querySelector('.triangle-indicator');
                if (triangle) {
                    triangle.style.visibility = 'visible';
                }
            }
        });
    </script>
</div>
