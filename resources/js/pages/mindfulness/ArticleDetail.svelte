<script lang="ts">
    import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
    import { Badge } from '@/components/ui/badge';
    import { buttonVariants } from '@/components/ui/button';
    import AppLayout from '@/layouts/AppLayout.svelte';
    import { Link } from '@inertiajs/svelte';
    import { type BreadcrumbItem } from '@/types';
    import { ArrowLeft, Image as ImageIcon } from 'lucide-svelte';
    import { marked } from 'marked';

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

    interface Props {
        article: Article;
        category: string;
    }

    let { article, category }: Props = $props();

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
        {
            title: article.title,
            href: route('articles.show', { id: article.id }),
        },
    ];

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

    function renderMarkdown(content: string): string {
        const result = marked.parse(content, {
            breaks: true,
            gfm: true,
        });
        return typeof result === 'string' ? result : String(result);
    }

    let htmlContent = $derived(renderMarkdown(article.content));
</script>

<svelte:head>
    <title>{article.title} - MeNu Care</title>
</svelte:head>

<AppLayout {breadcrumbs}>
    <div class="space-y-6 px-4 pt-4">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold tracking-tight">{article.title}</h1>
                <p class="text-muted-foreground mt-2">
                    Dipublikasikan pada {formatDate(article.created_at)}
                </p>
            </div>
            <Link href={route('articles')} class={buttonVariants({ variant: 'outline' })}>
                <ArrowLeft class="mr-2 h-4 w-4" />
                Kembali
            </Link>
        </div>

        <Card>
            <CardContent class="pt-6">
                <div class="space-y-6">
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

                    <div class="flex items-center gap-2">
                        <Badge variant="outline">{category}</Badge>
                        {#if article.tags && article.tags.length > 0}
                            {#each article.tags as tag}
                                <Badge variant="secondary">{tag}</Badge>
                            {/each}
                        {/if}
                    </div>

                    <div class="prose prose-lg max-w-none dark:prose-invert">
                        {@html htmlContent}
                    </div>
                </div>
            </CardContent>
        </Card>
    </div>
</AppLayout>

