<?php

namespace Database\Seeders;

use App\Models\Article;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $articles = [
            // Articles for "rendah" (low stress) state
            [
                'title' => 'Tips Menjaga Keseimbangan Hidup untuk Tenaga Kesehatan',
                'content' => 'Sebagai tenaga kesehatan, menjaga keseimbangan antara pekerjaan dan kehidupan pribadi sangat penting. Berikut beberapa tips yang dapat membantu:

1. **Atur Prioritas**: Buat daftar prioritas harian dan fokus pada tugas yang paling penting terlebih dahulu.

2. **Istirahat yang Cukup**: Pastikan Anda mendapatkan tidur 7-8 jam setiap malam untuk memulihkan energi.

3. **Olahraga Rutin**: Lakukan aktivitas fisik ringan seperti jalan kaki atau yoga minimal 30 menit per hari.

4. **Hobi dan Waktu Pribadi**: Luangkan waktu untuk melakukan aktivitas yang Anda sukai di luar pekerjaan.

5. **Komunikasi dengan Keluarga**: Jaga komunikasi yang baik dengan keluarga dan teman dekat untuk mendapatkan dukungan emosional.

6. **Makan Sehat**: Konsumsi makanan bergizi seimbang dan hindari melewatkan waktu makan.

7. **Batasi Waktu Kerja**: Hindari bekerja berlebihan dan belajar untuk mengatakan "tidak" ketika beban kerja terlalu berat.

Ingatlah bahwa menjaga kesehatan diri sendiri adalah investasi terbaik untuk dapat memberikan pelayanan terbaik kepada pasien.',
                'image_path' => null,
                'tags' => ['keseimbangan hidup', 'work-life balance', 'tips kesehatan'],
                'recommended_state' => 'rendah',
            ],
            [
                'title' => 'Pentingnya Self-Care bagi Tenaga Medis',
                'content' => 'Self-care bukanlah kemewahan, melainkan kebutuhan penting bagi setiap tenaga kesehatan. Berikut mengapa self-care sangat penting:

**Mengapa Self-Care Penting?**

1. **Mencegah Burnout**: Rutinitas kerja yang padat dapat menyebabkan kelelahan fisik dan mental. Self-care membantu mencegah burnout.

2. **Meningkatkan Kualitas Pelayanan**: Ketika Anda merasa baik secara fisik dan mental, Anda dapat memberikan pelayanan yang lebih baik kepada pasien.

3. **Meningkatkan Produktivitas**: Istirahat yang cukup dan aktivitas yang menyenangkan dapat meningkatkan fokus dan produktivitas kerja.

4. **Menjaga Kesehatan Mental**: Self-care membantu menjaga kesehatan mental dan mencegah stres berkepanjangan.

**Cara Menerapkan Self-Care:**

- Luangkan waktu 15-30 menit setiap hari untuk diri sendiri
- Lakukan aktivitas yang membuat Anda rileks dan bahagia
- Jangan merasa bersalah karena mengambil waktu untuk diri sendiri
- Ingat bahwa merawat diri sendiri bukanlah egois, melainkan kebutuhan

Mulailah dengan langkah kecil dan konsisten dalam menjalankannya.',
                'image_path' => null,
                'tags' => ['self-care', 'burnout prevention', 'kesehatan mental'],
                'recommended_state' => 'rendah',
            ],

            // Articles for "sedang" (medium stress) state
            [
                'title' => 'Teknik Mengelola Stres di Tempat Kerja untuk Tenaga Kesehatan',
                'content' => 'Stres di tempat kerja adalah hal yang wajar, terutama dalam profesi kesehatan. Berikut teknik-teknik yang dapat membantu mengelola stres:

**Teknik Pernapasan Dalam (Deep Breathing)**
- Tarik napas dalam melalui hidung selama 4 hitungan
- Tahan napas selama 4 hitungan
- Buang napas perlahan melalui mulut selama 6 hitungan
- Ulangi 5-10 kali

**Teknik Grounding (5-4-3-2-1)**
Ketika merasa overwhelmed, gunakan teknik ini:
- 5 hal yang bisa Anda lihat
- 4 hal yang bisa Anda sentuh
- 3 hal yang bisa Anda dengar
- 2 hal yang bisa Anda cium
- 1 hal yang bisa Anda rasakan

**Manajemen Waktu**
- Gunakan teknik Pomodoro (25 menit kerja, 5 menit istirahat)
- Buat daftar tugas dan prioritaskan
- Delegasikan tugas jika memungkinkan

**Komunikasi Asertif**
- Ekspresikan kebutuhan dan perasaan dengan jelas
- Belajar mengatakan "tidak" dengan sopan
- Minta bantuan ketika merasa kewalahan

**Istirahat Mikro**
- Ambil istirahat singkat setiap 1-2 jam
- Lakukan peregangan ringan
- Minum air putih yang cukup

Ingatlah bahwa mengelola stres adalah keterampilan yang dapat dipelajari dan ditingkatkan dengan latihan.',
                'image_path' => null,
                'tags' => ['manajemen stres', 'teknik relaksasi', 'stres kerja'],
                'recommended_state' => 'sedang',
            ],
            [
                'title' => 'Mindfulness untuk Tenaga Kesehatan: Panduan Praktis',
                'content' => 'Mindfulness adalah praktik kesadaran penuh yang dapat membantu tenaga kesehatan mengelola stres dan meningkatkan kesejahteraan mental. Berikut panduan praktisnya:

**Apa itu Mindfulness?**
Mindfulness adalah kemampuan untuk hadir sepenuhnya pada momen saat ini, tanpa menghakimi atau terdistraksi oleh pikiran tentang masa lalu atau masa depan.

**Manfaat Mindfulness untuk Tenaga Kesehatan:**
- Mengurangi stres dan kecemasan
- Meningkatkan fokus dan konsentrasi
- Meningkatkan empati dan komunikasi dengan pasien
- Mencegah burnout
- Meningkatkan kualitas tidur

**Latihan Mindfulness Sederhana:**

**1. Mindful Breathing (5 menit)**
- Duduk atau berbaring dengan nyaman
- Fokus pada napas Anda
- Perhatikan sensasi udara masuk dan keluar
- Jika pikiran mengembara, kembalikan fokus ke napas

**2. Body Scan (10 menit)**
- Mulai dari jari kaki, perhatikan setiap bagian tubuh
- Rasakan sensasi di setiap bagian
- Lepaskan ketegangan yang Anda rasakan
- Lanjutkan hingga ke kepala

**3. Mindful Eating**
- Makan dengan perlahan dan penuh perhatian
- Perhatikan tekstur, rasa, dan aroma makanan
- Kunyah dengan baik sebelum menelan

**4. Mindful Walking**
- Berjalan dengan perlahan dan sadar
- Perhatikan setiap langkah
- Rasakan kontak kaki dengan tanah
- Perhatikan lingkungan sekitar

**Tips Memulai:**
- Mulai dengan 5 menit per hari
- Pilih waktu yang konsisten
- Gunakan aplikasi atau panduan audio jika perlu
- Bersabarlah dengan diri sendiri

Latihan mindfulness adalah perjalanan, bukan tujuan. Setiap sesi adalah kesempatan untuk berlatih.',
                'image_path' => null,
                'tags' => ['mindfulness', 'meditasi', 'kesadaran penuh'],
                'recommended_state' => 'sedang',
            ],
            [
                'title' => 'Kapan Harus Mencari Bantuan Profesional untuk Stres',
                'content' => 'Meskipun stres adalah bagian normal dari kehidupan, ada saat-saat ketika mencari bantuan profesional menjadi penting. Berikut tanda-tandanya:

**Tanda-Tanda Perlu Bantuan Profesional:**

1. **Stres Berlangsung Lama**: Jika stres berlangsung lebih dari 2 minggu dan mengganggu aktivitas sehari-hari

2. **Gejala Fisik Berkelanjutan**:
   - Sakit kepala atau migrain yang sering
   - Masalah pencernaan
   - Nyeri otot atau ketegangan
   - Masalah tidur yang persisten

3. **Perubahan Perilaku Signifikan**:
   - Menarik diri dari aktivitas sosial
   - Perubahan pola makan (makan berlebihan atau kehilangan nafsu makan)
   - Peningkatan konsumsi alkohol atau zat lain
   - Perubahan mood yang drastis

4. **Kesulitan Fungsi Sehari-hari**:
   - Kesulitan berkonsentrasi di tempat kerja
   - Menurunnya kualitas pelayanan kepada pasien
   - Kesulitan membuat keputusan
   - Kesulitan mengingat hal-hal penting

5. **Gejala Emosional Intens**:
   - Perasaan putus asa atau tidak berdaya
   - Kecemasan berlebihan
   - Mudah marah atau tersinggung
   - Perasaan bersalah yang berlebihan

**Sumber Bantuan Profesional:**

- **Psikolog Klinis**: Untuk konseling dan terapi psikologis
- **Psikiater**: Untuk evaluasi medis dan pengobatan jika diperlukan
- **Konselor**: Untuk dukungan emosional dan strategi coping
- **Layanan Telemedicine**: Halodoc, Alodokter untuk konsultasi online

**Jangan Ragu untuk Mencari Bantuan:**
Mencari bantuan profesional adalah tanda kekuatan, bukan kelemahan. Sebagai tenaga kesehatan yang merawat orang lain, penting juga untuk merawat diri sendiri.',
                'image_path' => null,
                'tags' => ['bantuan profesional', 'konseling', 'kesehatan mental'],
                'recommended_state' => 'sedang',
            ],

            // Articles for "berat" (high stress) state
            [
                'title' => 'Mengatasi Stres Berat: Langkah-Langkah Segera yang Dapat Dilakukan',
                'content' => 'Ketika mengalami stres berat, penting untuk mengambil langkah-langkah segera untuk mengelola situasi. Berikut panduan yang dapat membantu:

**Langkah-Langkah Segera:**

**1. Cari Tempat Tenang**
- Pindah ke tempat yang tenang dan nyaman
- Jika memungkinkan, ambil waktu istirahat sejenak
- Beri diri Anda ruang untuk bernapas

**2. Teknik Pernapasan Darurat**
- Tarik napas dalam selama 4 hitungan
- Tahan selama 4 hitungan
- Buang napas perlahan selama 8 hitungan
- Ulangi hingga merasa lebih tenang

**3. Grounding Technique**
- Sentuh benda di sekitar Anda dan rasakan teksturnya
- Sebutkan 5 hal yang bisa Anda lihat
- Sebutkan 4 hal yang bisa Anda dengar
- Sebutkan 3 hal yang bisa Anda rasakan

**4. Minum Air Putih**
- Dehidrasi dapat memperburuk gejala stres
- Minum air putih secara perlahan
- Hindari kafein atau alkohol

**5. Hubungi Dukungan**
- Hubungi teman, keluarga, atau kolega yang dapat dipercaya
- Jangan ragu untuk meminta bantuan
- Bicarakan perasaan Anda

**6. Pertimbangkan Bantuan Profesional**
Jika gejala berat atau berlangsung lama, pertimbangkan untuk mencari bantuan profesional melalui:
- Halodoc: Konsultasi psikolog online
- Alodokter: Layanan kesehatan mental
- Layanan kesehatan mental di rumah sakit

**Peringatan:**
Jika Anda mengalami gejala berikut, segera cari bantuan medis:
- Pikiran untuk menyakiti diri sendiri atau orang lain
- Serangan panik yang parah
- Kesulitan bernapas
- Nyeri dada

Ingatlah bahwa Anda tidak sendirian dan bantuan tersedia.',
                'image_path' => null,
                'tags' => ['stres berat', 'krisis', 'bantuan darurat'],
                'recommended_state' => 'berat',
            ],
            [
                'title' => 'Pentingnya Istirahat dan Pemulihan untuk Tenaga Kesehatan',
                'content' => 'Istirahat yang cukup adalah komponen penting dalam mengelola stres berat. Sebagai tenaga kesehatan, Anda mungkin merasa sulit untuk mengambil waktu istirahat, tetapi ini sangat penting untuk kesehatan Anda.

**Mengapa Istirahat Penting:**

1. **Pemulihan Fisik**: Tubuh membutuhkan waktu untuk memulihkan energi yang terkuras
2. **Pemulihan Mental**: Otak membutuhkan istirahat untuk memproses informasi dan emosi
3. **Pencegahan Burnout**: Istirahat yang cukup mencegah kelelahan kronis
4. **Kualitas Pelayanan**: Istirahat yang cukup meningkatkan kualitas pelayanan kepada pasien

**Jenis-Jenis Istirahat:**

**Istirahat Fisik:**
- Tidur 7-9 jam per malam
- Istirahat singkat setiap 1-2 jam kerja
- Liburan atau cuti berkala

**Istirahat Mental:**
- Meditasi atau mindfulness
- Membaca buku non-medis
- Menonton film atau acara hiburan
- Melakukan hobi yang menyenangkan

**Istirahat Emosional:**
- Menghabiskan waktu dengan orang terdekat
- Menulis jurnal untuk mengekspresikan perasaan
- Terapi atau konseling
- Aktivitas yang membawa kegembiraan

**Istirahat Sosial:**
- Menghabiskan waktu dengan teman dan keluarga
- Bergabung dengan komunitas atau kelompok dukungan
- Menghindari situasi yang membuat stres secara sosial

**Tips Mengambil Istirahat:**

- Rencanakan waktu istirahat di jadwal Anda
- Komunikasikan kebutuhan istirahat dengan supervisor
- Gunakan cuti yang tersedia
- Jangan merasa bersalah karena beristirahat
- Ingat bahwa istirahat adalah investasi untuk kesehatan jangka panjang

Jika Anda merasa kesulitan untuk beristirahat atau mengalami gejala burnout yang parah, pertimbangkan untuk mencari bantuan profesional melalui Halodoc atau Alodokter.',
                'image_path' => null,
                'tags' => ['istirahat', 'pemulihan', 'burnout prevention'],
                'recommended_state' => 'berat',
            ],

            // Articles for "semua" (all states)
            [
                'title' => 'Memahami Stres dan Dampaknya pada Tenaga Kesehatan',
                'content' => 'Stres adalah respons alami tubuh terhadap tuntutan atau tekanan. Sebagai tenaga kesehatan, memahami stres dan dampaknya adalah langkah pertama dalam mengelolanya.

**Apa itu Stres?**
Stres adalah respons fisik dan emosional terhadap situasi yang menantang atau menuntut. Stres dapat bersifat akut (jangka pendek) atau kronis (jangka panjang).

**Jenis-Jenis Stres:**

**Stres Akut:**
- Terjadi dalam waktu singkat
- Contoh: Menangani situasi darurat, menghadapi pasien yang sulit
- Biasanya hilang setelah situasi berlalu

**Stres Kronis:**
- Berlangsung dalam waktu lama
- Contoh: Beban kerja yang terus-menerus tinggi, konflik di tempat kerja
- Dapat menyebabkan masalah kesehatan jika tidak dikelola

**Dampak Stres pada Tenaga Kesehatan:**

**Dampak Fisik:**
- Kelelahan
- Sakit kepala
- Masalah pencernaan
- Masalah tidur
- Sistem kekebalan tubuh menurun

**Dampak Emosional:**
- Kecemasan
- Depresi
- Mudah marah
- Perasaan kewalahan
- Perasaan tidak berdaya

**Dampak pada Pekerjaan:**
- Menurunnya kualitas pelayanan
- Kesalahan medis potensial
- Konflik dengan kolega
- Burnout
- Turnover yang tinggi

**Faktor-Faktor Stres di Lingkungan Kesehatan:**

- Beban kerja yang tinggi
- Jam kerja yang panjang
- Menangani situasi darurat
- Menghadapi kematian pasien
- Konflik dengan pasien atau keluarga
- Tekanan administratif
- Kurangnya dukungan

**Mengapa Penting untuk Mengelola Stres:**

1. **Kesehatan Pribadi**: Mengelola stres penting untuk kesehatan fisik dan mental Anda
2. **Kualitas Pelayanan**: Stres yang tidak dikelola dapat mempengaruhi kualitas pelayanan kepada pasien
3. **Hubungan**: Stres dapat mempengaruhi hubungan dengan keluarga, teman, dan kolega
4. **Kepuasan Kerja**: Mengelola stres dapat meningkatkan kepuasan kerja dan mencegah burnout

**Langkah Selanjutnya:**
Pelajari teknik-teknik mengelola stres yang sesuai dengan situasi Anda. Ingatlah bahwa mengelola stres adalah proses yang berkelanjutan, bukan tujuan akhir.',
                'image_path' => null,
                'tags' => ['stres', 'kesehatan mental', 'tenaga kesehatan'],
                'recommended_state' => 'semua',
            ],
            [
                'title' => 'Membangun Resilience: Kekuatan Mental untuk Tenaga Kesehatan',
                'content' => 'Resilience adalah kemampuan untuk bangkit kembali dari kesulitan dan beradaptasi dengan perubahan. Sebagai tenaga kesehatan, membangun resilience sangat penting untuk menghadapi tantangan pekerjaan.

**Apa itu Resilience?**
Resilience bukan berarti tidak pernah mengalami kesulitan atau stres, melainkan kemampuan untuk pulih dan belajar dari pengalaman sulit tersebut.

**Mengapa Resilience Penting untuk Tenaga Kesehatan:**

1. **Menghadapi Tekanan**: Pekerjaan di bidang kesehatan penuh dengan tekanan dan tantangan
2. **Adaptasi**: Resilience membantu beradaptasi dengan perubahan dan situasi baru
3. **Pemulihan**: Membantu pulih lebih cepat dari pengalaman sulit
4. **Kesejahteraan**: Resilience berkontribusi pada kesejahteraan mental jangka panjang

**Cara Membangun Resilience:**

**1. Kembangkan Mindset Positif**
- Fokus pada hal-hal yang dapat Anda kontrol
- Lihat tantangan sebagai kesempatan untuk belajar
- Praktikkan rasa syukur

**2. Bangun Koneksi Sosial**
- Pertahankan hubungan dengan keluarga dan teman
- Bergabung dengan komunitas atau kelompok dukungan
- Cari mentor atau kolega yang dapat diandalkan

**3. Rawat Diri Sendiri**
- Prioritaskan kesehatan fisik dan mental
- Lakukan aktivitas yang menyenangkan
- Pastikan istirahat yang cukup

**4. Kembangkan Keterampilan Coping**
- Pelajari teknik relaksasi
- Praktikkan mindfulness atau meditasi
- Kembangkan hobi yang membantu melepas stres

**5. Tetapkan Tujuan yang Realistis**
- Buat tujuan yang dapat dicapai
- Pecah tujuan besar menjadi langkah-langkah kecil
- Rayakan pencapaian kecil

**6. Belajar dari Pengalaman**
- Refleksikan pengalaman sulit dan pelajaran yang didapat
- Identifikasi kekuatan dan area yang perlu ditingkatkan
- Gunakan pengalaman untuk tumbuh

**7. Cari Bantuan Ketika Diperlukan**
- Jangan ragu untuk mencari bantuan profesional
- Manfaatkan sumber daya yang tersedia
- Ingat bahwa meminta bantuan adalah tanda kekuatan

**Membangun Resilience adalah Perjalanan:**
Resilience tidak dibangun dalam semalam. Ini adalah proses yang membutuhkan waktu dan latihan. Mulailah dengan langkah kecil dan konsisten dalam menjalankannya.

Ingatlah bahwa setiap tenaga kesehatan memiliki kekuatan dan kemampuan untuk membangun resilience. Anda tidak sendirian dalam perjalanan ini.',
                'image_path' => null,
                'tags' => ['resilience', 'kekuatan mental', 'adaptasi'],
                'recommended_state' => 'semua',
            ],
        ];

        foreach ($articles as $article) {
            Article::create($article);
        }
    }
}
