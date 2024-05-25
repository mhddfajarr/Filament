<?php

namespace App\Imports;

use App\Models\Team;
use App\Models\TeamUser;
use App\Models\Department;
use Filament\Facades\Filament;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DeparmentsImport implements ToModel, WithHeadingRow
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


        return new Department([
            'name'  => $row['name'],
            'team_id'    => $getID,
        ]);
    }
}
