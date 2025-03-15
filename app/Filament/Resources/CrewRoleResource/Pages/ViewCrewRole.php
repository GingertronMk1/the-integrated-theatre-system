<?php

namespace App\Filament\Resources\CrewRoleResource\Pages;

use App\Filament\Resources\CrewRoleResource;
use App\Models\CrewMember;
use App\Models\CrewRole;
use Filament\Actions;
use Filament\Forms\Components\Select;
use Filament\Resources\Pages\ViewRecord;

class ViewCrewRole extends ViewRecord
{
    protected static string $resource = CrewRoleResource::class;

    protected function getHeaderActions(): array
    {
        $idKey = 'crew_role_id';

        return [
            Actions\EditAction::make(),
            Actions\Action::make('replace')
                ->form([
                    Select::make($idKey)
                        ->label('New Role')
                        ->options(CrewRole::query()->pluck('name', 'id'))
                        ->searchable()
                        ->required(),
                ])
                ->action(function (array $data, CrewRole $record) use ($idKey): void {
                    $newId = $data[$idKey];
                    CrewMember::query()
                        ->where(
                            'crew_role_id',
                            '=',
                            $record->id
                        )
                        ->update(['crew_role_id' => $newId]);
                    $record->delete();
                    session()->flash('status', 'Role successfully replaced');
                    $this->redirectRoute(
                        'filament.admin.resources.crew-roles.view',
                        ['record' => $newId]
                    );
                }),
        ];
    }
}
