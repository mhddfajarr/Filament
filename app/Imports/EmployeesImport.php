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

        return new Employee([
           'team_id' => $getID,
           'state_id' => 1666,
           'country_id' => 102,
           'city_id' => 21460,
           'department_id' => 52,
        //    'state_id' => self::getStateId($row['state']),
        //    'country_id' => self::getCountryId($row['country']),
        //    'city_id' => self::getCityId($row['city']),
        //    'department_id' => self::getDepartmentId($row['department']),
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

    public static function getStateId(string $state)
    {
        return State::where('name', $state)->first()->id;
    }
    public static function getCountryId(string $country)
    {
        return Country::where('name', $country)->first()->id;
    }
    public static function getCityId(string $city)
    {
        return City::where('name', $city)->first()->id;
    }
    public static function getDepartmentId(string $department)
    {
        return Department::where('name', $department)->first()->id;
    }
}
