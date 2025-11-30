# **PRODUCT REQUIREMENT DOCUMENT (AI-OPTIMIZED FOR CURSOR)**

**Project:** Web Apps – Kesehatan Mental Tenaga Kesehatan
**Tech Stack:** Laravel 11, FilamentPHP 3, SvelteKit, MySQL
**Goal:** Build a mental-health tracking platform for medical workers with daily stress quiz, journaling, progress charts, and personalized mindfulness content. Admins monitor aggregated trends and manage content.

---

## **1. User Roles**

### **1. Medical Worker (User)**

* Must complete daily stress quiz before accessing other features.
* Writes daily journals.
* Views mental health progress graph.
* Accesses mindfulness content (article/audio/video) based on stress level.

### **2. Admin**

* Views dashboards of all users’ stress trends.
* Manages content (articles, videos, audios).
* Manages user accounts.
* Views user journal and quiz history.

---

## **2. Core Features (User)**

### **2.1 Authentication**

* Email/password login via Laravel Sanctum (API) / Session.
* Auto-logout after idle (configurable in Laravel config).

---

### **2.2 Daily Stress Quiz (PSS-10)**

* **Quiz Type:** Perceived Stress Scale (PSS-10) - 10 questions
* **Answer Scale:** Likert 0–4 (5 options: Tidak Pernah, Hampir Tidak Pernah, Kadang-Kadang, Cukup Sering, Sangat Sering)
* **Score Calculation:** Sum of all answers
* **Score Categories:**
  * 0–13 → Rendah (Low)
  * 14–26 → Sedang (Medium)
  * 27–40 → Berat (High)
* **24-Hour Validity Rule:**
  * Quiz is valid for 1x24 hours (24 hours from completion)
  * If user completed quiz within the last 24 hours → redirect to homepage (skip quiz)
  * If quiz not completed or expired → redirect to /quiz (block all other routes)

---

### **2.3 Quiz Result Flow & Recommendations**

After quiz completion, user sees assessment score result and recommendations:

* **Rendah (Score 0-13):**
  * Recommendations: Deep Breathing Relaxation, Read Mental Health Tips and Education
  * Redirect to /journal

* **Sedang (Score 14-26):**
  * Recommendations: Mindfulness (Meditation, Deep Breathing, Positive Affirmation), Read Mental Health Tips and Education, Consider Consulting a Professional
  * Redirect to /journal

* **Berat (Score 27-40):**
  * Recommendations: Mindfulness (Meditation, Deep Breathing, Positive Affirmation), Read Mental Health Tips and Education
  * **Warning:** If severe symptoms appear (severe sleep disorder, feeling unable to control oneself) → immediately seek professional help
  * Links to Halodoc or Alodokter for professional consultation
  * Redirect to /consultation

---

### **2.4 Journaling**

* Fields:
  * title: string | optional
  * content: text
  * mood: integer (1–5)
* Journaling required only once after quiz.

---

### **2.5 Homepage (Beranda)**

* Displays last assessment score result prominently
* Main navigation hub to access all features
* Shows user's current stress category status

---

### **2.6 Check Progress (Cek Progres)**

* Separate feature/page for viewing progress statistics
* Displays daily stress statistics per date
* Shows trend over time (daily/date-based)
* Data visualization: charts/graphs showing stress score progression
* X-axis: dates
* Y-axis: score/category

---

### **2.7 Profile Page**

Contains:

#### **Personal Data (Data Diri Pengguna)**
* Full Name (Nama Lengkap)
* Edit Profile Photo
* Phone Number (No Telepon)

#### **Account Settings (Pengaturan Akun)**
* Change Password (Ganti Password)
* Change Email (Ganti Email)

#### **Logout**
* Log out functionality

#### **History** (Optional - can be in separate section)
* Quiz history
* Journal history

---

### **2.8 Mindfulness Features**

Main mindfulness section with three core features:

#### **2.8.1 Short Meditation (Meditasi Singkat)**
* Meditation content/audio
* **Video:** Short Meditation Video (Vidio Meditasi Singkat)

#### **2.8.2 Deep Breathing Relaxation (Relaksasi Nafas Dalam)**
* Breathing exercise content/audio
* **Video:** Deep Breathing Relaxation Video (Vidio Relaksasi Nafas Dalam)

#### **2.8.3 Positive Affirmation (Afirmasi Positif)**
* Positive affirmation content/audio
* **Video:** Positive Affirmation Video (Vidio Afirmasi Positif)

#### **2.8.4 Tips and Mental Health Education (Tips Dan Edukasi Mental Health)**
* Articles on how to overcome stress (Artikel Artikel Cara Mengatasi Stres)
* Educational content about mental health
* Content stored in Laravel Database (managed via Filament)
* Filtered by user stress category and admin-defined tags

---

### **2.9 Daily Journal (Jurnal Harian)**

* User/Nurse notes (Catatan Pengguna / Perawat)
* Fields:
  * title: string | optional
  * content: text
  * mood: integer (1–5)
* Journaling required after quiz (except when quiz result = berat, which redirects to consultation)

---

## **3. Admin Features**

### **3.1 Dashboard (FilamentPHP)**

* Total active users today
* Average stress score today
* Distribution of stress categories (ringan/sedang/berat)
* Trend chart (last 7 / 30 days)

---

### **3.2 User Management**

* CRUD users (via FilamentPHP Resource)
* View quiz history
* View journal history

---

### **3.3 Content Management (FilamentPHP)**

Collections (Resources):

* `Articles`
* `Videos`
* `Audios`
  Fields include:
* title
* content/body
* media file (optional)
* tags
* recommended_state: ringan | sedang | berat | semua

---

## **4. Database Schema (MySQL)**

### **users**

* id (bigint/uuid)
* email
* name
* phone_number (text, optional)
* profile_photo_path (text, optional)
* role (user | admin)
* last_quiz_date
* last_quiz_timestamp (timestamp, for 24-hour validity check)
* created_at
* updated_at

### **daily_quizzes**

* id
* user_id
* date
* answers (json) - Array of 10 answers
* score (int) - Range: 0-40
* category (rendah | sedang | berat)
* created_at (timestamp)

### **journals**

* id
* user_id
* date
* title
* content
* mood (int)
* created_at
* updated_at

---

## **5. Technical Architecture**

* **Backend:** Laravel 11 (API + Admin Panel)
* **Frontend:** SvelteKit (Client-side rendering or SSR consuming Laravel API)
* **Admin Panel:** FilamentPHP 3 (Livewire-based, runs within Laravel)
* **Database:** MySQL 8
* **Authentication:** Laravel Sanctum (SPA Auth or Token)
* **Middleware:**
  * Check if user has completed quiz within last 24 hours
  * If quiz completed within 24 hours → allow access to homepage
  * If quiz not completed or expired → redirect to /quiz (block all other routes)

---

## **6. Non-Functional Requirements**

* Data encryption (Laravel default).
* Auto logout (session lifetime).
* High performance (optimized queries).
* Responsive UI for mobile nurses/doctors.

---

## **7. KPIs**

* Daily Active Users
* Daily Quiz Completion Rate
* Stress Score Trend (downward = success)
* Mindfulness Content Engagement
