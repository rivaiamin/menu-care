<script lang="ts">
    import InputError from '@/components/InputError.svelte';
    import { Button } from '@/components/ui/button';
    import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
    import { Input } from '@/components/ui/input';
    import { Label } from '@/components/ui/label';
    import { Textarea } from '@/components/ui/textarea';
    import { RadioGroup, RadioGroupItem } from '@/components/ui/radio-group';
    import AppLayout from '@/layouts/AppLayout.svelte';
    import { Form } from '@inertiajs/svelte';
    import { LoaderCircle, ArrowLeft } from 'lucide-svelte';
    import { type BreadcrumbItem } from '@/types';

    interface MoodOption {
        value: number;
        label: string;
        emoji: string;
    }

    interface Journal {
        id: number;
        date: string;
        title: string | null;
        content: string;
        mood: number;
        created_at: string;
        updated_at: string;
    }

    interface Props {
        journal: Journal;
        moodOptions: MoodOption[];
    }

    let { journal, moodOptions }: Props = $props();

    const breadcrumbs: BreadcrumbItem[] = [
        {
            title: 'Jurnal Harian',
            href: route('journals.index'),
        },
        {
            title: 'Edit Jurnal',
            href: route('journals.edit', journal.id),
        },
    ];

    let title = $state(journal.title || '');
    let content = $state(journal.content);
    let mood = $state(journal.mood);
    let date = $state(journal.date);
</script>

<svelte:head>
    <title>Edit Jurnal</title>
</svelte:head>

<AppLayout {breadcrumbs}>
    <div class="container mx-auto max-w-3xl px-4 py-8">
        <!-- Back Button -->
        <div class="mb-6">
            <Button variant="ghost" href={route('journals.show', journal.id)}>
                <ArrowLeft class="mr-2 h-4 w-4" />
                Kembali ke Detail Jurnal
            </Button>
        </div>

        <Card>
            <CardHeader>
                <CardTitle>Edit Jurnal</CardTitle>
                <CardDescription>
                    Perbarui jurnal Anda
                </CardDescription>
            </CardHeader>
            <CardContent>
                <Form method="put" action={route('journals.update', journal.id)} class="space-y-6">
                    {#snippet children({ errors, processing }: { errors: Record<string, string>; processing: boolean })}
                        <!-- Date Input -->
                        <div class="grid gap-2">
                            <Label for="date">Tanggal</Label>
                            <Input
                                id="date"
                                type="date"
                                name="date"
                                bind:value={date}
                                max={new Date().toISOString().split('T')[0]}
                            />
                            <InputError message={errors.date} />
                        </div>

                        <!-- Title Input (Optional) -->
                        <div class="grid gap-2">
                            <Label for="title">Judul (Opsional)</Label>
                            <Input
                                id="title"
                                name="title"
                                bind:value={title}
                                placeholder="Contoh: Hari yang Menyenangkan"
                            />
                            <InputError message={errors.title} />
                        </div>

                        <!-- Content Textarea -->
                        <div class="grid gap-2">
                            <Label for="content">Konten Jurnal *</Label>
                            <Textarea
                                id="content"
                                name="content"
                                bind:value={content}
                                placeholder="Tuliskan perasaan dan pengalaman Anda hari ini..."
                                rows={8}
                                required
                                minlength={10}
                            />
                            <InputError message={errors.content} />
                            <p class="text-sm text-muted-foreground">
                                Minimal 10 karakter
                            </p>
                        </div>

                        <!-- Mood Selection -->
                        <div class="grid gap-2">
                            <Label>Bagaimana perasaan Anda hari ini? *</Label>
                            <RadioGroup
                                value={mood.toString()}
                                onValueChange={(value) => {
                                    mood = parseInt(value, 10);
                                }}
                                required
                            >
                                <div class="grid gap-4 md:grid-cols-2">
                                    {#each moodOptions as option}
                                        <div class="flex items-center space-x-3 rounded-lg border p-4 hover:bg-accent transition-colors">
                                            <RadioGroupItem value={option.value.toString()} id="mood-edit-{option.value}" />
                                            <Label
                                                for="mood-edit-{option.value}"
                                                class="flex-1 cursor-pointer font-normal text-base"
                                            >
                                                <span class="text-2xl mr-2">{option.emoji}</span>
                                                {option.label}
                                            </Label>
                                        </div>
                                    {/each}
                                </div>
                            </RadioGroup>
                            <!-- Hidden input to ensure mood is submitted -->
                            <input type="hidden" name="mood" value={mood} />
                            <InputError message={errors.mood} />
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-end gap-4 pt-4">
                            <Button type="button" variant="outline" href={route('journals.show', journal.id)}>
                                Batal
                            </Button>
                            <Button type="submit" disabled={processing || !content}>
                                {#if processing}
                                    <LoaderCircle class="mr-2 h-4 w-4 animate-spin" />
                                {/if}
                                {processing ? 'Menyimpan...' : 'Simpan Perubahan'}
                            </Button>
                        </div>
                    {/snippet}
                </Form>
            </CardContent>
        </Card>
    </div>
</AppLayout>

