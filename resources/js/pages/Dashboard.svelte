<script lang="ts">
    import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
    import { Badge } from '@/components/ui/badge';
    import { Button, buttonVariants } from '@/components/ui/button';
    import AppLayout from '@/layouts/AppLayout.svelte';
    import { Link } from '@inertiajs/svelte';
    import { AlertCircle, CheckCircle2, Info, TrendingUp, BookOpen, Heart } from 'lucide-svelte';
    import { type BreadcrumbItem } from '@/types';

    interface LatestQuiz {
        score: number;
        category: 'rendah' | 'sedang' | 'berat';
        date: string;
        created_at: string;
    }

    interface Props {
        latestQuiz: LatestQuiz | null;
    }

    let { latestQuiz }: Props = $props();

    const breadcrumbs: BreadcrumbItem[] = [
        {
            title: 'Beranda',
            href: route('dashboard'),
        },
    ];

    // Category colors and labels
    const categoryConfig = {
        rendah: {
            label: 'Rendah',
            color: 'bg-green-500',
            textColor: 'text-green-700',
            bgColor: 'bg-green-50',
            borderColor: 'border-green-200',
            icon: CheckCircle2,
            description: 'Tingkat stres Anda rendah. Pertahankan kondisi ini!',
        },
        sedang: {
            label: 'Sedang',
            color: 'bg-yellow-500',
            textColor: 'text-yellow-700',
            bgColor: 'bg-yellow-50',
            borderColor: 'border-yellow-200',
            icon: Info,
            description: 'Tingkat stres Anda sedang. Pertimbangkan aktivitas mindfulness.',
        },
        berat: {
            label: 'Berat',
            color: 'bg-red-500',
            textColor: 'text-red-700',
            bgColor: 'bg-red-50',
            borderColor: 'border-red-200',
            icon: AlertCircle,
            description: 'Tingkat stres Anda tinggi. Sangat disarankan untuk konsultasi profesional.',
        },
    };

    function formatDate(dateString: string): string {
        const date = new Date(dateString);
        return date.toLocaleDateString('id-ID', {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric',
        });
    }

    function getCategoryConfig(category: 'rendah' | 'sedang' | 'berat') {
        return categoryConfig[category];
    }
</script>

<svelte:head>
    <title>Beranda - MeNu Care</title>
</svelte:head>

<AppLayout {breadcrumbs}>
    <div class="space-y-6 px-4 pt-4">
        <!-- Welcome Section -->
        <div>
            <h1 class="text-3xl font-bold tracking-tight">Selamat Datang</h1>
            <p class="text-muted-foreground mt-2">
                Pantau kesehatan mental Anda dengan mudah
            </p>
        </div>

        {#if latestQuiz}
            {@const config = getCategoryConfig(latestQuiz.category)}
            {@const CategoryIcon = config.icon}

            <!-- Last Assessment Card -->
            <Card class="border-2 {config.borderColor}">
                <CardHeader>
                    <div class="flex items-center justify-between">
                        <CardTitle class="text-2xl">Assessment Terakhir</CardTitle>
                        <Badge variant="outline" class="text-lg px-4 py-2">
                            Skor: {latestQuiz.score} / 40
                        </Badge>
                    </div>
                    <CardDescription>
                        {formatDate(latestQuiz.date)}
                    </CardDescription>
                </CardHeader>
                <CardContent>
                    <div class="flex items-start gap-6">
                        <div class="flex h-20 w-20 shrink-0 items-center justify-center rounded-full {config.bgColor} {config.borderColor} border-2">
                            <CategoryIcon class="h-10 w-10 {config.textColor}" />
                        </div>
                        <div class="flex-1">
                            <h3 class="text-xl font-semibold {config.textColor} mb-2">
                                Tingkat Stres: {config.label}
                            </h3>
                            <p class="text-muted-foreground mb-4">
                                {config.description}
                            </p>
                            <div class="flex gap-2">
                                <Link href={route('progress')} class={buttonVariants({ variant: 'outline' })}>
                                    <TrendingUp class="mr-2 h-4 w-4" />
                                    Lihat Progres
                                </Link>
                                <Link href={route('quiz')} class={buttonVariants({ variant: 'outline' })}>
                                    Assessment Baru
                                </Link>
                            </div>
                        </div>
                    </div>
                </CardContent>
            </Card>
        {:else}
            <!-- No Assessment Card -->
            <Card>
                <CardHeader>
                    <CardTitle>Belum Ada Assessment</CardTitle>
                    <CardDescription>
                        Mulai assessment pertama Anda untuk melihat tingkat stres
                    </CardDescription>
                </CardHeader>
                <CardContent>
                    <Link href={route('quiz')} class={buttonVariants()}>
                        Mulai Assessment
                    </Link>
                </CardContent>
            </Card>
        {/if}

        <!-- Quick Actions Grid -->
        <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
            <Card>
                <CardHeader>
                    <div class="flex items-center gap-2">
                        <div class="rounded-lg bg-primary/10 p-2">
                            <TrendingUp class="h-5 w-5 text-primary" />
                        </div>
                        <CardTitle class="text-lg">Cek Progres</CardTitle>
                    </div>
                    <CardDescription>
                        Lihat perkembangan tingkat stres Anda dari waktu ke waktu
                    </CardDescription>
                </CardHeader>
                <CardContent>
                    <Link href={route('progress')} class={buttonVariants({ variant: 'outline' }) + ' w-full'}>
                        Lihat Progres
                    </Link>
                </CardContent>
            </Card>

            <Card>
                <CardHeader>
                    <div class="flex items-center gap-2">
                        <div class="rounded-lg bg-primary/10 p-2">
                            <BookOpen class="h-5 w-5 text-primary" />
                        </div>
                        <CardTitle class="text-lg">Jurnal Harian</CardTitle>
                    </div>
                    <CardDescription>
                        Tulis jurnal untuk mencatat perasaan dan pikiran Anda
                    </CardDescription>
                </CardHeader>
                <CardContent>
                    <Link href={route('journals.index')} class={buttonVariants({ variant: 'outline' }) + ' w-full'}>
                        Buka Jurnal
                    </Link>
                </CardContent>
            </Card>

            <Card>
                <CardHeader>
                    <div class="flex items-center gap-2">
                        <div class="rounded-lg bg-primary/10 p-2">
                            <Heart class="h-5 w-5 text-primary" />
                        </div>
                        <CardTitle class="text-lg">Mindfulness</CardTitle>
                    </div>
                    <CardDescription>
                        Akses konten mindfulness yang disesuaikan dengan kondisi Anda
                    </CardDescription>
                </CardHeader>
                <CardContent>
                    <Link href={route('mindfulness')} class={buttonVariants({ variant: 'outline' }) + ' w-full'}>
                        Buka Mindfulness
                    </Link>
                </CardContent>
            </Card>
        </div>
    </div>
</AppLayout>
