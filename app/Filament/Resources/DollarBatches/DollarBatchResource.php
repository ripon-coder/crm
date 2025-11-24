<?php

namespace App\Filament\Resources\DollarBatches;

use App\Filament\Resources\DollarBatches\Pages\CreateDollarBatch;
use App\Filament\Resources\DollarBatches\Pages\EditDollarBatch;
use App\Filament\Resources\DollarBatches\Pages\ListDollarBatches;
use App\Filament\Resources\DollarBatches\Schemas\DollarBatchForm;
use App\Filament\Resources\DollarBatches\Tables\DollarBatchesTable;
use App\Models\DollarBatch;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class DollarBatchResource extends Resource
{
    protected static ?string $model = DollarBatch::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::ArchiveBox;
    protected static UnitEnum|string|null $navigationGroup = 'Dollar-Sales';
    protected static ?int $navigationSort = 2;

    protected static ?string $recordTitleAttribute = 'id';

    public static function form(Schema $schema): Schema
    {
        return DollarBatchForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DollarBatchesTable::configure($table);
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
            'index' => ListDollarBatches::route('/'),
            'create' => CreateDollarBatch::route('/create'),
            'edit' => EditDollarBatch::route('/{record}/edit'),
        ];
    }
}
