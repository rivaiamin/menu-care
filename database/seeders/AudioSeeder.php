<?php

namespace Database\Seeders;

use App\Models\Audio;
use Illuminate\Database\Seeder;

class AudioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $audios = [
            // Audios for "rendah" (low stress) state - Light relaxation
            [
                'title' => 'Suara Alam - Hujan dan Burung untuk Relaksasi',
                'description' => 'Audio suara alam yang menenangkan: hujan rintik-rintik dan kicauan burung. Cocok untuk relaksasi ringan dan membantu meningkatkan fokus saat bekerja.',
                'audio_path' => 'https://archive.org/download/testmp3testfile/mpthreetest.mp3',
                'recommended_state' => 'rendah',
                'category' => 'relaksasi',
            ],
            [
                'title' => 'Musik Instrumental Tenang - Piano dan Flute',
                'description' => 'Musik instrumental yang menenangkan dengan kombinasi piano dan flute. Ideal untuk mendengarkan saat istirahat atau sebelum tidur.',
                'audio_path' => 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-1.mp3',
                'recommended_state' => 'rendah',
                'category' => 'relaksasi',
            ],

            // Audios for "sedang" (medium stress) state - Meditation and breathing guides
            [
                'title' => 'Panduan Meditasi 15 Menit - Bahasa Indonesia',
                'description' => 'Audio panduan meditasi 15 menit dalam Bahasa Indonesia. Cocok untuk pemula yang ingin memulai praktik meditasi untuk mengelola stres sedang.',
                'audio_path' => 'https://archive.org/download/testmp3testfile/mpthreetest.mp3',
                'recommended_state' => 'sedang',
                'category' => 'meditasi',
            ],
            [
                'title' => 'Body Scan Meditation - Relaksasi Tubuh Lengkap',
                'description' => 'Audio panduan body scan meditation yang membantu merilekskan seluruh tubuh. Efektif untuk mengurangi ketegangan fisik dan mental akibat stres.',
                'audio_path' => 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-2.mp3',
                'recommended_state' => 'sedang',
                'category' => 'meditasi',
            ],
            [
                'title' => 'Teknik Pernapasan Terpandu - Box Breathing',
                'description' => 'Audio panduan teknik box breathing (pernapasan kotak) yang efektif untuk mengelola stres. Ikuti instruksi untuk hasil optimal.',
                'audio_path' => 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-3.mp3',
                'recommended_state' => 'sedang',
                'category' => 'relaksasi',
            ],
            [
                'title' => 'Afirmasi Positif untuk Tenaga Kesehatan',
                'description' => 'Audio afirmasi positif yang dirancang khusus untuk tenaga kesehatan. Dengarkan secara rutin untuk membangun pikiran positif dan meningkatkan kepercayaan diri.',
                'audio_path' => 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-4.mp3',
                'recommended_state' => 'sedang',
                'category' => 'afirmasi',
            ],
            [
                'title' => 'Mindfulness Meditation - Kesadaran Penuh',
                'description' => 'Audio panduan mindfulness meditation yang membantu mengembangkan kesadaran penuh. Praktikkan untuk meningkatkan kemampuan mengelola stres dan emosi.',
                'audio_path' => 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-5.mp3',
                'recommended_state' => 'sedang',
                'category' => 'meditasi',
            ],

            // Audios for "berat" (high stress) state - Intensive relaxation
            [
                'title' => 'Meditasi Darurat untuk Stres Berat',
                'description' => 'Audio meditasi singkat yang dirancang untuk situasi stres berat. Dapat membantu menenangkan pikiran dan tubuh dalam waktu singkat. Gunakan ketika merasa overwhelmed.',
                'audio_path' => 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-6.mp3',
                'recommended_state' => 'berat',
                'category' => 'meditasi',
            ],
            [
                'title' => 'Teknik Grounding Terpandu - 5-4-3-2-1',
                'description' => 'Audio panduan teknik grounding 5-4-3-2-1 yang efektif untuk mengatasi kecemasan dan stres berat. Ikuti instruksi untuk mengembalikan fokus ke momen saat ini.',
                'audio_path' => 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-7.mp3',
                'recommended_state' => 'berat',
                'category' => 'relaksasi',
            ],
            [
                'title' => 'Relaksasi Otot Progresif Lengkap',
                'description' => 'Audio panduan relaksasi otot progresif yang dapat membantu mengurangi ketegangan fisik dan mental akibat stres berat. Praktikkan secara rutin untuk hasil optimal.',
                'audio_path' => 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-8.mp3',
                'recommended_state' => 'berat',
                'category' => 'relaksasi',
            ],
            [
                'title' => 'Self-Compassion Meditation - Kasih Sayang untuk Diri Sendiri',
                'description' => 'Audio meditasi kasih sayang yang membantu mengembangkan self-compassion. Penting untuk tenaga kesehatan yang sering mengkritik diri sendiri atau merasa tidak cukup baik.',
                'audio_path' => 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-9.mp3',
                'recommended_state' => 'berat',
                'category' => 'meditasi',
            ],
            [
                'title' => 'Suara Binaural Beats untuk Relaksasi Dalam',
                'description' => 'Audio binaural beats yang dirancang untuk membantu mencapai relaksasi dalam dan mengurangi stres berat. Gunakan dengan headphone untuk hasil optimal.',
                'audio_path' => 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-10.mp3',
                'recommended_state' => 'berat',
                'category' => 'relaksasi',
            ],

            // Audios for "semua" (all states) - General content
            [
                'title' => 'White Noise untuk Fokus dan Relaksasi',
                'description' => 'Audio white noise yang dapat membantu meningkatkan fokus dan relaksasi. Cocok untuk didengarkan saat bekerja atau sebelum tidur.',
                'audio_path' => 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-11.mp3',
                'recommended_state' => 'semua',
                'category' => 'relaksasi',
            ],
            [
                'title' => 'Musik Meditasi - Suara Om dan Singing Bowl',
                'description' => 'Musik meditasi dengan suara Om dan singing bowl yang menenangkan. Cocok untuk berbagai tingkat stres dan dapat digunakan untuk meditasi atau relaksasi.',
                'audio_path' => 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-12.mp3',
                'recommended_state' => 'semua',
                'category' => 'meditasi',
            ],
            [
                'title' => 'Suara Ombak Laut untuk Relaksasi',
                'description' => 'Audio suara ombak laut yang menenangkan. Membantu menciptakan suasana relaksasi dan ketenangan. Cocok untuk meditasi atau istirahat.',
                'audio_path' => 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-13.mp3',
                'recommended_state' => 'semua',
                'category' => 'relaksasi',
            ],
            [
                'title' => 'Panduan Pernapasan Terpandu - Berbagai Teknik',
                'description' => 'Audio panduan berbagai teknik pernapasan yang dapat dilakukan untuk mengelola stres. Cocok untuk semua tingkat stres dan mudah dipraktikkan.',
                'audio_path' => 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-14.mp3',
                'recommended_state' => 'semua',
                'category' => 'relaksasi',
            ],
        ];

        foreach ($audios as $audio) {
            Audio::create($audio);
        }
    }
}
