<?php

namespace App\Exports;

use App\Models\Employee;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class EmployeesExport implements FromCollection, WithMapping, WithHeadings
{
    use Exportable;

    public function __construct(public Collection $records)
    {
        // $this->records = $records;
        
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
       return  $this->records;
        // return Employee::all();
        // return Employee::with('country')->get(); // Memuat relasi country
    }

    public function map($employee): array
    {
        return [
            
            $employee->first_name,
            $employee->middle_name, 
            $employee->last_name,
            $employee->country->name,
            $employee->state->name,
            $employee->city->name,
            $employee->department->name,
            $employee->address,
            $employee->zip_code,
            $employee->date_of_birth,
            $employee->date_hired,
        ];
    }

    public function headings(): array
    {
        return [
            'First Name',
            'Middle Name',
            'Last Name',
            'Country',
            'State',
            'City',
            'Department',
            'address',
            'Zip Code',
            'Date of Birth',
            'Date Hired'
        ];
    }
}
