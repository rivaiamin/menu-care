<script lang="ts">
    import InputError from '@/components/InputError.svelte';
    import { Button } from '@/components/ui/button';
    import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
    import { Badge } from '@/components/ui/badge';
    import AppLayout from '@/layouts/AppLayout.svelte';
    import { Link, router } from '@inertiajs/svelte';
    import { Calendar, Edit, Plus, Trash2 } from 'lucide-svelte';
    import { type BreadcrumbItem } from '@/types';
    import { AlertDialog, AlertDialogAction, AlertDialogCancel, AlertDialogContent, AlertDialogDescription, AlertDialogFooter, AlertDialogHeader, AlertDialogTitle, AlertDialogTrigger } from '@/components/ui/alert-dialog';

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

    interface PaginatedJournals {
        data: Journal[];
        current_page: number;
        last_page: number;
        per_page: number;
        total: number;
        links: Array<{
            url: string | null;
            label: string;
            active: boolean;
        }>;
    }

    interface Props {
        journals: PaginatedJournals;
        moodOptions: MoodOption[];
    }

    let { journals, moodOptions }: Props = $props();

    const breadcrumbs: BreadcrumbItem[] = [
        {
            title: 'Jurnal Harian',
            href: route('journals.index'),
        },
    ];

    function getMoodLabel(mood: number): string {
        const option = moodOptions.find((opt) => opt.value === mood);
        return option ? `${option.emoji} ${option.label}` : `Mood ${mood}`;
    }

    function formatDate(dateString: string): string {
        const date = new Date(dateString);
        return date.toLocaleDateString('id-ID', {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric',
        });
    }

    function deleteJournal(journalId: number) {
        router.delete(route('journals.destroy', journalId), {
            preserveScroll: true,
        });
    }
</script>

<svelte:head>
    <title>Jurnal Harian</title>
</svelte:head>

<AppLayout {breadcrumbs}>
    <div class="container mx-auto max-w-6xl px-4 py-8">
        <!-- Header -->
        <div class="mb-8 flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold mb-2">Jurnal Harian</h1>
                <p class="text-muted-foreground">
                    Catat perasaan dan pengalaman Anda setiap hari
                </p>
            </div>
            <Button href={route('journals.create')}>
                <Plus class="mr-2 h-4 w-4" />
                Tulis Jurnal Baru
            </Button>
        </div>

        <!-- Journals List -->
        {#if journals.data.length === 0}
            <Card>
                <CardContent class="py-12 text-center">
                    <p class="text-muted-foreground mb-4">Anda belum memiliki jurnal.</p>
                    <Button href={route('journals.create')}>
                        <Plus class="mr-2 h-4 w-4" />
                        Mulai Menulis Jurnal
                    </Button>
                </CardContent>
            </Card>
        {:else}
            <div class="space-y-4">
                {#each journals.data as journal (journal.id)}
                    <Card class="hover:shadow-md transition-shadow">
                        <CardHeader>
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center gap-3 mb-2">
                                        <Calendar class="h-4 w-4 text-muted-foreground" />
                                        <span class="text-sm text-muted-foreground">
                                            {formatDate(journal.date)}
                                        </span>
                                        <Badge variant="outline">{getMoodLabel(journal.mood)}</Badge>
                                    </div>
                                    {#if journal.title}
                                        <CardTitle class="text-xl mb-2">{journal.title}</CardTitle>
                                    {/if}
                                </div>
                                <div class="flex items-center gap-2">
                                    <Button variant="ghost" size="icon" href={route('journals.show', journal.id)}>
                                        <Edit class="h-4 w-4" />
                                    </Button>
                                    <AlertDialog>
                                        <AlertDialogTrigger>
                                            <Button variant="ghost" size="icon">
                                                <Trash2 class="h-4 w-4 text-destructive" />
                                            </Button>
                                        </AlertDialogTrigger>
                                        <AlertDialogContent>
                                            <AlertDialogHeader>
                                                <AlertDialogTitle>Hapus Jurnal</AlertDialogTitle>
                                                <AlertDialogDescription>
                                                    Apakah Anda yakin ingin menghapus jurnal ini? Tindakan ini tidak dapat dibatalkan.
                                                </AlertDialogDescription>
                                            </AlertDialogHeader>
                                            <AlertDialogFooter>
                                                <AlertDialogCancel>Batal</AlertDialogCancel>
                                                <AlertDialogAction
                                                    onclick={() => deleteJournal(journal.id)}
                                                    class="bg-destructive text-destructive-foreground hover:bg-destructive/90"
                                                >
                                                    Hapus
                                                </AlertDialogAction>
                                            </AlertDialogFooter>
                                        </AlertDialogContent>
                                    </AlertDialog>
                                </div>
                            </div>
                        </CardHeader>
                        <CardContent>
                            <CardDescription class="line-clamp-3 text-base">
                                {journal.content}
                            </CardDescription>
                            <div class="mt-4">
                                <Button variant="link" size="sm" href={route('journals.show', journal.id)} class="p-0 h-auto">
                                    Baca selengkapnya →
                                </Button>
                            </div>
                        </CardContent>
                    </Card>
                {/each}
            </div>

            <!-- Pagination -->
            {#if journals.last_page > 1}
                <div class="mt-8 flex items-center justify-center gap-2">
                    {#each journals.links as link}
                        {#if link.url === null}
                            <span
                                class="px-3 py-2 text-sm text-muted-foreground"
                            >
                                {@html link.label}
                            </span>
                        {:else}
                            <Button
                                variant={link.active ? 'default' : 'outline'}
                                size="sm"
                                href={link.url}
                                disabled={link.active}
                            >
                                {@html link.label}
                            </Button>
                        {/if}
                    {/each}
                </div>
            {/if}
        {/if}
    </div>
</AppLayout>

