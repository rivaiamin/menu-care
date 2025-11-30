<?php

namespace App\Filament\Resources\Videos\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class VideoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required(),
                Textarea::make('description')
                    ->columnSpanFull(),
                TextInput::make('video_url')
                    ->url()
                    ->required(),
                Select::make('recommended_state')
                    ->options(['rendah' => 'Rendah', 'sedang' => 'Sedang', 'berat' => 'Berat', 'semua' => 'Semua'])
                    ->required(),
            ]);
    }
}
