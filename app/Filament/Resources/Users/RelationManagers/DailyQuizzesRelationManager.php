<?php

namespace App\Filament\Resources\Users\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;

class DailyQuizzesRelationManager extends RelationManager
{
    protected static string $relationship = 'dailyQuizzes';

    protected static ?string $title = 'Quiz History';

    protected static ?string $recordTitleAttribute = 'date';

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('date')
                    ->label('Date')
                    ->date('Y-m-d')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('created_at')
                    ->label('Completed At')
                    ->dateTime('Y-m-d H:i:s')
                    ->sortable(),
                TextColumn::make('score')
                    ->label('Score')
                    ->sortable()
                    ->alignCenter(),
                TextColumn::make('category')
                    ->label('Category')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'rendah' => 'success',
                        'sedang' => 'warning',
                        'berat' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'rendah' => 'Rendah (Low)',
                        'sedang' => 'Sedang (Medium)',
                        'berat' => 'Berat (High)',
                        default => $state,
                    })
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('category')
                    ->label('Category')
                    ->options([
                        'rendah' => 'Rendah (Low)',
                        'sedang' => 'Sedang (Medium)',
                        'berat' => 'Berat (High)',
                    ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->paginated([10, 25, 50]);
    }
}
