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
        <div id="search-results-container">
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
            <div class="alert alert-info py-2 mb-0">No due invoices found matching "{{ $search }}"</div>
        </div>
    @else
        <div class="p-3 text-center text-muted">
            <i class="fas fa-info-circle me-2"></i> Type to search for due invoices
        </div>
    @endif

    <script>
        let currentSelectedIndex = 0;
        let searchItems = [];

        function updateSelection(newIndex) {
            console.log('updateSelection called with index:', newIndex);
            
            // Remove selected class from all items
            searchItems.forEach(item => {
                item.classList.remove('selected');
                const triangle = item.querySelector('.triangle-indicator');
                if (triangle) {
                    triangle.style.opacity = '0';
                }
            });
            
            // Add selected class to new item
            if (searchItems[newIndex]) {
                searchItems[newIndex].classList.add('selected');
                const triangle = searchItems[newIndex].querySelector('.triangle-indicator');
                if (triangle) {
                    triangle.style.opacity = '1';
                }
                
                // Scroll to the selected item if needed
                searchItems[newIndex].scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            }
            
            currentSelectedIndex = newIndex;
            console.log('Selection updated to index:', currentSelectedIndex);
        }

        document.addEventListener('livewire:init', function() {
            // Removed keyboard navigation events
        });
        
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOMContentLoaded - Initializing search results');
            
            // Initialize search items
            searchItems = document.querySelectorAll('.search-item');
            console.log('Found search items:', searchItems.length);
            
            // Add click event to all search items
            searchItems.forEach((item, index) => {
                item.addEventListener('click', function() {
                    console.log('Item clicked at index:', index);
                    currentSelectedIndex = index;
                    updateSelection(index);
                });
            });
            
            // Auto-select first result if available
            if (searchItems.length > 0) {
                currentSelectedIndex = 0;
                updateSelection(0);
            }
            
            // Update search items when Livewire updates the DOM
            const observer = new MutationObserver(function(mutations) {
                mutations.forEach(function(mutation) {
                    if (mutation.type === 'childList') {
                        const newSearchItems = document.querySelectorAll('.search-item');
                        if (newSearchItems.length !== searchItems.length) {
                            searchItems = newSearchItems;
                            
                            // Re-add click events
                            searchItems.forEach((item, index) => {
                                item.addEventListener('click', function() {
                                    currentSelectedIndex = index;
                                    updateSelection(index);
                                });
                            });
                            
                            // Auto-select first result
                            if (searchItems.length > 0) {
                                currentSelectedIndex = 0;
                                updateSelection(0);
                            }
                        }
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