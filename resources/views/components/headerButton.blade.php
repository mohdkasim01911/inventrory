<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3 gap-2">
    
    <h4 class="card-title mb-2 mb-md-0">{{$heading}}</h4>

    <div class="d-flex flex-wrap gap-2 justify-content-start justify-content-md-end">
        <!-- PDF -->
        <a href="#"
           class="btn btn-danger btn-sm d-flex align-items-center">
            <i class="mdi mdi-file-pdf-box me-1"></i>
            PDF
        </a>

        <!-- Excel -->
        <a href="{{ route($export) }}"
           class="btn btn-success btn-sm d-flex align-items-center">
            <i class="mdi mdi-file-excel-box me-1"></i>
            Excel
        </a>

        <!-- CSV -->
        <a href="{{ route($export, 1) }}"
           class="btn btn-primary btn-sm d-flex align-items-center">
            <i class="mdi mdi-file-delimited-outline me-1"></i>
            CSV
        </a>

        @if($route)
        <!-- Add -->
        <a href="{{ route($route) }}"
           class="btn btn-info btn-sm d-flex align-items-center">
            <i class="mdi mdi-plus-circle-outline me-1"></i>
            Add {{$heading}}
        </a>
        @endif
    </div>
</div>
