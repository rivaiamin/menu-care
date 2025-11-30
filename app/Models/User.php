<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone_number',
        'profile_photo_path',
        'last_quiz_date',
        'last_quiz_timestamp',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'last_quiz_date' => 'date',
            'last_quiz_timestamp' => 'datetime',
        ];
    }

    /**
     * Get the daily quizzes for the user.
     */
    public function dailyQuizzes(): HasMany
    {
        return $this->hasMany(DailyQuiz::class);
    }

    /**
     * Get the latest valid quiz (within 24 hours).
     */
    public function latestValidQuiz(): ?DailyQuiz
    {
        return $this->dailyQuizzes()
            ->where('created_at', '>', now()->subHours(24))
            ->latest('created_at')
            ->first();
    }

    /**
     * Get the journals for the user.
     */
    public function journals(): HasMany
    {
        return $this->hasMany(Journal::class);
    }
}
