<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Hash;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),
                DateTimePicker::make('email_verified_at')
                    ->label('Email Verified At')
                    ->displayFormat('Y-m-d H:i:s')
                    ->placeholder('Not verified'),
                TextInput::make('password')
                    ->label('Password')
                    ->password()
                    ->dehydrateStateUsing(fn ($state) => filled($state) ? Hash::make($state) : null)
                    ->dehydrated(fn ($state) => filled($state))
                    ->required(fn (string $operation): bool => $operation === 'create')
                    ->minLength(8)
                    ->helperText('Leave blank to keep current password when editing')
                    ->revealable(),
                Select::make('role')
                    ->label('Role')
                    ->options([
                        'user' => 'User (Medical Worker)',
                        'admin' => 'Admin',
                    ])
                    ->required()
                    ->default('user')
                    ->native(false)
                    ->searchable(false),
                TextInput::make('phone_number')
                    ->label('Phone Number')
                    ->tel()
                    ->maxLength(255)
                    ->placeholder('+62...'),
                FileUpload::make('profile_photo_path')
                    ->label('Profile Photo')
                    ->image()
                    ->directory('profile-photos')
                    ->disk('public')
                    ->visibility('public')
                    ->imageEditor()
                    ->imageEditorAspectRatios([
                        null,
                        '16:9',
                        '4:3',
                        '1:1',
                    ])
                    ->maxSize(2048)
                    ->helperText('Maximum file size: 2MB'),
                DatePicker::make('last_quiz_date')
                    ->label('Last Quiz Date')
                    ->displayFormat('Y-m-d')
                    ->placeholder('Never'),
                DateTimePicker::make('last_quiz_timestamp')
                    ->label('Last Quiz Timestamp')
                    ->displayFormat('Y-m-d H:i:s')
                    ->placeholder('Never'),
            ]);
    }
}
