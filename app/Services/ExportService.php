<?php
namespace App\Services;

use App\Exports\DynamicTableExport;
use Maatwebsite\Excel\Facades\Excel;

class ExportService
{
   
   
    public function export($table, $columns, $type, $joins = [])
    {
        $fileName = $table . '_' . now()->format('Y_m_d_His');

        return Excel::download(
            new DynamicTableExport($table, $columns, $joins),
            $fileName . ($type ? '.csv' : '.xlsx')
        );
    }

  
}



