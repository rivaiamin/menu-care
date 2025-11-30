<script lang="ts">
    import InputError from '@/components/InputError.svelte';
    import { Button } from '@/components/ui/button';
    import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
    import { Label } from '@/components/ui/label';
    import { Progress } from '@/components/ui/progress';
    import { RadioGroup, RadioGroupItem } from '@/components/ui/radio-group';
    import AppLayout from '@/layouts/AppLayout.svelte';
    import { Form } from '@inertiajs/svelte';
    import { LoaderCircle } from 'lucide-svelte';
    import { route } from 'ziggy-js';

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

    // Calculate progress
    const progress = $derived(Math.round((Object.keys(answers).length / questions.length) * 100));

    // Check if all questions are answered
    const allAnswered = $derived(Object.keys(answers).length === questions.length);

    // Update answer when radio group changes
    function handleAnswerChange(questionId: number, value: string) {
        answers[questionId] = parseInt(value, 10);
    }
</script>

<svelte:head>
    <title>Self Assessment PSS-10</title>
</svelte:head>

<AppLayout breadcrumbs={[{ title: 'Self Assessment', href: route('quiz') }]}>
    <div class="container mx-auto max-w-4xl px-4 py-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold mb-2">Self Assessment PSS-10</h1>
            <p class="text-muted-foreground">
                Silakan jawab semua pertanyaan berikut berdasarkan pengalaman Anda dalam sebulan terakhir.
            </p>
        </div>

        <!-- Progress Bar -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-2">
                <span class="text-sm font-medium">Progress</span>
                <span class="text-sm text-muted-foreground">
                    {Object.keys(answers).length} / {questions.length}
                </span>
            </div>
            <Progress value={progress} class="h-2" />
        </div>

        <Form method="post" action={route('quiz.store')} class="space-y-6">
            {#snippet children({ errors, processing }: { errors: Record<string, string>; processing: boolean })}
                {#each questions as question, index}
                    {@const questionNumber = index + 1}
                    <Card>
                        <CardHeader>
                            <CardTitle class="text-lg">
                                Pertanyaan {questionNumber} dari {questions.length}
                            </CardTitle>
                            <CardDescription>{question.text}</CardDescription>
                        </CardHeader>
                        <CardContent>
                            <RadioGroup
                                value={answers[question.id]?.toString() ?? ''}
                                onValueChange={(value) => handleAnswerChange(question.id, value)}
                                required
                            >
                                <div class="grid gap-4">
                                    {#each answerOptions as option}
                                        <div class="flex items-center space-x-3">
                                            <RadioGroupItem value={option.value.toString()} id="q{question.id}-{option.value}" />
                                            <Label
                                                for="q{question.id}-{option.value}"
                                                class="flex-1 cursor-pointer font-normal"
                                            >
                                                {option.label}
                                            </Label>
                                        </div>
                                    {/each}
                                </div>
                            </RadioGroup>
                            <!-- Hidden input to ensure the answer is submitted with correct name format -->
                            {#if answers[question.id] !== undefined}
                                <input
                                    type="hidden"
                                    name="answers[{question.id}]"
                                    value={answers[question.id]}
                                />
                            {/if}
                            {#if errors[`answers.${question.id}`]}
                                <InputError class="mt-2" message={errors[`answers.${question.id}`]} />
                            {/if}
                        </CardContent>
                    </Card>
                {/each}

                {#if errors.answers}
                    <div class="rounded-lg border border-destructive bg-destructive/10 p-4">
                        <InputError message={errors.answers} />
                    </div>
                {/if}

                <div class="flex justify-end gap-4 pt-4">
                    <Button
                        type="submit"
                        size="lg"
                        disabled={!allAnswered || processing}
                        class="min-w-[120px]"
                    >
                        {#if processing}
                            <LoaderCircle class="mr-2 h-4 w-4 animate-spin" />
                        {/if}
                        {processing ? 'Mengirim...' : 'Kirim Jawaban'}
                    </Button>
                </div>

                {#if !allAnswered}
                    <p class="text-sm text-muted-foreground text-center">
                        Silakan jawab semua pertanyaan sebelum mengirim.
                    </p>
                {/if}
            {/snippet}
        </Form>
    </div>
</AppLayout>

