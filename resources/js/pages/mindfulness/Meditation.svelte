<script lang="ts">
    import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
    import { Badge } from '@/components/ui/badge';
    import { buttonVariants } from '@/components/ui/button';
    import AppLayout from '@/layouts/AppLayout.svelte';
    import { Link } from '@inertiajs/svelte';
    import { type BreadcrumbItem } from '@/types';
    import { onMount } from 'svelte';
    import axios from 'axios';
    import { PlayCircle, ArrowLeft, Loader2 } from 'lucide-svelte';

    interface Video {
        id: number;
        title: string;
        description: string | null;
        video_url: string;
        recommended_state: 'rendah' | 'sedang' | 'berat' | 'semua';
        created_at: string;
        updated_at: string;
    }

    interface ContentResponse {
        category: string;
        content: Video[];
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
            title: 'Meditasi Singkat',
            href: route('meditation'),
        },
    ];

    let videos = $state<Video[]>([]);
    let loading = $state(true);
    let error = $state<string | null>(null);
    let category = $state<string>('');

    onMount(async () => {
        try {
            const response = await axios.get<ContentResponse>(route('content.api', { type: 'videos' }));
            videos = response.data.content;
            category = response.data.category;
            loading = false;
        } catch (err) {
            error = 'Gagal memuat video meditasi';
            loading = false;
            console.error('Error loading videos:', err);
        }
    });

    function isYouTubeUrl(url: string): boolean {
        return url.includes('youtube.com') || url.includes('youtu.be');
    }

    function getYouTubeEmbedUrl(url: string): string {
        if (url.includes('youtube.com/watch?v=')) {
            const videoId = url.split('v=')[1]?.split('&')[0];
            return `https://www.youtube.com/embed/${videoId}`;
        }
        if (url.includes('youtu.be/')) {
            const videoId = url.split('youtu.be/')[1]?.split('?')[0];
            return `https://www.youtube.com/embed/${videoId}`;
        }
        return url;
    }
</script>

<svelte:head>
    <title>Meditasi Singkat - MeNu Care</title>
</svelte:head>

<AppLayout {breadcrumbs}>
    <div class="space-y-6 px-4 pt-4">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold tracking-tight">Meditasi Singkat</h1>
                <p class="text-muted-foreground mt-2">
                    Video meditasi singkat untuk menenangkan pikiran
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
        {:else if videos.length === 0}
            <Card>
                <CardContent class="pt-6">
                    <p class="text-muted-foreground">Belum ada video meditasi yang tersedia untuk kategori Anda.</p>
                </CardContent>
            </Card>
        {:else}
            <div class="grid gap-6 md:grid-cols-2">
                {#each videos as video}
                    <Card>
                        <CardHeader>
                            <div class="flex items-start justify-between">
                                <CardTitle class="text-lg">{video.title}</CardTitle>
                                <Badge variant="outline">{category}</Badge>
                            </div>
                            {#if video.description}
                                <CardDescription>{video.description}</CardDescription>
                            {/if}
                        </CardHeader>
                        <CardContent>
                            {#if isYouTubeUrl(video.video_url)}
                                <div class="aspect-video w-full overflow-hidden rounded-lg">
                                    <iframe
                                        src={getYouTubeEmbedUrl(video.video_url)}
                                        class="h-full w-full"
                                        frameborder="0"
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                        allowfullscreen
                                    ></iframe>
                                </div>
                            {:else}
                                <div class="aspect-video w-full overflow-hidden rounded-lg bg-muted">
                                    <video controls class="h-full w-full">
                                        <source src={video.video_url} type="video/mp4" />
                                        Browser Anda tidak mendukung video.
                                    </video>
                                </div>
                            {/if}
                        </CardContent>
                    </Card>
                {/each}
            </div>
        {/if}
    </div>
</AppLayout>

