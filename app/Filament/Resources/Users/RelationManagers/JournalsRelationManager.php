<?php

namespace App\Filament\Resources\Users\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;

class JournalsRelationManager extends RelationManager
{
    protected static string $relationship = 'journals';

    protected static ?string $title = 'Journal History';

    protected static ?string $recordTitleAttribute = 'title';

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
                    ->label('Created At')
                    ->dateTime('Y-m-d H:i:s')
                    ->sortable(),
                TextColumn::make('title')
                    ->label('Title')
                    ->searchable()
                    ->placeholder('(No title)')
                    ->limit(50),
                TextColumn::make('content')
                    ->label('Content')
                    ->limit(100)
                    ->wrap(),
                TextColumn::make('mood')
                    ->label('Mood')
                    ->badge()
                    ->color(fn (int $state): string => match ($state) {
                        1 => 'danger',
                        2 => 'warning',
                        3 => 'gray',
                        4 => 'info',
                        5 => 'success',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (int $state): string => match ($state) {
                        1 => '😢 Very Sad',
                        2 => '😞 Sad',
                        3 => '😐 Neutral',
                        4 => '🙂 Happy',
                        5 => '😊 Very Happy',
                        default => 'Unknown',
                    })
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('mood')
                    ->label('Mood')
                    ->options([
                        1 => '😢 Very Sad',
                        2 => '😞 Sad',
                        3 => '😐 Neutral',
                        4 => '🙂 Happy',
                        5 => '😊 Very Happy',
                    ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->paginated([10, 25, 50]);
    }
}
