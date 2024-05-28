<?php

namespace App\Imports;

use App\Models\City;
use App\Models\State;
use App\Models\Country;
use App\Models\Department;
use App\Models\Employee;
use App\Models\TeamUser;
use Maatwebsite\Excel\Row;
use Filament\Facades\Filament;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class EmployeesImport implements ToModel, WithHeadingRow
{
    use Importable;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // mengambil info user info
        $tenant = Filament::getTenant();
        // cari team user berdasarkan primary key karena otomatis sama antara primary key user dan team
        $teamUser = TeamUser::where('id', $tenant['id'])->first();
        // masukkan data team_id ke variabel getID
        $getID = $teamUser['team_id'];

       
        $country = Country::where('name', $row['country'])->first();
        // if ($state) {
        //     $getCountryID = $state->id;
        //     dd($getCountryID); 
        // } else {
        //     dd('Country not found'); 
        // };
        $state = State::where('name', $row['state'])->first();
        $city = City::where('name', $row['city'])->first();
        $department = Department::where('name', $row['department'])->first();
        return new Employee([
           'team_id' => $getID,
           'country_id' => $country->id,
           'state_id' => $state->id,
           'city_id' => $city->id,
           'department_id' => $department->id,
        //    'country_id' => self::getCountryId($row['country']),
           'first_name' => $row['first_name'],
           'middle_name' => $row['middle_name'],
           'last_name' => $row['last_name'],
           'address' => $row['address'],
           'zip_code' => $row['zip_code'],
           'date_of_birth' => $row['date_of_birth'],
           'date_hired' => $row['date_hired'],
           'created_at' => now(),
           'update_at' => now()
        ]);

    }

    // public static function getStateId(string $state)
    // {
    //     return State::where('name', $state)->first()->id;
    // }
}
