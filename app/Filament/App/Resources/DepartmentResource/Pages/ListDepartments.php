<?php

namespace App\Filament\App\Resources\DepartmentResource\Pages;

use Filament\Actions;
use App\Models\Department;
use Filament\Facades\Filament;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Illuminate\Contracts\View\View;
use Filament\Resources\Pages\ListRecords;
use App\Filament\App\Resources\DepartmentResource;
use App\Imports\DeparmentsImport;
use App\Models\TeamUser;
use Filament\Notifications\Notification;
use Maatwebsite\Excel\Facades\Excel;

class ListDepartments extends ListRecords
{
    protected static string $resource = DepartmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Action::make('importDepartments')
            ->label('Import Departments')
            ->icon('heroicon-o-document-arrow-down')
            ->form([
                FileUpload::make('attachment'),
            ])
            ->action(function (array $data){
                $file =public_path('storage/'. $data['attachment']);

                Excel::import(new DeparmentsImport, $file);

                Notification::make()
                    ->title('Department Import')
                    ->success()
                    ->Send();
            })
        ];
    }
}
