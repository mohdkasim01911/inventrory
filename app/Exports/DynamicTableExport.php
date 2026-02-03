<?php 

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DynamicTableExport implements FromCollection, WithHeadings
{
    protected $table;
    protected $columns;
    protected $joins;

    public function __construct($table, $columns = [], $joins = [])
    {
        $this->table   = $table;
        $this->columns = $columns;
        $this->joins   = $joins;
    }

    public function collection()
    {
        $query = DB::table($this->table);

        // 🔹 Apply joins dynamically
        foreach ($this->joins as $join) {
            $query->leftJoin(
                $join['table'],
                $join['first'],
                '=',
                $join['second']
            );
        }

        return $query->select($this->columns)->get();
    }

    public function headings(): array
    {
        // return $this->columns;
        return collect($this->columns)->map(function ($col) {
            return str_contains($col, ' as ')
                ? trim(explode(' as ', $col)[1])
                : $col;
        })->toArray();
    }
}
