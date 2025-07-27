<div>
    <!-- Search Input -->
    <div class="row mb-2">
        <label class="col-sm-4 col-form-label text-end">Patient/Inv No:</label>
        <div class="col-sm-8">
            <input 
                type="text" 
                class="form-control form-control-sm" 
                placeholder="Patient/Invoice No/ Name/ Phone/ Address"
                wire:model.live.debounce.300ms="search"
                autofocus   
            >   
        </div>
    </div>
</div> 