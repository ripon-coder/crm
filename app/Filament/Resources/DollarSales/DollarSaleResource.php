<?php

namespace App\Filament\Resources\DollarSales;

use App\Filament\Resources\DollarSales\Pages\CreateDollarSale;
use App\Filament\Resources\DollarSales\Pages\EditDollarSale;
use App\Filament\Resources\DollarSales\Pages\ListDollarSales;
use App\Filament\Resources\DollarSales\Schemas\DollarSaleForm;
use App\Filament\Resources\DollarSales\Tables\DollarSalesTable;
use App\Models\DollarSale;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class DollarSaleResource extends Resource
{
    protected static ?string $model = DollarSale::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::CurrencyDollar;
    protected static UnitEnum|string|null $navigationGroup = 'Dollar-Sales';
    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'id';

    public static function form(Schema $schema): Schema
    {
        return DollarSaleForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DollarSalesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\PaymentsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListDollarSales::route('/'),
            'create' => CreateDollarSale::route('/create'),
            'edit' => EditDollarSale::route('/{record}/edit'),
        ];
    }
}
