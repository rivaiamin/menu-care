<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuizRequest;
use App\Models\DailyQuiz;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class QuizController extends Controller
{
    /**
     * PSS-10 Questions with reverse scoring flags.
     *
     * @var array<int, array{id: int, text: string, reverse: bool}>
     */
    protected const QUESTIONS = [
        [
            'id' => 1,
            'text' => 'Dalam sebulan terakhir, seberapa sering Anda merasa kecewa/gundah/terganggu karena sesuatu hal yang terjadi di luar harapan/dugaan Anda?',
            'reverse' => false,
        ],
        [
            'id' => 2,
            'text' => 'Dalam sebulan terakhir, seberapa sering Anda merasa tidak mampu untuk mengontrol hal-hal penting dalam hidup Anda? (contoh: pekerjaan, sekolah, keluarga, ibadah)',
            'reverse' => false,
        ],
        [
            'id' => 3,
            'text' => 'Dalam sebulan terakhir, seberapa sering Anda merasa gelisah dan stres?',
            'reverse' => false,
        ],
        [
            'id' => 4,
            'text' => 'Dalam sebulan terakhir, seberapa sering Anda merasa percaya diri bahwa Anda mampu untuk menyelesaikan masalah pribadi Anda?',
            'reverse' => true,
        ],
        [
            'id' => 5,
            'text' => 'Dalam sebulan terakhir, seberapa sering Anda merasa bahwa segala sesuatunya berjalan sesuai keinginan Anda?',
            'reverse' => true,
        ],
        [
            'id' => 6,
            'text' => 'Dalam sebulan terakhir, seberapa sering Anda menyadari bahwa Anda tidak dapat menyelesaikan semua hal yang harus Anda lakukan?',
            'reverse' => false,
        ],
        [
            'id' => 7,
            'text' => 'Dalam sebulan terakhir, seberapa sering Anda dapat mengontrol perasaan jengkel atau tidak nyaman yang mengganggu dalam hidup Anda?',
            'reverse' => true,
        ],
        [
            'id' => 8,
            'text' => 'Dalam sebulan terakhir, seberapa sering Anda merasa bahwa Anda berada dalam situasi yang nyaman?',
            'reverse' => true,
        ],
        [
            'id' => 9,
            'text' => 'Dalam sebulan terakhir, seberapa sering Anda marah karena sesuatu hal yang terjadi di luar kendali Anda?',
            'reverse' => false,
        ],
        [
            'id' => 10,
            'text' => 'Dalam sebulan terakhir, seberapa sering Anda merasa segala kesulitan atau masalah menumpuk begitu tinggi sehingga Anda merasa tidak mampu mengatasinya?',
            'reverse' => false,
        ],
    ];

    /**
     * Answer options for the quiz.
     *
     * @var array<int, array{value: int, label: string}>
     */
    protected const ANSWER_OPTIONS = [
        ['value' => 0, 'label' => 'Tidak Pernah'],
        ['value' => 1, 'label' => 'Hampir Tidak Pernah'],
        ['value' => 2, 'label' => 'Kadang-Kadang'],
        ['value' => 3, 'label' => 'Cukup Sering'],
        ['value' => 4, 'label' => 'Sangat Sering'],
    ];

    /**
     * Show the quiz page.
     */
    public function show(Request $request): Response|RedirectResponse
    {
        // Check if user already has a valid quiz
        $validQuiz = $request->user()->latestValidQuiz();

        if ($validQuiz) {
            // Redirect to dashboard if quiz is still valid
            return redirect()->route('dashboard');
        }

        return Inertia::render('quiz/Quiz', [
            'questions' => self::QUESTIONS,
            'answerOptions' => self::ANSWER_OPTIONS,
        ]);
    }

    /**
     * Store the quiz submission.
     */
    public function store(QuizRequest $request): RedirectResponse
    {
        $user = $request->user();
        $answers = $request->validated()['answers'];

        // Calculate score with reverse scoring
        $score = $this->calculateScore($answers);

        // Determine category
        $category = $this->determineCategory($score);

        // Get recommendations based on category
        $recommendations = $this->getRecommendations($category);

        // Store quiz result
        $quiz = DailyQuiz::create([
            'user_id' => $user->id,
            'date' => now()->toDateString(),
            'answers' => $answers,
            'score' => $score,
            'category' => $category,
        ]);

        // Update user's last quiz timestamp
        $user->update([
            'last_quiz_date' => now()->toDateString(),
            'last_quiz_timestamp' => now(),
        ]);

        // Store result in session to show on result page
        $request->session()->flash('quiz_result', [
            'score' => $score,
            'category' => $category,
            'recommendations' => $recommendations,
        ]);

        // Redirect to result page (which will then redirect to homepage)
        return redirect()->route('quiz.result');
    }

    /**
     * Check quiz status (API endpoint).
     */
    public function status(Request $request): JsonResponse
    {
        $validQuiz = $request->user()->latestValidQuiz();

        return response()->json([
            'has_valid_quiz' => $validQuiz !== null,
            'quiz' => $validQuiz ? [
                'score' => $validQuiz->score,
                'category' => $validQuiz->category,
                'created_at' => $validQuiz->created_at->toIso8601String(),
            ] : null,
        ]);
    }

    /**
     * Show quiz result page.
     */
    public function result(Request $request): Response|RedirectResponse
    {
        $result = $request->session()->get('quiz_result');

        // If no session data, try to get from latest valid quiz
        if (! $result) {
            $user = $request->user();
            $latestQuiz = $user->latestValidQuiz();

            if (! $latestQuiz) {
                return redirect()->route('quiz');
            }

            // Build result from latest quiz
            $result = [
                'score' => $latestQuiz->score,
                'category' => $latestQuiz->category,
                'recommendations' => $this->getRecommendations($latestQuiz->category),
            ];
        }

        return Inertia::render('quiz/Result', [
            'result' => $result,
        ]);
    }

    /**
     * Calculate total score with reverse scoring applied.
     *
     * @param  array<int, int>  $answers  Array of answers indexed by question ID (1-10)
     * @return int Score between 0-40
     */
    protected function calculateScore(array $answers): int
    {
        $totalScore = 0;

        foreach (self::QUESTIONS as $question) {
            $questionId = $question['id'];
            $answer = $answers[$questionId] ?? 0;

            if ($question['reverse']) {
                // Reverse scoring: score = 4 - answer
                $totalScore += (4 - $answer);
            } else {
                // Forward scoring: use answer value directly
                $totalScore += $answer;
            }
        }

        return $totalScore;
    }

    /**
     * Determine stress category based on score.
     *
     * @return 'rendah'|'sedang'|'berat'
     */
    protected function determineCategory(int $score): string
    {
        if ($score >= 0 && $score <= 13) {
            return 'rendah';
        } elseif ($score >= 14 && $score <= 26) {
            return 'sedang';
        } else {
            return 'berat';
        }
    }

    /**
     * Get recommendations based on category.
     *
     * @param  'rendah'|'sedang'|'berat'  $category
     * @return array<string, mixed>
     */
    protected function getRecommendations(string $category): array
    {
        return match ($category) {
            'rendah' => [
                'title' => 'Tingkat Stres Rendah',
                'description' => 'Anda memiliki tingkat stres yang rendah. Tetap pertahankan kondisi ini dengan melakukan aktivitas relaksasi secara rutin.',
                'recommendations' => [
                    'Relaksasi Nafas Dalam',
                    'Baca Tips dan Edukasi Mental Health',
                ],
                'showWarning' => false,
                'showConsultationLinks' => false,
            ],
            'sedang' => [
                'title' => 'Tingkat Stres Sedang',
                'description' => 'Anda mengalami tingkat stres sedang. Pertimbangkan untuk melakukan aktivitas mindfulness secara rutin.',
                'recommendations' => [
                    'Mindfulness (Meditasi, Relaksasi Nafas Dalam, Afirmasi Positif)',
                    'Baca Tips dan Edukasi Mental Health',
                    'Pertimbangkan Berkonsultasi Ke Tenaga Profesional',
                ],
                'showWarning' => false,
                'showConsultationLinks' => false,
            ],
            'berat' => [
                'title' => 'Tingkat Stres Berat',
                'description' => 'Anda mengalami tingkat stres yang tinggi. Sangat disarankan untuk melakukan aktivitas mindfulness dan mempertimbangkan konsultasi profesional.',
                'recommendations' => [
                    'Mindfulness (Meditasi, Relaksasi Nafas Dalam, Afirmasi Positif)',
                    'Baca Tips dan Edukasi Mental Health',
                ],
                'warning' => 'Jika muncul gejala seperti gangguan tidur berat atau perasaan tidak mampu mengontrol diri, segera minta bantuan profesional.',
                'showWarning' => true,
                'showConsultationLinks' => true,
                'consultationLinks' => [
                    ['name' => 'Halodoc', 'url' => 'https://www.halodoc.com'],
                    ['name' => 'Alodokter', 'url' => 'https://www.alodokter.com'],
                ],
            ],
        };
    }
}

