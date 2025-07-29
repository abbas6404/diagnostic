@extends('admin.setup.setup-layout')

@section('page-title', 'Prefix Setup')
@section('page-description', 'Configure system prefixes and numbering formats')

@section('setup-content')

    <div class="card shadow">
        <div class="card-header bg-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0 text-primary">
                    <i class="fas fa-cogs me-2"></i> Prefix Configuration
                </h5>
        <div>
                    <button class="btn btn-sm btn-outline-secondary me-2" onclick="resetAllPrefixes()">
                        <i class="fas fa-refresh me-1"></i> Reset All
                    </button>
                    <button class="btn btn-sm btn-outline-info me-2" onclick="exportPrefixSettings()">
                        <i class="fas fa-download me-1"></i> Export
                    </button>
                    <button class="btn btn-sm btn-primary" onclick="saveAllSettings()">
                        <i class="fas fa-save me-1"></i> Save All
                    </button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <!-- Left Column - Prefix Forms -->
                <div class="col-md-8">
                    <!-- Doctor Ticket Prefix -->
                    <div class="card border mb-4">
                        <div class="card-header bg-light py-2">
                            <h6 class="mb-0">
                                <i class="fas fa-user-md me-2"></i>Doctor Ticket Prefix
                            </h6>
                        </div>
                        <div class="card-body">
                            <form id="consolidatedInvoiceForm">
                                @csrf
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="consolidated_invoice_prefix" class="form-label fw-bold">Doctor Ticket Prefix</label>
                                            <input type="text" class="form-control form-control-sm" id="consolidated_invoice_prefix" 
                                                   name="consolidated_invoice_prefix" placeholder="e.g., DR" 
                                                   value="{{ $prefixSettings['consolidated_invoice']['prefix'] ?? 'DR' }}">
                                            <div class="form-text small">Prefix for doctor ticket numbers</div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                                                                    <div class="mb-3">
                                                <label for="consolidated_invoice_start" class="form-label fw-bold">Starting Number</label>
                                                <input type="number" class="form-control form-control-sm" id="consolidated_invoice_start" 
                                                       name="consolidated_invoice_start" placeholder="1" 
                                                       value="{{ $prefixSettings['consolidated_invoice']['start'] ?? '1' }}">
                                                <div class="form-text small">Starting number for doctor ticket sequence</div>
                                            </div>
                                    </div>
                                    <div class="col-md-4">
                                                                                    <div class="mb-3">
                                                <label for="consolidated_invoice_format" class="form-label fw-bold">Format</label>
                                                <select class="form-select form-select-sm" id="consolidated_invoice_format" name="consolidated_invoice_format">
                                                    <option value="prefix-yymmdd-number" {{ ($prefixSettings['consolidated_invoice']['format'] ?? 'prefix-yymmdd-number') == 'prefix-yymmdd-number' ? 'selected' : '' }}>prefix-yymmdd-number</option>
                                                    <option value="prefixyymmddnumber" {{ ($prefixSettings['consolidated_invoice']['format'] ?? 'prefix-yymmdd-number') == 'prefixyymmddnumber' ? 'selected' : '' }}>prefixyymmddnumber</option>
                                                    <option value="prefix-yymm-number" {{ ($prefixSettings['consolidated_invoice']['format'] ?? 'prefix-yymmdd-number') == 'prefix-yymm-number' ? 'selected' : '' }}>prefix-yymm-number</option>
                                                    <option value="prefixyymmnumber" {{ ($prefixSettings['consolidated_invoice']['format'] ?? 'prefix-yymmdd-number') == 'prefixyymmnumber' ? 'selected' : '' }}>prefixyymmnumber</option>
                                                    <option value="prefix-yy-number" {{ ($prefixSettings['consolidated_invoice']['format'] ?? 'prefix-yymmdd-number') == 'prefix-yy-number' ? 'selected' : '' }}>prefix-yy-number</option>
                                                    <option value="prefixyynumber" {{ ($prefixSettings['consolidated_invoice']['format'] ?? 'prefix-yymmdd-number') == 'prefixyynumber' ? 'selected' : '' }}>prefixyynumber</option>
                                                    <option value="prefix-number" {{ ($prefixSettings['consolidated_invoice']['format'] ?? 'prefix-yymmdd-number') == 'prefix-number' ? 'selected' : '' }}>prefix-number</option>
                                                    <option value="prefixnumber" {{ ($prefixSettings['consolidated_invoice']['format'] ?? 'prefix-yymmdd-number') == 'prefixnumber' ? 'selected' : '' }}>prefixnumber</option>
                                                </select>
                                                <div class="form-text small">Format for doctor ticket numbering</div>
                                            </div>
                                    </div>
                                </div>
                                                                        <div class="text-end">
                                            <button type="submit" class="btn btn-primary btn-sm">
                                                <i class="fas fa-save me-1"></i>Save Doctor Ticket Settings
                                            </button>
                                        </div>
                            </form>
                        </div>
                    </div>

                    <!-- Diagnosis Prefix -->
                    <div class="card border mb-4">
                        <div class="card-header bg-light py-2">
                            <h6 class="mb-0">
                                <i class="fas fa-stethoscope me-2"></i>Diagnosis Prefix
                            </h6>
                        </div>
                        <div class="card-body">
                            <form id="diagnosisForm">
                                @csrf
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="diagnosis_prefix" class="form-label fw-bold">Diagnosis Prefix</label>
                                            <input type="text" class="form-control form-control-sm" id="diagnosis_prefix" 
                                                   name="diagnosis_prefix" placeholder="e.g., DX" 
                                                   value="{{ $prefixSettings['diagnosis']['prefix'] ?? 'DX' }}">
                                            <div class="form-text small">Prefix for diagnosis codes</div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="diagnosis_start" class="form-label fw-bold">Starting Number</label>
                                            <input type="number" class="form-control form-control-sm" id="diagnosis_start" 
                                                   name="diagnosis_start" placeholder="1" 
                                                   value="{{ $prefixSettings['diagnosis']['start'] ?? '1' }}">
                                            <div class="form-text small">Starting number for diagnosis sequence</div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                                                                    <div class="mb-3">
                                                <label for="diagnosis_format" class="form-label fw-bold">Format</label>
                                                <select class="form-select form-select-sm" id="diagnosis_format" name="diagnosis_format">
                                                    <option value="prefix-yymmdd-number" {{ ($prefixSettings['diagnosis']['format'] ?? 'prefix-yymmdd-number') == 'prefix-yymmdd-number' ? 'selected' : '' }}>prefix-yymmdd-number</option>
                                                    <option value="prefixyymmddnumber" {{ ($prefixSettings['diagnosis']['format'] ?? 'prefix-yymmdd-number') == 'prefixyymmddnumber' ? 'selected' : '' }}>prefixyymmddnumber</option>
                                                    <option value="prefix-yymm-number" {{ ($prefixSettings['diagnosis']['format'] ?? 'prefix-yymmdd-number') == 'prefix-yymm-number' ? 'selected' : '' }}>prefix-yymm-number</option>
                                                    <option value="prefixyymmnumber" {{ ($prefixSettings['diagnosis']['format'] ?? 'prefix-yymmdd-number') == 'prefixyymmnumber' ? 'selected' : '' }}>prefixyymmnumber</option>
                                                    <option value="prefix-yy-number" {{ ($prefixSettings['diagnosis']['format'] ?? 'prefix-yymmdd-number') == 'prefix-yy-number' ? 'selected' : '' }}>prefix-yy-number</option>
                                                    <option value="prefixyynumber" {{ ($prefixSettings['diagnosis']['format'] ?? 'prefix-yymmdd-number') == 'prefixyynumber' ? 'selected' : '' }}>prefixyynumber</option>
                                                    <option value="prefix-number" {{ ($prefixSettings['diagnosis']['format'] ?? 'prefix-yymmdd-number') == 'prefix-number' ? 'selected' : '' }}>prefix-number</option>
                                                    <option value="prefixnumber" {{ ($prefixSettings['diagnosis']['format'] ?? 'prefix-yymmdd-number') == 'prefixnumber' ? 'selected' : '' }}>prefixnumber</option>
                                                </select>
                                                <div class="form-text small">Format for diagnosis numbering</div>
                                            </div>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary btn-sm">
                                        <i class="fas fa-save me-1"></i>Save Diagnosis Settings
                                    </button>
                                </div>
                            </form>
        </div>
    </div>

                    <!-- OPD Prefix -->
                    <div class="card border mb-4">
                        <div class="card-header bg-light py-2">
                            <h6 class="mb-0">
                                <i class="fas fa-user-md me-2"></i>OPD Prefix
                            </h6>
                        </div>
                        <div class="card-body">
                            <form id="opdForm">
                                @csrf
    <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="opd_prefix" class="form-label fw-bold">OPD Prefix</label>
                                            <input type="text" class="form-control form-control-sm" id="opd_prefix" 
                                                   name="opd_prefix" placeholder="e.g., OPD" 
                                                   value="{{ $prefixSettings['opd']['prefix'] ?? 'OPD' }}">
                                            <div class="form-text small">Prefix for OPD service codes</div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="opd_start" class="form-label fw-bold">Starting Number</label>
                                            <input type="number" class="form-control form-control-sm" id="opd_start" 
                                                   name="opd_start" placeholder="1" 
                                                   value="{{ $prefixSettings['opd']['start'] ?? '1' }}">
                                            <div class="form-text small">Starting number for OPD sequence</div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                                                                    <div class="mb-3">
                                                <label for="opd_format" class="form-label fw-bold">Format</label>
                                                <select class="form-select form-select-sm" id="opd_format" name="opd_format">
                                                    <option value="prefix-yymmdd-number" {{ ($prefixSettings['opd']['format'] ?? 'prefix-yymmdd-number') == 'prefix-yymmdd-number' ? 'selected' : '' }}>prefix-yymmdd-number</option>
                                                    <option value="prefixyymmddnumber" {{ ($prefixSettings['opd']['format'] ?? 'prefix-yymmdd-number') == 'prefixyymmddnumber' ? 'selected' : '' }}>prefixyymmddnumber</option>
                                                    <option value="prefix-yymm-number" {{ ($prefixSettings['opd']['format'] ?? 'prefix-yymmdd-number') == 'prefix-yymm-number' ? 'selected' : '' }}>prefix-yymm-number</option>
                                                    <option value="prefixyymmnumber" {{ ($prefixSettings['opd']['format'] ?? 'prefix-yymmdd-number') == 'prefixyymmnumber' ? 'selected' : '' }}>prefixyymmnumber</option>
                                                    <option value="prefix-yy-number" {{ ($prefixSettings['opd']['format'] ?? 'prefix-yymmdd-number') == 'prefix-yy-number' ? 'selected' : '' }}>prefix-yy-number</option>
                                                    <option value="prefixyynumber" {{ ($prefixSettings['opd']['format'] ?? 'prefix-yymmdd-number') == 'prefixyynumber' ? 'selected' : '' }}>prefixyynumber</option>
                                                    <option value="prefix-number" {{ ($prefixSettings['opd']['format'] ?? 'prefix-yymmdd-number') == 'prefix-number' ? 'selected' : '' }}>prefix-number</option>
                                                    <option value="prefixnumber" {{ ($prefixSettings['opd']['format'] ?? 'prefix-yymmdd-number') == 'prefixnumber' ? 'selected' : '' }}>prefixnumber</option>
                                                </select>
                                                <div class="form-text small">Format for OPD numbering</div>
                                            </div>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary btn-sm">
                                        <i class="fas fa-save me-1"></i>Save OPD Settings
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Right Column - Current Settings & Preview -->
                <div class="col-md-4">
                    <!-- Current Prefix Settings -->
                    <div class="card border mb-3">
                        <div class="card-header bg-primary text-white py-2">
                            <h6 class="mb-0">
                                <i class="fas fa-cog me-1"></i> Current Settings
                            </h6>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="text-center">Type</th>
                                            <th class="text-center">Prefix</th>
                                            <th class="text-center">Current</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                                                                        <tr>
                                                    <td class="text-center">
                                                        <span class="badge bg-primary">Doctor Ticket</span>
                                                    </td>
                                                    <td class="text-center">{{ $prefixSettings['consolidated_invoice']['prefix'] ?? 'DR' }}</td>
                                                    <td class="text-center">{{ $prefixSettings['consolidated_invoice']['current_number'] ?? '001' }}</td>
                                                </tr>
                                        <tr>
                                            <td class="text-center">
                                                <span class="badge bg-success">Diagnosis</span>
                                            </td>
                                            <td class="text-center">{{ $prefixSettings['diagnosis']['prefix'] ?? 'DX' }}</td>
                                            <td class="text-center">{{ $prefixSettings['diagnosis']['current_number'] ?? '001' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">
                                                <span class="badge bg-info">OPD</span>
                                            </td>
                                            <td class="text-center">{{ $prefixSettings['opd']['prefix'] ?? 'OPD' }}</td>
                                            <td class="text-center">{{ $prefixSettings['opd']['current_number'] ?? '001' }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Format Preview -->
                    <div class="card border mb-3">
                        <div class="card-header bg-info text-white py-2">
                            <h6 class="mb-0">
                                <i class="fas fa-eye me-1"></i> Format Preview
                            </h6>
                        </div>
                        <div class="card-body">
                                                                <div class="mb-3">
                                        <label class="form-label fw-bold small">Doctor Ticket Format:</label>
                                        <div class="form-control form-control-sm bg-light">
                                            <code id="invoicePreview">{{ $prefixSettings['consolidated_invoice']['prefix'] ?? 'DR' }}-250101-001</code>
                                        </div>
                                    </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold small">Diagnosis Format:</label>
                                <div class="form-control form-control-sm bg-light">
                                    <code id="diagnosisPreview">{{ $prefixSettings['diagnosis']['prefix'] ?? 'DX' }}-250101-001</code>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold small">OPD Format:</label>
                                <div class="form-control form-control-sm bg-light">
                                    <code id="opdPreview">{{ $prefixSettings['opd']['prefix'] ?? 'OPD' }}-250101-001</code>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="card border">
                        <div class="card-header bg-warning text-dark py-2">
                            <h6 class="mb-0">
                                <i class="fas fa-tools me-1"></i> Quick Actions
                            </h6>
                        </div>
                <div class="card-body">
                                                                <div class="d-grid gap-2">
                                        <button class="btn btn-outline-secondary btn-sm" onclick="resetAllPrefixes()">
                                            <i class="fas fa-refresh me-1"></i> Reset All Prefixes
                                        </button>
                                        <button class="btn btn-outline-info btn-sm" onclick="exportPrefixSettings()">
                                            <i class="fas fa-download me-1"></i> Export Settings
                                        </button>
                                        <button class="btn btn-outline-warning btn-sm" onclick="showImportModal()">
                                            <i class="fas fa-upload me-1"></i> Import Settings
                                        </button>
                                        <button class="btn btn-outline-success btn-sm" onclick="saveAllSettings()">
                                            <i class="fas fa-save me-1"></i> Save All Changes
                                        </button>

                                    </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


<!-- Import Settings Modal -->
<div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="importModalLabel">
                    <i class="fas fa-upload me-2"></i>Import Prefix Settings
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="importFile" class="form-label">Select JSON File</label>
                    <input type="file" class="form-control" id="importFile" accept=".json">
                    <div class="form-text">Select a previously exported prefix settings file</div>
                </div>
                <div class="mb-3">
                    <label for="importText" class="form-label">Or Paste JSON Data</label>
                    <textarea class="form-control" id="importText" rows="6" placeholder='{"consolidated_invoice":{"prefix":"DR","start":"1","format":"prefix-yymmdd-number"},"diagnosis":{"prefix":"DX","start":"1","format":"prefix-yymmdd-number"},"opd":{"prefix":"OPD","start":"1","format":"prefix-yymmdd-number"}}'></textarea>
                    <div class="form-text">Paste the JSON data directly</div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="importPrefixSettings()">
                    <i class="fas fa-upload me-1"></i>Import Settings
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
// Form submission handlers
document.getElementById('consolidatedInvoiceForm').addEventListener('submit', function(e) {
    e.preventDefault();
    savePrefixSettings('consolidated_invoice', this);
});

document.getElementById('diagnosisForm').addEventListener('submit', function(e) {
    e.preventDefault();
    savePrefixSettings('diagnosis', this);
});

document.getElementById('opdForm').addEventListener('submit', function(e) {
    e.preventDefault();
    savePrefixSettings('opd', this);
});

// Update previews when inputs change
document.addEventListener('input', function(e) {
    if (e.target.id === 'consolidated_invoice_prefix') {
        updateInvoicePreview();
    } else if (e.target.id === 'diagnosis_prefix') {
        updateDiagnosisPreview();
    } else if (e.target.id === 'opd_prefix') {
        updateOpdPreview();
    }
});

// Update previews when format selects change
document.addEventListener('change', function(e) {
    console.log('Change event triggered:', e.target.id, e.target.value);
    if (e.target.id === 'consolidated_invoice_format') {
        console.log('Updating invoice preview');
        updateInvoicePreview();
    } else if (e.target.id === 'diagnosis_format') {
        console.log('Updating diagnosis preview');
        updateDiagnosisPreview();
    } else if (e.target.id === 'opd_format') {
        console.log('Updating OPD preview');
        updateOpdPreview();
    }
});

function updateInvoicePreview() {
    const prefix = document.getElementById('consolidated_invoice_prefix').value || 'DR';
    const format = document.getElementById('consolidated_invoice_format').value;
    console.log('updateInvoicePreview called with:', { prefix, format });
    let preview = '';
    
    switch(format) {
        case 'prefix-yymmdd-number':
            preview = `${prefix}-250101-001`;
            break;
        case 'prefixyymmddnumber':
            preview = `${prefix}250101001`;
            break;
        case 'prefix-yymm-number':
            preview = `${prefix}-2501-001`;
            break;
        case 'prefixyymmnumber':
            preview = `${prefix}2501001`;
            break;
        case 'prefix-yy-number':
            preview = `${prefix}-25-001`;
            break;
        case 'prefixyynumber':
            preview = `${prefix}25001`;
            break;
        case 'prefix-number':
            preview = `${prefix}-001`;
            break;
        case 'prefixnumber':
            preview = `${prefix}001`;
            break;
        default:
            console.log('Unknown format:', format);
            preview = `${prefix}-250101-001`;
            break;
    }
    
    console.log('Setting preview to:', preview);
    document.getElementById('invoicePreview').textContent = preview;
}

function updateDiagnosisPreview() {
    const prefix = document.getElementById('diagnosis_prefix').value || 'DX';
    const format = document.getElementById('diagnosis_format').value;
    let preview = '';
    
    switch(format) {
        case 'prefix-yymmdd-number':
            preview = `${prefix}-250101-001`;
            break;
        case 'prefixyymmddnumber':
            preview = `${prefix}250101001`;
            break;
        case 'prefix-yymm-number':
            preview = `${prefix}-2501-001`;
            break;
        case 'prefixyymmnumber':
            preview = `${prefix}2501001`;
            break;
        case 'prefix-yy-number':
            preview = `${prefix}-25-001`;
            break;
        case 'prefixyynumber':
            preview = `${prefix}25001`;
            break;
        case 'prefix-number':
            preview = `${prefix}-001`;
            break;
        case 'prefixnumber':
            preview = `${prefix}001`;
            break;
    }
    
    document.getElementById('diagnosisPreview').textContent = preview;
}

function updateOpdPreview() {
    const prefix = document.getElementById('opd_prefix').value || 'OPD';
    const format = document.getElementById('opd_format').value;
    let preview = '';
    
    switch(format) {
        case 'prefix-yymmdd-number':
            preview = `${prefix}-250101-001`;
            break;
        case 'prefixyymmddnumber':
            preview = `${prefix}250101001`;
            break;
        case 'prefix-yymm-number':
            preview = `${prefix}-2501-001`;
            break;
        case 'prefixyymmnumber':
            preview = `${prefix}2501001`;
            break;
        case 'prefix-yy-number':
            preview = `${prefix}-25-001`;
            break;
        case 'prefixyynumber':
            preview = `${prefix}25001`;
            break;
        case 'prefix-number':
            preview = `${prefix}-001`;
            break;
        case 'prefixnumber':
            preview = `${prefix}001`;
            break;
    }
    
    document.getElementById('opdPreview').textContent = preview;
}

function savePrefixSettings(type, form) {
    const formData = new FormData(form);
    const data = Object.fromEntries(formData.entries());
    
    // Debug: Log the data being sent
    console.log('Saving prefix settings:', {
        type: type,
        data: data,
        formData: formData
    });
    
    fetch('{{ route("admin.setup.prefix.save-settings") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            type: type,
            ...data
        })
    })
    .then(response => {
        console.log('Response status:', response.status);
        return response.json();
    })
    .then(data => {
        console.log('Response data:', data);
        if (data.success) {
            showAlert('Settings saved successfully!', 'success');
            setTimeout(() => location.reload(), 1500);
        } else {
            showAlert('Error: ' + data.message, 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('Error saving settings', 'error');
    });
}

function saveAllSettings() {
    const formTypes = [
        { formId: 'consolidatedInvoiceForm', type: 'consolidated_invoice' },
        { formId: 'diagnosisForm', type: 'diagnosis' },
        { formId: 'opdForm', type: 'opd' }
    ];
    let savedCount = 0;
    
    formTypes.forEach(({ formId, type }) => {
        const form = document.getElementById(formId);
        if (form) {
            const formData = new FormData(form);
            const data = Object.fromEntries(formData.entries());
            
            fetch('{{ route("admin.setup.prefix.save-settings") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    type: type,
                    ...data
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    savedCount++;
                    if (savedCount === formTypes.length) {
                        showAlert('All settings saved successfully!', 'success');
                        setTimeout(() => location.reload(), 1500);
                    }
                } else {
                    showAlert('Error: ' + data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showAlert('Error saving settings', 'error');
            });
        }
    });
}

function resetAllPrefixes() {
    if (confirm('Are you sure you want to reset all prefix settings? This will reset all numbering sequences.')) {
        fetch('{{ route("admin.setup.prefix.reset") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showAlert('All prefixes have been reset successfully!', 'success');
                setTimeout(() => location.reload(), 1500);
            } else {
                showAlert('Error: ' + data.message, 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('Error resetting prefixes', 'error');
        });
    }
}

function exportPrefixSettings() {
    fetch('{{ route("admin.setup.prefix.export") }}', {
        method: 'GET',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
        }
    })
    .then(response => response.blob())
    .then(blob => {
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = 'prefix-settings.json';
        document.body.appendChild(a);
        a.click();
        window.URL.revokeObjectURL(url);
        document.body.removeChild(a);
        showAlert('Settings exported successfully!', 'success');
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('Error exporting settings', 'error');
    });
}

function showImportModal() {
    // Reset modal content
    document.getElementById('importFile').value = '';
    document.getElementById('importText').value = '';
    
    // Show the modal
    const modal = new bootstrap.Modal(document.getElementById('importModal'));
    modal.show();
}

function importPrefixSettings() {
    const importFile = document.getElementById('importFile');
    const importText = document.getElementById('importText').value.trim();
    
    let settings = null;
    
    // Check if file is selected
    if (importFile.files.length > 0) {
        const file = importFile.files[0];
        const reader = new FileReader();
        
        reader.onload = function(e) {
            try {
                const fileData = JSON.parse(e.target.result);
                settings = fileData.settings || fileData; // Handle both new and old export formats
                processImport(settings);
            } catch (error) {
                showAlert('Invalid JSON file. Please select a valid settings file.', 'error');
            }
        };
        
        reader.readAsText(file);
    } else if (importText) {
        // Check if text is entered
        try {
            const textData = JSON.parse(importText);
            settings = textData.settings || textData; // Handle both new and old export formats
            processImport(settings);
        } catch (error) {
            showAlert('Invalid JSON format. Please check your input.', 'error');
        }
    } else {
        showAlert('Please select a file or enter JSON data.', 'error');
    }
}

function processImport(settings) {
    // Validate the imported data
    if (!settings || typeof settings !== 'object') {
        showAlert('Invalid data format. Please check your import data.', 'error');
        return;
    }
    
    // Show confirmation popup
    const confirmMessage = `Are you sure you want to import these settings?\n\nThis will overwrite your current prefix settings:\n\n` +
        `Doctor Ticket: ${settings.consolidated_invoice?.prefix || 'N/A'} (${settings.consolidated_invoice?.format || 'N/A'})\n` +
        `Diagnosis: ${settings.diagnosis?.prefix || 'N/A'} (${settings.diagnosis?.format || 'N/A'})\n` +
        `OPD: ${settings.opd?.prefix || 'N/A'} (${settings.opd?.format || 'N/A'})`;
    
    if (confirm(confirmMessage)) {
        // Send the imported settings to the server
        fetch('{{ route("admin.setup.prefix.import") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ settings: settings })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showAlert('Settings imported successfully!', 'success');
                // Close modal
                const modal = bootstrap.Modal.getInstance(document.getElementById('importModal'));
                modal.hide();
                // Update form fields immediately without reload
                updateFormFields(settings);
                // Update previews
                updateInvoicePreview();
                updateDiagnosisPreview();
                updateOpdPreview();
            } else {
                showAlert('Error: ' + data.message, 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('Error importing settings', 'error');
        });
    }
}

function updateFormFields(settings) {
    console.log('Updating form fields with:', settings);
    
    // Update Doctor Ticket fields
    if (settings.consolidated_invoice) {
        const prefixField = document.getElementById('consolidated_invoice_prefix');
        const startField = document.getElementById('consolidated_invoice_start');
        const formatField = document.getElementById('consolidated_invoice_format');
        
        if (prefixField) prefixField.value = settings.consolidated_invoice.prefix || 'DR';
        if (startField) startField.value = settings.consolidated_invoice.start || '1';
        if (formatField) {
            formatField.value = settings.consolidated_invoice.format || 'prefix-yymmdd-number';
            console.log('Updated invoice format to:', formatField.value);
        }
    }
    
    // Update Diagnosis fields
    if (settings.diagnosis) {
        const prefixField = document.getElementById('diagnosis_prefix');
        const startField = document.getElementById('diagnosis_start');
        const formatField = document.getElementById('diagnosis_format');
        
        if (prefixField) prefixField.value = settings.diagnosis.prefix || 'DX';
        if (startField) startField.value = settings.diagnosis.start || '1';
        if (formatField) {
            formatField.value = settings.diagnosis.format || 'prefix-yymmdd-number';
            console.log('Updated diagnosis format to:', formatField.value);
        }
    }
    
    // Update OPD fields
    if (settings.opd) {
        const prefixField = document.getElementById('opd_prefix');
        const startField = document.getElementById('opd_start');
        const formatField = document.getElementById('opd_format');
        
        if (prefixField) prefixField.value = settings.opd.prefix || 'OPD';
        if (startField) startField.value = settings.opd.start || '1';
        if (formatField) {
            formatField.value = settings.opd.format || 'prefix-yymmdd-number';
            console.log('Updated OPD format to:', formatField.value);
        }
    }
}



function showAlert(message, type) {
    // Create alert element
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type === 'success' ? 'success' : 'danger'} alert-dismissible fade show position-fixed`;
    alertDiv.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
    alertDiv.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    document.body.appendChild(alertDiv);
    
    // Auto remove after 3 seconds
    setTimeout(() => {
        if (alertDiv.parentNode) {
            alertDiv.remove();
        }
    }, 3000);
}

// Initialize previews on page load
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM loaded, initializing previews...');
    
    // Check if elements exist
    const invoiceFormat = document.getElementById('consolidated_invoice_format');
    const diagnosisFormat = document.getElementById('diagnosis_format');
    const opdFormat = document.getElementById('opd_format');
    
    console.log('Elements found:', {
        invoiceFormat: !!invoiceFormat,
        diagnosisFormat: !!diagnosisFormat,
        opdFormat: !!opdFormat
    });
    
    if (invoiceFormat) {
        console.log('Invoice format current value:', invoiceFormat.value);
        // Add direct event listener
        invoiceFormat.addEventListener('change', function() {
            console.log('Direct change event on invoice format:', this.value);
            updateInvoicePreview();
        });
    }
    
    if (diagnosisFormat) {
        console.log('Diagnosis format current value:', diagnosisFormat.value);
        // Add direct event listener
        diagnosisFormat.addEventListener('change', function() {
            console.log('Direct change event on diagnosis format:', this.value);
            updateDiagnosisPreview();
        });
    }
    
    if (opdFormat) {
        console.log('OPD format current value:', opdFormat.value);
        // Add direct event listener
        opdFormat.addEventListener('change', function() {
            console.log('Direct change event on OPD format:', this.value);
            updateOpdPreview();
        });
    }
    
    updateInvoicePreview();
    updateDiagnosisPreview();
    updateOpdPreview();
});
</script>
@endsection 