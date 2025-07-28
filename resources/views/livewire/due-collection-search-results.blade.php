<div>
    <style>
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
            opacity: 0;
            transition: opacity 0.2s ease;
        }
        .search-item:hover .triangle-indicator {
            opacity: 1;
        }
        .search-item.selected .triangle-indicator {
            opacity: 1 !important;
        }
    </style>
    
    @if(count($results) > 0)
        <div id="search-results-container" tabindex="0" style="outline: none;" onclick="this.focus()">
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
            <tbody id="search-results-body">
                                @foreach($results as $index => $invoice)
                                    <tr class="search-item {{ $index === 0 ? 'first-result' : '' }}"
                                        id="{{ $index === 0 ? 'first-invoice-result' : '' }}"
                        wire:click="selectInvoice({{ $invoice['invoice_id'] }})"
                        data-index="{{ $index }}"
                        data-invoice-id="{{ $invoice['invoice_id'] }}"
                    >
                                        <td><div class="triangle-indicator"></div></td>
                        <td>{{ $invoice['invoice_no'] }}</td>
                        <td>{{ $invoice['patient_name'] }}</td>
                        <td>{{ date('d M y', strtotime($invoice['invoice_date'])) }}</td>
                        <td>{{ number_format($invoice['total_amount'], 0) }}</td>
                        <td class="text-danger fw-bold">{{ number_format($invoice['due_amount'], 0) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
    @elseif(strlen($search) >= 2)
        <div class="p-3 text-center">
            <div class="alert alert-info py-2 mb-0">No due OPD invoices found matching "{{ $search }}"</div>
                    </div>
                @else
        <div class="p-3 text-center text-muted">
            <i class="fas fa-info-circle me-2"></i> 
            @if(count($results) == 0)
                No OPD invoices found in database. Please create some OPD invoices first.
            @else
                Type to search for due OPD invoices
                @endif
        </div>
    @endif

<script>
        document.addEventListener('livewire:init', function() {
            // Don't auto-focus - let user control focus
        });
        
        // Don't auto-focus search results container - let user control focus
        document.addEventListener('search-results-updated', function() {
            // Only add visual feedback, don't change focus
            const container = document.getElementById('search-results-container');
            if (container) {
                // Add visual feedback without changing focus
                document.querySelectorAll('.keyboard-focus').forEach(el => el.classList.remove('keyboard-focus'));
                container.classList.add('keyboard-focus');
            }
        });
        
        document.addEventListener('DOMContentLoaded', function() {
            // Don't auto-focus - let user control focus
            
            // Update search items when Livewire updates the DOM
            const observer = new MutationObserver(function(mutations) {
                mutations.forEach(function(mutation) {
                    if (mutation.type === 'childList') {
                        // Don't auto-focus - let user control focus
                    }
                });
            });
            
            // Start observing
            const searchResultsBody = document.getElementById('search-results-body');
            if (searchResultsBody) {
                observer.observe(searchResultsBody, { childList: true, subtree: true });
            }
            
            // Cleanup when component is destroyed
            document.addEventListener('livewire:destroy', function() {
                if (observer) {
                    observer.disconnect();
        }
    });
});
</script> 
</div> 