<script lang="ts">
    import InputError from '@/components/InputError.svelte';
    import { Button } from '@/components/ui/button';
    import { Label } from '@/components/ui/label';
    import { Progress } from '@/components/ui/progress';
    import { RadioGroup, RadioGroupItem } from '@/components/ui/radio-group';
    import AppLayout from '@/layouts/AppLayout.svelte';
    import { Form } from '@inertiajs/svelte';
    import { fade, fly } from 'svelte/transition';
    import { LoaderCircle, ChevronLeft, ChevronRight } from 'lucide-svelte';
    import { tick } from 'svelte';

    interface Question {
        id: number;
        text: string;
        reverse: boolean;
    }

    interface AnswerOption {
        value: number;
        label: string;
    }

    interface Props {
        questions: Question[];
        answerOptions: AnswerOption[];
    }

    let { questions, answerOptions }: Props = $props();

    // Track answers for each question
    let answers = $state<Record<number, number>>({});

    // Current question index (0-based)
    let currentIndex = $state(0);

    // Track transition direction for slide animation
    let direction = $state<'forward' | 'backward'>('forward');

    // Get current question
    const currentQuestion = $derived(questions[currentIndex]);
    const questionNumber = $derived(currentIndex + 1);
    const isFirstQuestion = $derived(currentIndex === 0);
    const isLastQuestion = $derived(currentIndex === questions.length - 1);

    // Calculate progress
    const progress = $derived(Math.round((questionNumber / questions.length) * 100));
    const answeredCount = $derived(Object.keys(answers).length);

    // Check if current question is answered
    const currentQuestionAnswered = $derived(answers[currentQuestion?.id] !== undefined);

    // Check if all questions are answered
    const allAnswered = $derived(Object.keys(answers).length === questions.length);

    // Update answer when radio group changes
    function handleAnswerChange(questionId: number, value: string) {
        answers[questionId] = parseInt(value, 10);

        // Auto-advance to next question after a short delay (optional)
        // Uncomment if you want auto-advance behavior
        // if (!isLastQuestion) {
        //     setTimeout(() => {
        //         nextQuestion();
        //     }, 300);
        // }
    }

    // Navigate to next question
    async function nextQuestion() {
        if (isLastQuestion) return;
        direction = 'forward';
        await tick();
        currentIndex++;
    }

    // Navigate to previous question
    async function previousQuestion() {
        if (isFirstQuestion) return;
        direction = 'backward';
        await tick();
        currentIndex--;
    }

    // Handle keyboard navigation
    function handleKeydown(event: KeyboardEvent) {
        if (event.key === 'ArrowLeft' && !isFirstQuestion) {
            previousQuestion();
        } else if (event.key === 'ArrowRight' && !isLastQuestion) {
            nextQuestion();
        }
    }
</script>

<svelte:window onkeydown={handleKeydown} />
<svelte:head>
    <title>Self Assessment PSS-10</title>
</svelte:head>

<AppLayout breadcrumbs={[{ title: 'Self Assessment', href: route('quiz') }]}>
    <div class="min-h-[calc(100vh-200px)] flex flex-col">
        <!-- Header Section -->
        <div class="container mx-auto max-w-4xl px-4 pt-8 pb-6">
            <div class="mb-6">
                <h1 class="text-3xl font-bold mb-2">Self Assessment PSS-10</h1>
                <p class="text-muted-foreground">
                    Silakan jawab semua pertanyaan berikut berdasarkan pengalaman Anda dalam sebulan terakhir.
                </p>
            </div>

            <!-- Progress Bar -->
            <div class="mb-6">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm font-medium">Progress</span>
                    <span class="text-sm text-muted-foreground">
                        {questionNumber} / {questions.length}
                    </span>
                </div>
                <Progress value={progress} class="h-2" />
            </div>
        </div>

        <!-- Question Container - Full Height -->
        <div class="flex-1 flex items-center justify-center relative overflow-hidden">
            <Form method="post" action={route('quiz.store')} class="w-full">
                {#snippet children({ errors, processing }: { errors: Record<string, string>; processing: boolean })}
                    <!-- Hidden inputs for ALL answers - must be outside the key block -->
                    {#each questions as question}
                        {#if answers[question.id] !== undefined}
                            <input
                                type="hidden"
                                name="answers[{question.id}]"
                                value={answers[question.id]}
                            />
                        {/if}
                    {/each}
                    {#key currentQuestion?.id}
                        {#if currentQuestion}
                            <div
                                class="container mx-auto max-w-3xl px-4 py-8 w-full"
                                transition:fly={{
                                    x: direction === 'forward' ? 150 : -150,
                                    duration: 300,
                                    opacity: 0.2,
                                    easing: (t) => t * (2 - t) // ease-out
                                }}
                            >
                                <!-- Question Header -->
                                <div
                                    class="text-center mb-12"
                                    transition:fade={{ duration: 200, delay: 50 }}
                                >
                                    <div class="inline-flex items-center justify-center w-14 h-14 rounded-full bg-primary/10 text-primary font-semibold mb-6 text-xl shadow-sm">
                                        {questionNumber}
                                    </div>
                                    <h2 class="text-2xl md:text-3xl lg:text-4xl font-semibold mb-4 leading-relaxed max-w-2xl mx-auto text-foreground" id={`question-${currentQuestion.id}`}>
                                        {currentQuestion.text}
                                    </h2>
                                </div>

                                <!-- Answer Options -->
                                <div class="max-w-xl mx-auto space-y-4 mb-12">
                                    <RadioGroup
                                        value={answers[currentQuestion.id]?.toString() ?? ''}
                                        onValueChange={(value) => handleAnswerChange(currentQuestion.id, value)}
                                        required
                                        class="space-y-3"
                                        aria-labelledby={`question-${currentQuestion.id}`}
                                    >
                                    {#each answerOptions as option, optionIndex}
                                        <div
                                            class="group relative"
                                            transition:fade={{ duration: 200, delay: optionIndex * 50 }}
                                        >
                                            <div
                                                class="flex items-center space-x-4 p-5 rounded-xl border-2 transition-all duration-300 cursor-pointer hover:border-primary/60 hover:bg-accent/50 hover:shadow-md hover:scale-[1.02] active:scale-[0.98] {answers[currentQuestion.id] === option.value ? 'border-primary bg-primary/10 shadow-md scale-[1.02]' : 'border-border bg-background'}"
                                                role="button"
                                                tabindex="0"
                                                onkeydown={(e) => {
                                                    if (e.key === 'Enter' || e.key === ' ') {
                                                        e.preventDefault();
                                                        handleAnswerChange(currentQuestion.id, option.value.toString());
                                                    }
                                                }}
                                                onclick={() => handleAnswerChange(currentQuestion.id, option.value.toString())}
                                            >
                                                <RadioGroupItem
                                                    value={option.value.toString()}
                                                    id="q{currentQuestion.id}-{option.value}"
                                                    class="shrink-0"
                                                />
                                                <Label
                                                    for="q{currentQuestion.id}-{option.value}"
                                                    class="flex-1 cursor-pointer font-normal text-base md:text-lg leading-relaxed"
                                                >
                                                    {option.label}
                                                </Label>
                                            </div>
                                        </div>
                                    {/each}
                                    </RadioGroup>

                                    {#if errors[`answers.${currentQuestion.id}`]}
                                        <div transition:fade={{ duration: 200 }}>
                                            <InputError
                                                class="mt-4"
                                                message={errors[`answers.${currentQuestion.id}`]}
                                            />
                                        </div>
                                    {/if}
                                </div>

                                <!-- Navigation Buttons -->
                                <div
                                    class="flex items-center justify-between max-w-xl mx-auto"
                                    transition:fade={{ duration: 200, delay: 200 }}
                                >
                                    <Button
                                        type="button"
                                        variant="outline"
                                        size="lg"
                                        onclick={previousQuestion}
                                        disabled={isFirstQuestion || processing}
                                        class="min-w-[140px] transition-all hover:scale-105 active:scale-95"
                                    >
                                        <ChevronLeft class="mr-2 h-4 w-4" />
                                        Sebelumnya
                                    </Button>

                                    {#if isLastQuestion}
                                        <Button
                                            type="submit"
                                            size="lg"
                                            disabled={!allAnswered || processing}
                                            class="min-w-[140px] transition-all hover:scale-105 active:scale-95"
                                        >
                                            {#if processing}
                                                <LoaderCircle class="mr-2 h-4 w-4 animate-spin" />
                                            {/if}
                                            {processing ? 'Mengirim...' : 'Kirim Jawaban'}
                                        </Button>
                                    {:else}
                                        <Button
                                            type="button"
                                            size="lg"
                                            onclick={nextQuestion}
                                            disabled={!currentQuestionAnswered || processing}
                                            class="min-w-[140px] transition-all hover:scale-105 active:scale-95 disabled:opacity-50 disabled:cursor-not-allowed"
                                        >
                                            Selanjutnya
                                            <ChevronRight class="ml-2 h-4 w-4" />
                                        </Button>
                                    {/if}
                                </div>

                                {#if !currentQuestionAnswered && !isLastQuestion}
                                    <p class="text-sm text-foreground/70 text-center mt-6 animate-pulse" aria-live="polite">
                                        Pilih jawaban untuk melanjutkan
                                    </p>
                                {/if}
                            </div>
                        {/if}
                    {/key}

                    {#if errors.answers}
                        <div class="container mx-auto max-w-3xl px-4">
                            <div class="rounded-lg border border-destructive bg-destructive/10 p-4">
                                <InputError message={errors.answers} />
                            </div>
                        </div>
                    {/if}
                {/snippet}
            </Form>
        </div>
    </div>
</AppLayout>

