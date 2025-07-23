<div>
    <input 
        type="text" 
        class="form-control form-control-sm" 
        placeholder="Search Test by Code/Name" 
        wire:model.live.debounce.300ms="search"
        autocomplete="off"
        tabindex="13"
        id="lab-test-search-input"
        wire:keydown.enter="handleEnterKey"
    >
    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('focus-search', () => {
                document.getElementById('lab-test-search-input').focus();
            });
            
            Livewire.on('focus-discount', () => {
                // Focus on the discount percent input in the invoice summary
                const discountInput = document.getElementById('discountPercent');
                if (discountInput) {
                    discountInput.focus();
                    discountInput.select(); // Select all text for easy replacement
                }
            });
        });
    </script>
</div> 