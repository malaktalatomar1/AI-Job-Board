<?php

namespace App\Filament\Resources\JobApplications\Tables;
use App\Filament\Resources\JobApplications\JobApplicationResource;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Actions\DeleteAction;

class JobApplicationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
        
        ->modifyQueryUsing(function ($query) {
            $query->where('status', '!=', 'Canceled');
        })
            ->columns([

                TextColumn::make('user.name')
                    ->label('Candidate')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('user.email')
                    ->label('Email')
                    ->searchable(),

                TextColumn::make('job.title')
                    ->label('Job')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Pending' => 'warning',
                        'Accepted' => 'success',
                        'Rejected' => 'danger',
                        default => 'gray',
                    }),

                TextColumn::make('created_at')
                    ->label('Applied At')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])

            ->filters([
                //
            ])

            ->recordUrl(
    fn ($record) => JobApplicationResource::getUrl('view', [
        'record' => $record,
    ])
)
->recordActions([
    EditAction::make(),
    DeleteAction::make(),
])

            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}