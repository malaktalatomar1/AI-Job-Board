<?php

namespace App\Filament\Resources\Jobs\Schemas;

use App\Models\Category;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class JobForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                TextInput::make('title')
                    ->label('Job Title')
                    ->required()
                    ->maxLength(255),

                Textarea::make('description')
                    ->rows(5)
                    ->required(),

                Textarea::make('required_skills')
                    ->label('Required Skills')
                    ->rows(3)
                    ->required(),

                Select::make('category_id')
                    ->label('Category')
                    ->relationship('category', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),

                TextInput::make('location')
                    ->required(),

                Select::make('work_type')
                    ->options([
                        'Remote' => 'Remote',
                        'On-site' => 'On-site',
                        'Hybrid' => 'Hybrid',
                    ])
                    ->required(),

                TextInput::make('salary')
                    ->numeric()
                    ->required(),

                DatePicker::make('application_deadline')
                    ->required(),

            ]);
    }
}