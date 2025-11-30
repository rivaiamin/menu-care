# Database Schema Reference (MySQL / Laravel)

## Tables

### 1. `users`

Standard Laravel User table with additional fields.

```php
Schema::create('users', function (Blueprint $table) {
    $table->id(); // BigInt Auto Increment
    $table->string('name');
    $table->string('email')->unique();
    $table->timestamp('email_verified_at')->nullable();
    $table->string('password');
    $table->string('role')->default('user'); // 'user' or 'admin'
    $table->string('phone_number')->nullable();
    $table->string('profile_photo_path')->nullable();
    $table->date('last_quiz_date')->nullable();
    $table->timestamp('last_quiz_timestamp')->nullable(); // For 24-hour validity check
    $table->rememberToken();
    $table->timestamps();
});
```

### 2. `daily_quizzes`

Stores the daily PSS-10 quiz results.

```php
Schema::create('daily_quizzes', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->date('date');
    $table->json('answers'); // Array of 10 answers: [0, 1, 2, ...]
    $table->integer('score'); // Range: 0-40
    $table->enum('category', ['rendah', 'sedang', 'berat']);
    $table->timestamps(); // created_at used for 24-hour validity check

    // Ensure one quiz per user per day (optional, if we strictly enforce 24h rule this might be redundant but good for data integrity)
    // $table->unique(['user_id', 'date']);
});
```

### 3. `journals`

Stores user journals.

```php
Schema::create('journals', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->date('date');
    $table->string('title')->nullable();
    $table->text('content');
    $table->integer('mood'); // 1-5
    $table->timestamps();
});
```

### 4. Content Tables (Filament Managed)

#### `articles`
```php
Schema::create('articles', function (Blueprint $table) {
    $table->id();
    $table->string('title');
    $table->text('content');
    $table->string('image_path')->nullable();
    $table->json('tags')->nullable();
    $table->enum('recommended_state', ['rendah', 'sedang', 'berat', 'semua']);
    $table->timestamps();
});
```

#### `videos`
```php
Schema::create('videos', function (Blueprint $table) {
    $table->id();
    $table->string('title');
    $table->text('description')->nullable();
    $table->string('video_url'); // YouTube or Local path
    $table->enum('recommended_state', ['rendah', 'sedang', 'berat', 'semua']);
    $table->timestamps();
});
```

#### `audios`
```php
Schema::create('audios', function (Blueprint $table) {
    $table->id();
    $table->string('title');
    $table->text('description')->nullable();
    $table->string('audio_path');
    $table->enum('recommended_state', ['rendah', 'sedang', 'berat', 'semua']);
    $table->timestamps();
});
```

## Relationships

- `User` has many `DailyQuiz`
- `User` has many `Journal`

## Notes

- **Timestamps**: Laravel manages `created_at` and `updated_at` automatically.
- **Soft Deletes**: Consider adding `$table->softDeletes()` if data retention is important.
- **JSON Fields**: MySQL 5.7+ supports JSON columns efficiently.

