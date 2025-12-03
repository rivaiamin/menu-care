# Database Migrations

## Overview

This project uses **Laravel migrations** to manage the database schema. All migrations are located in `database/migrations/` directory.

**Database:** MySQL 8.0+  
**Framework:** Laravel 12  
**ORM:** Eloquent

## Migration Files

The migrations are executed in chronological order based on their timestamp prefix:

### Core Laravel Migrations
- `0001_01_01_000000_create_users_table.php` - Base Laravel users table
- `0001_01_01_000001_create_cache_table.php` - Cache table for Laravel cache driver
- `0001_01_01_000002_create_jobs_table.php` - Queue jobs table

### MeNu Care Application Migrations
- `2025_11_30_070539_add_menu_care_fields_to_users_table.php` - Adds role, phone_number, profile_photo_path, last_quiz_date, last_quiz_timestamp to users table
- `2025_11_30_070540_create_daily_quizzes_table.php` - Creates daily_quizzes table for PSS-10 quiz results
- `2025_11_30_070540_create_journals_table.php` - Creates journals table for user journal entries
- `2025_11_30_070541_create_articles_table.php` - Creates articles table for mindfulness content
- `2025_11_30_070542_create_audios_table.php` - Creates audios table for audio content
- `2025_11_30_070542_create_videos_table.php` - Creates videos table for video content

## How to Run Migrations

### Prerequisites

1. **Database Setup**
   - Create a MySQL database (e.g., `menu_care`)
   - Configure database credentials in `.env` file:
     ```env
     DB_CONNECTION=mysql
     DB_HOST=127.0.0.1
     DB_PORT=3306
     DB_DATABASE=menu_care
     DB_USERNAME=root
     DB_PASSWORD=your_password
     ```

2. **Environment Configuration**
   - Ensure `.env` file exists (copy from `.env.example` if needed)
   - Generate application key: `php artisan key:generate`

### Running Migrations

#### Fresh Installation (First Time Setup)

Run all migrations from scratch:

```bash
php artisan migrate
```

This will create all tables in the correct order.

#### Fresh Migration (Reset Database)

⚠️ **Warning:** This will drop all tables and re-run migrations. **All data will be lost.**

```bash
php artisan migrate:fresh
```

#### Fresh Migration with Seeding

Reset database and seed with default data:

```bash
php artisan migrate:fresh --seed
```

#### Rollback Migrations

Rollback the last batch of migrations:

```bash
php artisan migrate:rollback
```

Rollback all migrations:

```bash
php artisan migrate:reset
```

#### Refresh Migrations

Rollback and re-run all migrations (keeps data if possible):

```bash
php artisan migrate:refresh
```

#### Check Migration Status

View which migrations have been run:

```bash
php artisan migrate:status
```

## Database Schema Reference

For detailed schema information, see [`DATABASE_SCHEMA.md`](../DATABASE_SCHEMA.md).

### Tables Created

After running migrations, the following tables will be created:

1. **users** - User accounts (extended with MeNu Care fields)
2. **daily_quizzes** - Daily PSS-10 stress assessment results
3. **journals** - User journal entries
4. **articles** - Mindfulness articles (managed via FilamentPHP)
5. **videos** - Mindfulness videos (managed via FilamentPHP)
6. **audios** - Mindfulness audio content (managed via FilamentPHP)
7. **cache** - Laravel cache table
8. **jobs** - Laravel queue jobs table
9. **sessions** - Laravel session table (if using database sessions)

## Verification

After running migrations, verify the tables were created:

### Using Laravel Tinker

```bash
php artisan tinker
```

Then run:

```php
DB::select('SHOW TABLES');
// or
Schema::hasTable('users');
Schema::hasTable('daily_quizzes');
Schema::hasTable('journals');
```

### Using MySQL CLI

```bash
mysql -u root -p menu_care
```

```sql
SHOW TABLES;
```

Expected output should include:
- `users`
- `daily_quizzes`
- `journals`
- `articles`
- `videos`
- `audios`
- `cache`
- `jobs`
- `sessions` (if using database sessions)

### Check Table Structure

```sql
DESCRIBE daily_quizzes;
DESCRIBE journals;
DESCRIBE users;
```

## Troubleshooting

### Error: "SQLSTATE[HY000] [1045] Access denied"

**Solution:**
- Check your `.env` database credentials
- Verify MySQL user has proper permissions
- Ensure MySQL service is running: `sudo systemctl status mysql`

### Error: "SQLSTATE[42S01] Base table or view already exists"

**Solution:**
- Tables already exist. Use `migrate:status` to check migration state
- If you need to reset: `php artisan migrate:fresh` (⚠️ **WARNING:** Deletes all data)
- Or manually drop tables if needed

### Error: "SQLSTATE[42000] Syntax error"

**Solution:**
- Ensure MySQL version is 8.0 or higher
- Check for MySQL-specific syntax issues
- Verify JSON column support: `SELECT JSON_TYPE('{"test": 1}');`

### Error: "Class not found" or Migration file errors

**Solution:**
- Clear Laravel cache: `php artisan config:clear && php artisan cache:clear`
- Run composer autoload: `composer dump-autoload`
- Verify migration files are in `database/migrations/` directory

### Migration Stuck or Hanging

**Solution:**
- Check MySQL connection: `php artisan db:show`
- Verify database exists: `SHOW DATABASES;`
- Check MySQL error logs
- Ensure no other processes are locking tables

### Foreign Key Constraint Errors

**Solution:**
- Ensure migrations run in correct order (Laravel handles this automatically)
- Check that referenced tables exist before creating foreign keys
- Verify `onDelete('cascade')` behavior matches your requirements

## Creating New Migrations

To create a new migration:

```bash
php artisan make:migration create_example_table
```

Or for modifying an existing table:

```bash
php artisan make:migration add_column_to_example_table --table=example
```

Migration files will be created in `database/migrations/` with a timestamp prefix.

## Migration Best Practices

1. **Always test migrations** on a development database first
2. **Use transactions** where possible (Laravel wraps migrations in transactions automatically)
3. **Write reversible migrations** - implement both `up()` and `down()` methods
4. **Don't modify existing migrations** - create new migrations for changes
5. **Use descriptive names** - migration names should clearly indicate their purpose
6. **Document complex logic** - add comments for non-obvious schema changes

## Related Documentation

- [`DATABASE_SCHEMA.md`](../DATABASE_SCHEMA.md) - Complete database schema reference
- [`PRD.md`](../PRD.md) - Product requirements and business rules
- [`QUIZ_PSS10.md`](../QUIZ_PSS10.md) - PSS-10 quiz implementation details
- [`QUICK_START.md`](../QUICK_START.md) - Quick setup guide

## Notes

- **Timezone Handling:** The `daily_quizzes.created_at` timestamp is critical for the 24-hour validity check. Ensure `APP_TIMEZONE` is configured correctly in `.env`.
- **Session Driver:** If using database sessions, the `sessions` table will be created automatically when you run `php artisan session:table` and then `php artisan migrate`.
- **FilamentPHP:** Content tables (`articles`, `videos`, `audios`) are managed via FilamentPHP admin panel, but migrations must be run first.
