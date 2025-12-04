<?php

namespace Database\Seeders;

use App\Models\Video;
use Illuminate\Database\Seeder;

class VideoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $videos = [
            // Videos for "rendah" (low stress) state - Deep Breathing Relaxation
            [
                'title' => 'Relaksasi Nafas Dalam - Teknik Pernapasan 4-7-8',
                'description' => 'Video panduan teknik pernapasan dalam 4-7-8 yang dapat membantu mengurangi stres ringan dan meningkatkan relaksasi. Teknik ini mudah dipraktikkan dan dapat dilakukan kapan saja.',
                'video_url' => 'https://www.youtube.com/watch?v=gz4G31LGyog',
                'recommended_state' => 'rendah',
                'category' => 'relaksasi',
            ],
            [
                'title' => 'Pernapasan Perut untuk Relaksasi',
                'description' => 'Pelajari teknik pernapasan perut yang efektif untuk mengurangi ketegangan dan meningkatkan rasa tenang. Cocok untuk dipraktikkan sebelum atau setelah shift kerja.',
                'video_url' => 'https://www.youtube.com/watch?v=tybOi4hjZFQ',
                'recommended_state' => 'rendah',
                'category' => 'relaksasi',
            ],

            // Videos for "sedang" (medium stress) state - Meditation, Deep Breathing, Positive Affirmation
            [
                'title' => 'Meditasi Singkat 10 Menit untuk Tenaga Kesehatan',
                'description' => 'Meditasi singkat yang dirancang khusus untuk tenaga kesehatan. Membantu mengurangi stres, meningkatkan fokus, dan memberikan ketenangan mental. Durasi 10 menit, cocok untuk istirahat singkat.',
                'video_url' => 'https://www.youtube.com/watch?v=inpok4MKVLM',
                'recommended_state' => 'sedang',
                'category' => 'meditasi',
            ],
            [
                'title' => 'Meditasi Mindfulness untuk Mengelola Stres',
                'description' => 'Panduan meditasi mindfulness yang dapat membantu mengelola stres di tempat kerja. Praktikkan teknik kesadaran penuh untuk meningkatkan kesejahteraan mental.',
                'video_url' => 'https://www.youtube.com/watch?v=ZToicYcHIOU',
                'recommended_state' => 'sedang',
                'category' => 'meditasi',
            ],
            [
                'title' => 'Relaksasi Nafas Dalam - Teknik Box Breathing',
                'description' => 'Teknik box breathing (pernapasan kotak) yang efektif untuk mengelola stres sedang. Teknik ini digunakan oleh banyak profesional untuk meningkatkan fokus dan ketenangan.',
                'video_url' => 'https://www.youtube.com/watch?v=tEmt1Znux58',
                'recommended_state' => 'sedang',
                'category' => 'relaksasi',
            ],
            [
                'title' => 'Afirmasi Positif untuk Tenaga Kesehatan',
                'description' => 'Video afirmasi positif yang dirancang khusus untuk tenaga kesehatan. Membantu membangun pikiran positif, meningkatkan kepercayaan diri, dan mengatasi perasaan negatif.',
                'video_url' => 'https://www.youtube.com/watch?v=JEoxV_MryaE',
                'recommended_state' => 'sedang',
                'category' => 'afirmasi',
            ],
            [
                'title' => 'Body Scan Meditation - Relaksasi Tubuh Lengkap',
                'description' => 'Meditasi body scan yang membantu merilekskan seluruh tubuh dan mengurangi ketegangan fisik akibat stres. Cocok untuk dilakukan setelah shift kerja yang panjang.',
                'video_url' => 'https://www.youtube.com/watch?v=ihwcw_ofuME',
                'recommended_state' => 'sedang',
                'category' => 'meditasi',
            ],

            // Videos for "berat" (high stress) state - Intensive relaxation and coping
            [
                'title' => 'Meditasi Darurat untuk Mengatasi Stres Berat',
                'description' => 'Meditasi singkat yang dirancang untuk situasi stres berat. Dapat membantu menenangkan pikiran dan tubuh dalam waktu singkat. Gunakan ketika merasa overwhelmed.',
                'video_url' => 'https://www.youtube.com/watch?v=1vx8iUvfyCY',
                'recommended_state' => 'berat',
                'category' => 'meditasi',
            ],
            [
                'title' => 'Teknik Grounding untuk Mengatasi Kecemasan',
                'description' => 'Video panduan teknik grounding yang efektif untuk mengatasi kecemasan dan stres berat. Teknik ini membantu mengembalikan fokus ke momen saat ini.',
                'video_url' => 'https://www.youtube.com/watch?v=30VMIEmA114',
                'recommended_state' => 'berat',
                'category' => 'relaksasi',
            ],
            [
                'title' => 'Relaksasi Otot Progresif untuk Stres Berat',
                'description' => 'Teknik relaksasi otot progresif yang dapat membantu mengurangi ketegangan fisik dan mental akibat stres berat. Praktikkan secara rutin untuk hasil optimal.',
                'video_url' => 'https://www.youtube.com/watch?v=ihwmowfS22E',
                'recommended_state' => 'berat',
                'category' => 'relaksasi',
            ],
            [
                'title' => 'Meditasi Kasih Sayang untuk Self-Compassion',
                'description' => 'Meditasi kasih sayang yang membantu mengembangkan self-compassion dan mengatasi perasaan negatif terhadap diri sendiri. Penting untuk tenaga kesehatan yang sering mengkritik diri sendiri.',
                'video_url' => 'https://www.youtube.com/watch?v=5GSeWdjyr1c',
                'recommended_state' => 'berat',
                'category' => 'meditasi',
            ],

            // Videos for "semua" (all states) - General mindfulness content
            [
                'title' => 'Panduan Lengkap Meditasi untuk Pemula',
                'description' => 'Panduan lengkap meditasi untuk pemula yang mencakup berbagai teknik dasar. Cocok untuk siapa saja yang ingin memulai praktik meditasi untuk kesehatan mental.',
                'video_url' => 'https://www.youtube.com/watch?v=U9YKY7fdwyg',
                'recommended_state' => 'semua',
                'category' => 'meditasi',
            ],
            [
                'title' => 'Yoga untuk Tenaga Kesehatan - Relaksasi dan Peregangan',
                'description' => 'Sesi yoga singkat yang dirancang untuk tenaga kesehatan. Fokus pada relaksasi dan peregangan untuk mengurangi ketegangan fisik akibat pekerjaan.',
                'video_url' => 'https://www.youtube.com/watch?v=v7AYKMP6rOE',
                'recommended_state' => 'semua',
                'category' => 'relaksasi',
            ],
            [
                'title' => 'Teknik Pernapasan untuk Mengelola Stres di Tempat Kerja',
                'description' => 'Berbagai teknik pernapasan yang dapat dilakukan di tempat kerja untuk mengelola stres. Praktis dan mudah dilakukan tanpa perlu peralatan khusus.',
                'video_url' => 'https://www.youtube.com/watch?v=tybOi4hjZFQ',
                'recommended_state' => 'semua',
                'category' => 'relaksasi',
            ],
        ];

        foreach ($videos as $video) {
            Video::create($video);
        }
    }
}
