<div>
    <div>
        <input type="text" class="form-control form-control-sm" wire:model.live.debounce.300ms="search" 
               placeholder="Search Patient ID/Name/Phone/Address" 
               wire:focus="loadDefaultPatients"
               autofocus tabindex="1">
    </div>
</div>
