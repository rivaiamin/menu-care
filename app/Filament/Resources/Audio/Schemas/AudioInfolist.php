<?php

namespace App\Filament\Resources\Audio\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class AudioInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('title'),
                TextEntry::make('description')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('audio_path')
                    ->label('Audio File')
                    ->placeholder('-'),
                TextEntry::make('recommended_state')
                    ->badge(),
                TextEntry::make('category')
                    ->badge(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
