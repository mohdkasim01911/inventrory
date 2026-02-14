<div class="d-flex flex-row justify-content-between align-items-center mb-3 gap-2">

    <!-- Heading -->
    <h4 class="card-title mb-0 flex-grow-1 text-truncate">
        {{$heading}}
    </h4>

    <!-- Buttons wrapper -->
    <div class="d-flex flex-nowrap gap-2 align-items-center">

        <!-- PDF (desktop only) -->
        <a href="#"
           class="btn btn-danger btn-sm d-none d-md-flex align-items-center">
            <i class="mdi mdi-file-pdf-box me-1"></i>
            PDF
        </a>

        <!-- Excel (desktop only) -->
        <a href="{{ route($export) }}"
           class="btn btn-success btn-sm d-none d-md-flex align-items-center">
            <i class="mdi mdi-file-excel-box me-1"></i>
            Excel
        </a>

        <!-- CSV (desktop only) -->
        <a href="{{ route($export, 1) }}"
           class="btn btn-primary btn-sm d-none d-md-flex align-items-center">
            <i class="mdi mdi-file-delimited-outline me-1"></i>
            CSV
        </a>

        <!-- Add (mobile + desktop) -->
        @if($route)
        <a href="{{ route($route) }}"
           class="btn btn-info btn-sm d-flex align-items-center flex-shrink-0">
            <i class="mdi mdi-plus-circle-outline me-1"></i>
            Add {{$heading}}
        </a>
        @endif

    </div>
</div>
