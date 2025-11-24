<?php

namespace App\Filament\Resources\ProjectLeads;

use App\Filament\Resources\ProjectLeads\Pages\CreateProjectLead;
use App\Filament\Resources\ProjectLeads\Pages\EditProjectLead;
use App\Filament\Resources\ProjectLeads\Pages\ListProjectLeads;
use App\Filament\Resources\ProjectLeads\Schemas\ProjectLeadForm;
use App\Filament\Resources\ProjectLeads\Tables\ProjectLeadsTable;
use App\Models\ProjectLead;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class ProjectLeadResource extends Resource
{
    protected static ?string $model = ProjectLead::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Users;

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return ProjectLeadForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ProjectLeadsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListProjectLeads::route('/'),
            'create' => CreateProjectLead::route('/create'),
            'edit' => EditProjectLead::route('/{record}/edit'),
        ];
    }
}
