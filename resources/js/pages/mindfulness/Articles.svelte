<script lang="ts">
    import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
    import { Badge } from '@/components/ui/badge';
    import { buttonVariants } from '@/components/ui/button';
    import AppLayout from '@/layouts/AppLayout.svelte';
    import { Link } from '@inertiajs/svelte';
    import { type BreadcrumbItem } from '@/types';
    import { onMount } from 'svelte';
    import axios from 'axios';
    import { BookOpen, ArrowLeft, Loader2, Image as ImageIcon } from 'lucide-svelte';

    interface Article {
        id: number;
        title: string;
        content: string;
        image_path: string | null;
        tags: string[] | null;
        recommended_state: 'rendah' | 'sedang' | 'berat' | 'semua';
        created_at: string;
        updated_at: string;
    }

    interface ContentResponse {
        category: string;
        content: Article[];
    }

    const breadcrumbs: BreadcrumbItem[] = [
        {
            title: 'Beranda',
            href: route('dashboard'),
        },
        {
            title: 'Mindfulness',
            href: route('mindfulness'),
        },
        {
            title: 'Tips dan Edukasi',
            href: route('articles'),
        },
    ];

    let articles = $state<Article[]>([]);
    let loading = $state(true);
    let error = $state<string | null>(null);
    let category = $state<string>('');

    onMount(async () => {
        try {
            const response = await axios.get<ContentResponse>(route('content.api', { type: 'articles' }));
            articles = response.data.content;
            category = response.data.category;
            loading = false;
        } catch (err) {
            error = 'Gagal memuat artikel';
            loading = false;
            console.error('Error loading articles:', err);
        }
    });

    function getImageUrl(imagePath: string | null): string {
        if (!imagePath) return '';
        if (imagePath.startsWith('http')) return imagePath;
        return `/storage/${imagePath}`;
    }

    function formatDate(dateString: string): string {
        const date = new Date(dateString);
        return date.toLocaleDateString('id-ID', {
            day: 'numeric',
            month: 'long',
            year: 'numeric',
        });
    }
</script>

<svelte:head>
    <title>Tips dan Edukasi Mental Health - MeNu Care</title>
</svelte:head>

<AppLayout {breadcrumbs}>
    <div class="space-y-6 px-4 pt-4">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold tracking-tight">Tips dan Edukasi Mental Health</h1>
                <p class="text-muted-foreground mt-2">
                    Artikel-artikel tentang cara mengatasi stres dan menjaga kesehatan mental
                </p>
            </div>
            <Link href={route('mindfulness')} class={buttonVariants({ variant: 'outline' })}>
                <ArrowLeft class="mr-2 h-4 w-4" />
                Kembali
            </Link>
        </div>

        {#if loading}
            <div class="flex items-center justify-center py-12">
                <Loader2 class="h-8 w-8 animate-spin text-muted-foreground" />
            </div>
        {:else if error}
            <Card>
                <CardContent class="pt-6">
                    <p class="text-destructive">{error}</p>
                </CardContent>
            </Card>
        {:else if articles.length === 0}
            <Card>
                <CardContent class="pt-6">
                    <p class="text-muted-foreground">Belum ada artikel yang tersedia untuk kategori Anda.</p>
                </CardContent>
            </Card>
        {:else}
            <div class="grid gap-6 md:grid-cols-2">
                {#each articles as article}
                    <Card>
                        <CardHeader>
                            <div class="flex items-start justify-between">
                                <CardTitle class="text-lg">{article.title}</CardTitle>
                                <Badge variant="outline">{category}</Badge>
                            </div>
                            <CardDescription>
                                Dipublikasikan pada {formatDate(article.created_at)}
                            </CardDescription>
                        </CardHeader>
                        <CardContent class="space-y-4">
                            {#if article.image_path}
                                <div class="aspect-video w-full overflow-hidden rounded-lg bg-muted">
                                    <img
                                        src={getImageUrl(article.image_path)}
                                        alt={article.title}
                                        class="h-full w-full object-cover"
                                    />
                                </div>
                            {:else}
                                <div class="flex aspect-video w-full items-center justify-center rounded-lg bg-muted">
                                    <ImageIcon class="h-12 w-12 text-muted-foreground" />
                                </div>
                            {/if}
                            <div class="prose prose-sm max-w-none">
                                {@html article.content.substring(0, 200) + (article.content.length > 200 ? '...' : '')}
                            </div>
                        </CardContent>
                    </Card>
                {/each}
            </div>
        {/if}
    </div>
</AppLayout>

