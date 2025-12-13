<?php

namespace App\Filament\Resources\ProjectLeads\Schemas;

use App\Models\Customer;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\DatePicker;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ProjectLeadForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Project Information')
                ->schema([
                    Select::make('customer_id')
                        ->label('Customer')
                        ->relationship('customer', 'name')
                        ->required(),
                    Select::make('service_id')
                        ->label('Service')
                        ->relationship('service', 'name')
                        ->required(),
                    TextInput::make('title')
                        ->label('Title')
                        ->required()
                        ->maxLength(255),
                    Textarea::make('description')
                        ->label('Description')
                        ->rows(3),
                    Select::make('status')
                        ->label('Status')
                        ->options([
                            'pending' => 'Pending',
                            'in_progress' => 'In Progress',
                            'completed' => 'Completed',
                            'cancelled' => 'Cancelled',
                        ])
                        ->default('pending')
                        ->required(),
                    TextInput::make('budget')
                        ->label('Budget')
                        ->numeric()
                        ->suffix('৳'),
                    DatePicker::make('start_date')
                        ->label('Start Date'),
                    DatePicker::make('end_date')
                        ->label('End Date'),
                    Toggle::make('is_active')
                        ->label('Is Active')
                        ->default(true),
                ])->columns(2),
            Section::make('Additional')
                ->schema([
                    Textarea::make('notes')
                        ->label('Notes')
                        ->rows(3),
                ])->columns(1),
        ])->columns(1);
    }
}
