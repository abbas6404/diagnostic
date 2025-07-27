<div>
    <!-- Search Input -->
    <div class="row mb-2">
        <label class="col-sm-4 col-form-label text-end">Patient/Ticket No:</label>
        <div class="col-sm-8">
            <input 
                type="text" 
                class="form-control form-control-sm" 
                placeholder="Patient/Ticket No/ Name/ Phone/ Address/ Doctor"
                wire:model.live.debounce.300ms="search"
                autofocus   
            >   
        </div>
    </div>
</div> 