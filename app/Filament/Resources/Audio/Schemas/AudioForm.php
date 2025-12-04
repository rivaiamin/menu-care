<?php

namespace App\Filament\Resources\Audio\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class AudioForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required(),
                Textarea::make('description')
                    ->columnSpanFull(),
                FileUpload::make('audio_path')
                    ->acceptedFileTypes(['audio/mpeg', 'audio/mp3', 'audio/wav', 'audio/ogg'])
                    ->directory('media/audios')
                    ->disk('public')
                    ->visibility('public')
                    ->required(),
                Select::make('recommended_state')
                    ->options(['rendah' => 'Rendah', 'sedang' => 'Sedang', 'berat' => 'Berat', 'semua' => 'Semua'])
                    ->required(),
                Select::make('category')
                    ->options(['meditasi' => 'Meditasi', 'relaksasi' => 'Relaksasi', 'afirmasi' => 'Afirmasi'])
                    ->required(),
            ]);
    }
}
