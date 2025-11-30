<?php

namespace App\Http\Controllers;

use App\Http\Requests\JournalRequest;
use App\Models\Journal;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class JournalController extends Controller
{
    /**
     * Mood options for the journal form.
     *
     * @var array<int, array{value: int, label: string, emoji: string}>
     */
    protected const MOOD_OPTIONS = [
        ['value' => 1, 'label' => 'Sangat Buruk', 'emoji' => '😢'],
        ['value' => 2, 'label' => 'Buruk', 'emoji' => '😞'],
        ['value' => 3, 'label' => 'Biasa', 'emoji' => '😐'],
        ['value' => 4, 'label' => 'Baik', 'emoji' => '🙂'],
        ['value' => 5, 'label' => 'Sangat Baik', 'emoji' => '😊'],
    ];

    /**
     * Display a listing of the user's journals.
     */
    public function index(Request $request): Response
    {
        $journals = $request->user()
            ->journals()
            ->latest('date')
            ->latest('created_at')
            ->paginate(10);

        return Inertia::render('journal/Index', [
            'journals' => $journals,
            'moodOptions' => self::MOOD_OPTIONS,
        ]);
    }

    /**
     * Show the form for creating a new journal.
     */
    public function create(Request $request): Response
    {
        return Inertia::render('journal/Create', [
            'moodOptions' => self::MOOD_OPTIONS,
        ]);
    }

    /**
     * Store a newly created journal in storage.
     */
    public function store(JournalRequest $request): RedirectResponse
    {
        $journal = $request->user()->journals()->create($request->validated());

        return redirect()
            ->route('journals.index')
            ->with('success', 'Jurnal berhasil disimpan.');
    }

    /**
     * Display the specified journal.
     */
    public function show(Request $request, Journal $journal): Response|RedirectResponse
    {
        // Ensure the journal belongs to the authenticated user
        if ($journal->user_id !== $request->user()->id) {
            abort(403);
        }

        return Inertia::render('journal/Show', [
            'journal' => $journal,
            'moodOptions' => self::MOOD_OPTIONS,
        ]);
    }

    /**
     * Show the form for editing the specified journal.
     */
    public function edit(Request $request, Journal $journal): Response|RedirectResponse
    {
        // Ensure the journal belongs to the authenticated user
        if ($journal->user_id !== $request->user()->id) {
            abort(403);
        }

        return Inertia::render('journal/Edit', [
            'journal' => $journal,
            'moodOptions' => self::MOOD_OPTIONS,
        ]);
    }

    /**
     * Update the specified journal in storage.
     */
    public function update(JournalRequest $request, Journal $journal): RedirectResponse
    {
        // Ensure the journal belongs to the authenticated user
        if ($journal->user_id !== $request->user()->id) {
            abort(403);
        }

        $journal->update($request->validated());

        return redirect()
            ->route('journals.show', $journal)
            ->with('success', 'Jurnal berhasil diperbarui.');
    }

    /**
     * Remove the specified journal from storage.
     */
    public function destroy(Request $request, Journal $journal): RedirectResponse
    {
        // Ensure the journal belongs to the authenticated user
        if ($journal->user_id !== $request->user()->id) {
            abort(403);
        }

        $journal->delete();

        return redirect()
            ->route('journals.index')
            ->with('success', 'Jurnal berhasil dihapus.');
    }
}

