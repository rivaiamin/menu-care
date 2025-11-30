<script lang="ts">
    import { Button } from '@/components/ui/button';
    import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
    import { Badge } from '@/components/ui/badge';
    import AppLayout from '@/layouts/AppLayout.svelte';
    import { Link } from '@inertiajs/svelte';
    import { Calendar, Edit, ArrowLeft } from 'lucide-svelte';
    import { type BreadcrumbItem } from '@/types';
    import { AlertDialog, AlertDialogAction, AlertDialogCancel, AlertDialogContent, AlertDialogDescription, AlertDialogFooter, AlertDialogHeader, AlertDialogTitle, AlertDialogTrigger } from '@/components/ui/alert-dialog';
    import { router } from '@inertiajs/svelte';
    import { Trash2 } from 'lucide-svelte';

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
            title: journal.title || 'Detail Jurnal',
            href: route('journals.show', journal.id),
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

    function deleteJournal() {
        router.delete(route('journals.destroy', journal.id), {
            onSuccess: () => {
                router.visit(route('journals.index'));
            },
        });
    }
</script>

<svelte:head>
    <title>{journal.title || 'Detail Jurnal'}</title>
</svelte:head>

<AppLayout {breadcrumbs}>
    <div class="container mx-auto max-w-4xl px-4 py-8">
        <!-- Back Button -->
        <div class="mb-6">
            <Button variant="ghost" href={route('journals.index')}>
                <ArrowLeft class="mr-2 h-4 w-4" />
                Kembali ke Daftar Jurnal
            </Button>
        </div>

        <Card>
            <CardHeader>
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <div class="flex items-center gap-3 mb-3">
                            <Calendar class="h-4 w-4 text-muted-foreground" />
                            <span class="text-sm text-muted-foreground">
                                {formatDate(journal.date)}
                            </span>
                            <Badge variant="outline" class="text-base">
                                {getMoodLabel(journal.mood)}
                            </Badge>
                        </div>
                        {#if journal.title}
                            <CardTitle class="text-2xl mb-2">{journal.title}</CardTitle>
                        {:else}
                            <CardTitle class="text-2xl mb-2">Jurnal Harian</CardTitle>
                        {/if}
                    </div>
                    <div class="flex items-center gap-2">
                        <Button variant="outline" href={route('journals.edit', journal.id)}>
                            <Edit class="mr-2 h-4 w-4" />
                            Edit
                        </Button>
                        <AlertDialog>
                            <AlertDialogTrigger>
                                <Button variant="destructive">
                                    <Trash2 class="mr-2 h-4 w-4" />
                                    Hapus
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
                                        onclick={deleteJournal}
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
                <div class="prose prose-slate dark:prose-invert max-w-none">
                    <p class="whitespace-pre-wrap text-base leading-relaxed">{journal.content}</p>
                </div>
            </CardContent>
        </Card>
    </div>
</AppLayout>

