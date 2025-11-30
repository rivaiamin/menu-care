# Implementation Plan - Mindful Nakes (Laravel + Svelte)

## 📊 Project Status

**Current Phase:** Phase 0 Complete → Moving to Phase 2 (Daily Quiz Feature)

**Tech Stack:**
- ✅ Laravel 12 + Inertia.js + Svelte 5 (via [oseughu/svelte-starter-kit](https://github.com/oseughu/svelte-starter-kit))
- ✅ TypeScript + TailwindCSS + shadcn-svelte
- ✅ FilamentPHP 4 (Admin Panel) - Installed
- ⏳ MySQL Database - Migrations created, needs to be run

**What's Done:**
- ✅ Laravel 12 with Svelte 5 starter kit installed
- ✅ Full authentication system (login, register, password reset, email verification)
- ✅ Inertia.js SPA architecture
- ✅ Component library (shadcn-svelte) ready

**Next Steps:**
1. Configure `.env` for database connection
2. Create database migrations (users, daily_quizzes, journals, content tables)
3. Implement PSS-10 quiz feature with 24-hour validation
4. Install FilamentPHP for admin panel

---

## Pre-Development Setup Checklist

### Phase 0: Foundation & Environment Setup ✅ COMPLETED

> **Note:** Project initialized using `laravel new menu-care --using=oseughu/svelte-starter-kit`
> This starter kit includes: Laravel 12, Svelte 5, Inertia.js, TypeScript, TailwindCSS, shadcn-svelte

#### 1. **Laravel Setup (Backend)** ✅
- [x] Install Laravel 12 with svelte-starter-kit
- [x] Session-based authentication (Inertia.js SPA)
- [x] Authentication scaffolding included
- [x] Configure `.env` (Database connection - **NEXT STEP**)
- [x] Set up CORS if needed (already configured for Inertia)
- [x] Configure `APP_TIMEZONE` environment variable for user timezone

#### 2. **FilamentPHP Setup (Admin)** ⏳
- [x] Install Filament: `composer require filament/filament:"^4.0" -W`
- [x] Install Panel: `php artisan filament:install --panels`
- [x] Create Admin User: `php artisan make:filament-user`

#### 3. **Frontend Setup** ✅
- [x] Svelte 5 + TypeScript configured
- [x] Inertia.js integration complete
- [x] TailwindCSS + shadcn-svelte components ready
- [x] Hot reloading with Vite
- [x] SSR support available

#### 4. **Database Migration Setup** ✅ COMPLETED
- [x] Update `users` migration - Add `role`, `phone_number`, `profile_photo_path`, `last_quiz_date`, `last_quiz_timestamp`
- [x] Create `daily_quizzes` migration
- [x] Create `journals` migration
- [x] Create `articles`, `videos`, `audios` migrations (for content)
- [x] ✅ Verified: All migrations match DATABASE_SCHEMA.md
- [x] Run migrations: `php artisan migrate` (Ready to run)

---
## Phase 1: Authentication & Core Infrastructure ✅ MOSTLY COMPLETE

### 1.1 Backend (Laravel) ✅
- [x] Session-based authentication (Inertia.js SPA)
- [x] Auth Controllers implemented (Login, Register, Logout, Password Reset, Email Verification)
- [x] Auth Routes configured (`routes/auth.php`)
- [x] **TODO:** Implement `EnsureQuizCompleted` Middleware (24-hour check, allow `/profile` and `/logout`) ✅

### 1.2 Frontend (Svelte) ✅
- [x] Auth pages implemented (`/login`, `/register`, `/forgot-password`, `/reset-password`)
- [x] Protected routes with middleware
- [x] Session persistence via Inertia.js
- [x] Email verification flow

---

## Phase 2: Daily Quiz Feature (Week 2)

### 2.1 Backend (Laravel) ✅ COMPLETED
- [x] Create `DailyQuiz` Model
- [x] Create `QuizController`
- [x] Implement `show` method (Display quiz page)
- [x] Implement `store` method (Calculate score, determine category, reverse scoring)
- [x] Implement `result` method (Show quiz result with recommendations)
- [x] Implement `status` method (Check if valid quiz exists)
- [x] Create `QuizRequest` for validation
- [x] Implement 24-hour validity check logic (in middleware)
- [x] Route: `GET /quiz` (Show quiz page)
- [x] Route: `POST /quiz` (Submit quiz)
- [x] Route: `GET /quiz/result` (Show result page)
- [x] Route: `GET /api/quiz/status` (Check if valid quiz exists)

### 2.2 Frontend (Svelte) ✅ COMPLETED
- [x] Create `/quiz` page (`resources/js/pages/quiz/Quiz.svelte`)
- [x] Build Quiz Form (PSS-10 Questions with RadioGroup)
- [x] Implement Progress Bar (shows completion progress)
- [x] Implement Score Calculation Display (Result Page with Recommendations)
- [x] Display recommendations based on category
- [x] Show warning and consultation links for "berat" category
- [x] Redirect logic: All categories → Homepage (BERANDA) via button

---

## Phase 3: Journaling Feature (Week 2-3)

### 3.1 Backend (Laravel) ✅ COMPLETED
- [x] Create `Journal` Model
- [x] Create `JournalController` (full CRUD: index, create, store, show, edit, update, destroy)
- [x] Create `JournalRequest` for validation
- [x] Add `journals()` relationship to User model
- [x] Routes: Resource routes for journals (`/journals`)
- [x] Mood options constant (1-5 scale with labels and emojis)

### 3.2 Frontend (Svelte) ✅ COMPLETED
- [x] Create `/journals` Index page (`resources/js/pages/journal/Index.svelte`)
- [x] Create `/journals/create` Create page (`resources/js/pages/journal/Create.svelte`)
- [x] Create `/journals/{id}` Show page (`resources/js/pages/journal/Show.svelte`)
- [x] Create `/journals/{id}/edit` Edit page (`resources/js/pages/journal/Edit.svelte`)
- [x] Build Journal Form (Title optional, Content required, Mood 1-5) with RadioGroup
- [x] Display Journal History with pagination
- [x] Mood selection with emojis (😢 😞 😐 🙂 😊)
- [x] Delete confirmation dialog
- [x] Date formatting (Indonesian locale)

---

## Phase 4: Homepage & Progress Tracking (Week 3)

### 4.1 Backend (Laravel)
- [x] Create `DashboardController` for user stats
- [x] API Endpoint: `GET /api/progress` (History of quiz scores)

### 4.2 Frontend (Svelte)
- [x] Create Homepage (`/` or `/dashboard`) - BERANDA
- [x] Display last assessment score result prominently
- [x] Show user's current stress category status
- [x] Create `/progress` page (Cek Progres)
- [x] Integrate Chart.js or similar for:
  - [x] Stress score progression (line chart)
  - [x] Category distribution (bar/pie chart)

---

## Phase 5: Mindfulness Features (Week 4) ✅ COMPLETED

### 5.1 Backend (FilamentPHP) ✅
- [x] Create Filament Resources:
    - `ArticleResource`
    - `VideoResource`
    - `AudioResource`
- [x] Configure File Uploads (Local storage: `storage/app/public`)
- [x] API Endpoints: `GET /api/content/{type}` (Filter by `recommended_state` only)
- [x] Create Consultation static page

### 5.2 Frontend (Svelte) ✅
- [x] Create `/mindfulness` hub (Fitur Fitur → Mindfullnes)
- [x] Create sub-pages: `/meditation`, `/breathing`, `/affirmation`
- [x] Create `/articles` page for tips and education
- [x] Create `/consultation` static page (describes condition and recommended steps)
- [x] Fetch and display content from API (filtered by `recommended_state`)

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

