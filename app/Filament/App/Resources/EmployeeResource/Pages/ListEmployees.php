<?php

namespace App\Filament\App\Resources\EmployeeResource\Pages;

use App\Filament\App\Resources\EmployeeResource;
use App\Imports\EmployeesImport;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Forms\Components\FileUpload;
use Filament\Resources\Pages\ListRecords;
use Maatwebsite\Excel\Facades\Excel;

class ListEmployees extends ListRecords
{
    protected static string $resource = EmployeeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Action::make('ImportEmployees')
            ->icon('heroicon-o-document-arrow-down')
            ->form([
                FileUpload::make('attachment'),
            ])
            ->action(function(array $data){
                $file= public_path('storage/'. $data['attachment']);

                Excel::import(new EmployeesImport, $file);

                Notification::make()
                    ->title('Employees Import')
                    ->success()
                    ->Send();
            })
        ];
    }
}
