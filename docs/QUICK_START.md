# Quick Start Guide (Laravel + SvelteKit)

## Prerequisites

- PHP 8.2+
- Composer
- Node.js & NPM
- MySQL 8.0+

## Step 1: Backend Setup (Laravel)

1. **Create Project**
   ```bash
   composer create-project laravel/laravel menu-care
   cd menu-care
   ```

2. **Setup Database**
   - Create a MySQL database named `menu_care` (or whatever you prefer).
   - Copy `.env.example` to `.env`.
   - Update `.env` with your database credentials:
     ```env
     DB_CONNECTION=mysql
     DB_HOST=127.0.0.1
     DB_PORT=3306
     DB_DATABASE=menu_care
     DB_USERNAME=root
     DB_PASSWORD=
     ```

3. **Install FilamentPHP (Admin Panel)**
   ```bash
   composer require filament/filament:"^3.2" -W
   php artisan filament:install-panel
   ```

4. **Install API Scaffolding**
   ```bash
   php artisan install:api
   ```

5. **Run Migrations**
   ```bash
   php artisan migrate
   ```

6. **Create Admin User**
   ```bash
   php artisan make:filament-user
   ```

## Step 2: Frontend Setup (SvelteKit)

1. **Create SvelteKit Project**
   ```bash
   npm create svelte@latest client
   cd client
   npm install
   ```
   *Select "Skeleton project" and "TypeScript" when prompted.*

2. **Install TailwindCSS**
   Follow the official SvelteKit guide for TailwindCSS or use:
   ```bash
   npx svelte-add@latest tailwindcss
   npm install
   ```

3. **Configure API Proxy (Optional but recommended for dev)**
   Update `vite.config.ts` to proxy API requests to Laravel:
   ```typescript
   server: {
       proxy: {
           '/api': 'http://127.0.0.1:8000',
           '/sanctum': 'http://127.0.0.1:8000',
       }
   }
   ```

## Step 3: Running the Application

1. **Start Laravel Server**
   ```bash
   # Terminal 1 (Root)
   php artisan serve
   ```

2. **Start SvelteKit Dev Server**
   ```bash
   # Terminal 2 (client/)
   npm run dev
   ```

3. **Access the App**
   - Frontend: `http://localhost:5173`
   - Admin Panel: `http://localhost:8000/admin`
   - API: `http://localhost:8000/api`

## Step 4: Verification

- Login to the Admin Panel using the user created in Step 1.6.
- Check that the SvelteKit welcome page loads.

