<?php

namespace App\Filament\Resources\Articles\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class ArticleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required(),
                Textarea::make('content')
                    ->required()
                    ->columnSpanFull(),
                FileUpload::make('image_path')
                    ->image()
                    ->directory('media/articles')
                    ->disk('public')
                    ->visibility('public'),
                TextInput::make('tags')
                    ->helperText('Comma-separated tags (for future use)'),
                Select::make('recommended_state')
                    ->options(['rendah' => 'Rendah', 'sedang' => 'Sedang', 'berat' => 'Berat', 'semua' => 'Semua'])
                    ->required(),
            ]);
    }
}
