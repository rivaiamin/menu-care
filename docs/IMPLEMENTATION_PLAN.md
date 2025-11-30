# Implementation Plan - Mindful Nakes (Laravel + SvelteKit)

## Pre-Development Setup Checklist

### Phase 0: Foundation & Environment Setup

#### 1. **Laravel Setup (Backend)**
- [ ] Install Laravel 11: `composer create-project laravel/laravel menu-care`
- [ ] Configure `.env` (MySQL database connection)
- [ ] Install API scaffolding: `php artisan install:api`
- [ ] Set up CORS configuration (`config/cors.php`) to allow SvelteKit frontend

#### 2. **FilamentPHP Setup (Admin)**
- [ ] Install Filament: `composer require filament/filament:"^3.2"`
- [ ] Install Panel: `php artisan filament:install-panel`
- [ ] Create Admin User: `php artisan make:filament-user`

#### 3. **SvelteKit Setup (Frontend)**
- [ ] Create SvelteKit project: `npm create svelte@latest client`
- [ ] Install dependencies: `npm install`
- [ ] Configure TailwindCSS
- [ ] Setup Axios or Fetch wrapper for API requests

#### 4. **Database Migration Setup**
- [ ] Create `users` migration (default Laravel) - Add `role`, `phone_number`, `profile_photo_path`
- [ ] Create `daily_quizzes` migration
- [ ] Create `journals` migration
- [ ] Create `articles`, `videos`, `audios` migrations (for content)

---

## Phase 1: Authentication & Core Infrastructure (Week 1)

### 1.1 Backend (Laravel)
- [ ] Configure Laravel Sanctum for SPA Authentication (or Token based)
- [ ] Create `AuthController` (Login, Register, Logout, User)
- [ ] Create API Routes (`routes/api.php`)
- [ ] Implement `EnsureQuizCompleted` Middleware (24-hour check)

### 1.2 Frontend (SvelteKit)
- [ ] Create Auth Store (Svelte Store / Context)
- [ ] Create `/login` page
- [ ] Create `/register` page
- [ ] Implement Protected Routes (Hooks/Layouts)
- [ ] Handle Session/Token persistence

---

## Phase 2: Daily Quiz Feature (Week 2)

### 2.1 Backend (Laravel)
- [ ] Create `DailyQuiz` Model
- [ ] Create `QuizController`
- [ ] Implement `store` method (Calculate score, determine category)
- [ ] Implement 24-hour validity check logic
- [ ] API Endpoint: `POST /api/quiz`
- [ ] API Endpoint: `GET /api/quiz/status` (Check if valid quiz exists)

### 2.2 Frontend (SvelteKit)
- [ ] Create `/quiz` page
- [ ] Build Quiz Form (PSS-10 Questions)
- [ ] Implement Score Calculation Display (Result Page)
- [ ] Redirect logic based on result (Low/Med -> Journal, High -> Consultation)

---

## Phase 3: Journaling Feature (Week 2-3)

### 3.1 Backend (Laravel)
- [ ] Create `Journal` Model
- [ ] Create `JournalController`
- [ ] API Endpoints: `GET /api/journals`, `POST /api/journals`

### 3.2 Frontend (SvelteKit)
- [ ] Create `/journal` page
- [ ] Build Journal Form (Title, Content, Mood)
- [ ] Display Journal History

---

## Phase 4: Homepage & Progress Tracking (Week 3)

### 4.1 Backend (Laravel)
- [ ] Create `DashboardController` for user stats
- [ ] API Endpoint: `GET /api/progress` (History of quiz scores)

### 4.2 Frontend (SvelteKit)
- [ ] Create Homepage (`/`)
- [ ] Display current status (Stress Level)
- [ ] Create `/progress` page
- [ ] Integrate Chart.js or similar for Stress Trend Graph

---

## Phase 5: Mindfulness Features (Week 4)

### 5.1 Backend (FilamentPHP)
- [ ] Create Filament Resources:
    - `ArticleResource`
    - `VideoResource`
    - `AudioResource`
- [ ] Configure File Uploads (Local or S3)
- [ ] API Endpoints: `GET /api/content/{type}` (Filter by category)

### 5.2 Frontend (SvelteKit)
- [ ] Create `/mindfulness` hub
- [ ] Create sub-pages: `/meditation`, `/breathing`, `/affirmation`
- [ ] Fetch and display content from API

---

## Phase 6: Admin Dashboard (Week 5)

### 6.1 FilamentPHP Dashboard
- [ ] Create Dashboard Widgets:
    - Total Users
    - Average Stress Score
    - Category Distribution (Chart)
- [ ] Customize User Resource (View Quiz/Journal History)

---

## Phase 7: Polish & Optimization (Week 6)

### 7.1 Testing & Deployment
- [ ] PHPUnit Tests (Backend)
- [ ] Playwright Tests (Frontend)
- [ ] Deploy Laravel (VPS/Forge/Serverless)
- [ ] Deploy SvelteKit (Node Adapter or Static)

---

## Database Schema (MySQL)

### `users`
- `id` (BigInt/UUID)
- `name`
- `email`
- `password`
- `role` (enum: user, admin)
- `last_quiz_at` (timestamp)

### `daily_quizzes`
- `id`
- `user_id` (FK)
- `answers` (JSON)
- `score` (Int)
- `category` (String)
- `created_at`

### `journals`
- `id`
- `user_id` (FK)
- `title`
- `content`
- `mood` (Int)
- `created_at`

### `content` (Polymorphic or Separate Tables)
- `title`, `body`, `media_path`, `type`, `recommended_category`

