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
    import { LoaderCircle } from 'lucide-svelte';
    import { type BreadcrumbItem } from '@/types';

    interface MoodOption {
        value: number;
        label: string;
        emoji: string;
    }

    interface Props {
        moodOptions: MoodOption[];
    }

    let { moodOptions }: Props = $props();

    const breadcrumbs: BreadcrumbItem[] = [
        {
            title: 'Jurnal Harian',
            href: route('journals.index'),
        },
        {
            title: 'Tulis Jurnal Baru',
            href: route('journals.create'),
        },
    ];

    let title = $state('');
    let content = $state('');
    let mood = $state<number | null>(null);
    let date = $state(new Date().toISOString().split('T')[0]);
</script>

<svelte:head>
    <title>Tulis Jurnal Baru</title>
</svelte:head>

<AppLayout {breadcrumbs}>
    <div class="container mx-auto max-w-3xl px-4 py-8">
        <Card>
            <CardHeader>
                <CardTitle>Tulis Jurnal Baru</CardTitle>
                <CardDescription>
                    Bagikan perasaan dan pengalaman Anda hari ini
                </CardDescription>
            </CardHeader>
            <CardContent>
                <Form method="post" action={route('journals.store')} class="space-y-6">
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
                                value={mood?.toString() ?? ''}
                                onValueChange={(value) => {
                                    mood = value ? parseInt(value, 10) : null;
                                }}
                                required
                            >
                                <div class="grid gap-4 md:grid-cols-2">
                                    {#each moodOptions as option}
                                        <div class="flex items-center space-x-3 rounded-lg border p-4 hover:bg-accent transition-colors">
                                            <RadioGroupItem value={option.value.toString()} id="mood-{option.value}" />
                                            <Label
                                                for="mood-{option.value}"
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
                            {#if mood !== null}
                                <input type="hidden" name="mood" value={mood} />
                            {/if}
                            <InputError message={errors.mood} />
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-end gap-4 pt-4">
                            <Button type="button" variant="outline" href={route('journals.index')}>
                                Batal
                            </Button>
                            <Button type="submit" disabled={processing || !content || mood === null}>
                                {#if processing}
                                    <LoaderCircle class="mr-2 h-4 w-4 animate-spin" />
                                {/if}
                                {processing ? 'Menyimpan...' : 'Simpan Jurnal'}
                            </Button>
                        </div>
                    {/snippet}
                </Form>
            </CardContent>
        </Card>
    </div>
</AppLayout>

