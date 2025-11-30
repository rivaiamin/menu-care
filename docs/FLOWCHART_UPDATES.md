# Flowchart-Based Documentation Updates

## Overview

This document summarizes the updates made to the documentation based on the client's flowchart for the MeNu Care application.

**Date:** Based on client flowchart review
**Status:** Documentation updated for Laravel/SvelteKit stack

---

## Key Changes from Previous Documentation

### 1. Quiz System Change

**Previous:** Zung Self Anxiety Rating Scale (20 questions, 1-4 scale)
**Updated:** Perceived Stress Scale PSS-10 (10 questions, 1-5 scale)

**Impact:**
- Quiz questions reduced from 20 to 10
- Answer scale changed from 1-4 to 1-5
- Scoring range changed from 20-80 to 0-40
- Category labels updated: `ringan` → `rendah`, categories now: `rendah`, `sedang`, `berat`

### 2. Score Ranges Updated

**Previous:**
- 0-13: Ringan
- 14-20: Sedang
- 21+: Berat

**Updated (from flowchart):**
- 0-13: Rendah (Low)
- 14-26: Sedang (Medium)
- 27-40: Berat (High)

### 3. Quiz Validity Rule Changed

**Previous:** Daily quiz (once per day, based on date)
**Updated:** 24-hour validity window (quiz valid for 1x24 hours from completion time)

**Implementation:**
- Check `created_at` timestamp instead of just date
- If quiz completed within last 24 hours → allow homepage access
- If quiz expired or not completed → redirect to `/quiz`

### 4. New Features Added

#### 4.1 Homepage (Beranda)
- **New feature** - Main landing page after login
- Displays last assessment score result prominently
- Shows user's current stress category status
- Navigation hub to all features

#### 4.2 Check Progress (Cek Progres)
- **Separate feature** - Not just in profile
- Displays daily stress statistics per date
- Shows trend over time with charts/graphs
- Dedicated `/app/progress` page

#### 4.3 Enhanced Profile Page
- **Personal Data Section:**
  - Full Name (Nama Lengkap)
  - Edit Profile Photo
  - Phone Number (No Telepon)
- **Account Settings:**
  - Change Password (Ganti Password)
  - Change Email (Ganti Email)
- Logout functionality

#### 4.4 Structured Mindfulness Features
- **Short Meditation (Meditasi Singkat)** + Video
- **Deep Breathing Relaxation (Relaksasi Nafas Dalam)** + Video
- **Positive Affirmation (Afirmasi Positif)** + Video
- **Tips and Mental Health Education** (Articles)

### 5. Quiz Result Flow (Updated from Flowchart)

**Key Finding:** All quiz result categories redirect to **Homepage (BERANDA)**, not directly to journal or consultation pages.

**Rendah (0-13):**
- Show recommendations: Deep Breathing Relaxation, Read Mental Health Tips and Education
- **Redirect to Homepage (BERANDA)**

**Sedang (14-26):**
- Show recommendations: Mindfulness (Meditation, Deep Breathing, Positive Affirmation), Read Mental Health Tips and Education, Consider Consulting a Professional
- **Redirect to Homepage (BERANDA)**

**Berat (27-40):**
- Show recommendations: Mindfulness (Meditation, Deep Breathing, Positive Affirmation), Read Mental Health Tips and Education
- **Warning:** If severe symptoms appear (severe sleep disorder, feeling unable to control oneself) → immediately seek professional help
- Show links to Halodoc or Alodokter
- **Redirect to Homepage (BERANDA)**

### 6. Database Schema Updates

**users table:**
- Added `phone_number` (String, optional)
- Added `profile_photo_path` (String, optional) - stored in local storage
- Added `last_quiz_date` (Date, optional)
- Added `last_quiz_timestamp` (Timestamp) for 24-hour validity check (uses user timezone)

**daily_quizzes table:**
- Updated `answers` to be array of 10 items (was 20)
- Updated `score` range: 0-40 (was different)
- Updated `category` values: `rendah`, `sedang`, `berat` (was `ringan`, `sedang`, `berat`)
- `created_at` timestamp now critical for 24-hour validity check (uses user timezone)

### 7. Additional Clarifications (Latest Updates)

**Authentication:**
- Using Laravel Session-based authentication (Inertia.js SPA), not Sanctum API tokens
- Session lifetime: 120 minutes (configurable)

**Timezone:**
- 24-hour validity check uses user's timezone (configured via `APP_TIMEZONE` env variable)

**Middleware:**
- Quiz validation middleware allows exceptions: `/profile` and `/logout` routes accessible even if quiz expired

**Content Filtering:**
- Content (articles, videos, audios) filtered by `recommended_state` enum only (not tags)
- Tags field exists but not used for filtering currently

**File Storage:**
- Profile photos and media files stored in local storage (`storage/app/public`)

**Journaling:**
- Journaling is **optional** and accessed from Features menu
- Not required after quiz completion

**Progress Page:**
- Shows both: stress score progression (line chart) and category distribution (bar/pie chart)

**Consultation Page:**
- Static page describing user condition and recommended steps
- Contains links to Halodoc and Alodokter
- Accessible from Features menu or recommended for "Berat" category

---

## Files Updated

1. ✅ `PRD.md` - Updated with all flowchart requirements and new stack
2. ✅ `QUIZ_PSS10.md` - Created new PSS-10 documentation (replaces QUIZ_ZUNG.md)
3. ✅ `DATABASE_SCHEMA.md` - Updated schema for MySQL/Laravel
4. ✅ `IMPLEMENTATION_PLAN.md` - Updated phases for Laravel/SvelteKit
5. ✅ `QUICK_START.md` - Updated setup guide for Laravel/SvelteKit

---

## Action Items for Implementation

### Critical (Before Development) ✅ CONFIRMED
1. ✅ **PSS-10 questions in Indonesian** - Confirmed (see QUIZ_PSS10.md)
2. ✅ **Reverse scoring logic** - Confirmed (questions 4, 5, 7, 8 use `4 - answer`)
3. ✅ **Scoring calculation** - Confirmed (0-4 scale, sum after reverse scoring = 0-40 range)
4. ✅ **Authentication method** - Confirmed (Session-based, Inertia.js)
5. ✅ **Timezone** - Confirmed (User timezone via `APP_TIMEZONE` env)
6. ✅ **File storage** - Confirmed (Local storage)
7. ✅ **Content filtering** - Confirmed (`recommended_state` only)
8. ✅ **Middleware exceptions** - Confirmed (allow `/profile`, `/logout`)
9. ✅ **Progress charts** - Confirmed (both score progression and category distribution)
10. ✅ **Journaling** - Confirmed (Optional)

### High Priority
1. Update User model `$fillable` array with new fields
2. Implement `EnsureQuizCompleted` middleware (24-hour check with exceptions)
3. Create homepage (`/` or `/dashboard`) - BERANDA component
4. Create progress page (`/progress`) component with dual charts
5. Update profile page with new sections
6. Create consultation static page

### Medium Priority
7. Create mindfulness feature pages (meditation, breathing, affirmation)
8. Implement recommendations display in quiz result page
9. Add profile photo upload functionality (local storage)
10. Add phone number field to user registration/profile
11. Create quiz controller and models

### Low Priority
12. Update existing quiz data if any exists
13. Migration script for existing data (if applicable)

---

## Notes

- The old `QUIZ_ZUNG.md` file is now superseded by `QUIZ_PSS10.md`
- All documentation now aligns with the client flowchart and new tech stack
- Implementation should follow the updated PRD and implementation plan

---

## Implementation Notes

### Flowchart Analysis Summary

Based on the flowchart review, key findings:

1. **All quiz results redirect to BERANDA (Homepage)** - not directly to journal or consultation
2. **Journaling is optional** - accessed from Features menu, not forced after quiz
3. **Consultation page** - Static page with condition description and recommended steps, accessible from Features menu
4. **Homepage displays last assessment score** prominently
5. **Features menu structure:**
   - Mindfullnes (Meditasi Singkat, Relaksasi Nafas Dalam, Afirmasi Positif)
   - Jurnal Harian (Daily Journal)
   - Tips Dan Edukasi Mental Health (Articles)

### Technical Decisions Confirmed

- ✅ Authentication: Laravel Session-based (Inertia.js SPA)
- ✅ Timezone: User timezone via `APP_TIMEZONE` environment variable
- ✅ File Storage: Local storage (`storage/app/public`)
- ✅ Content Filtering: `recommended_state` enum only
- ✅ Middleware: Allow `/profile` and `/logout` even if quiz expired
- ✅ Progress Charts: Both score progression and category distribution
- ✅ Journaling: Optional feature

