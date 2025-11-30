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
            <Card class="border-2 {config.borderColor} overflow-hidden {config.bgColor} shadow-md">
                <div class="relative">
                    <!-- Header Section -->
                    <CardHeader class="pb-5">
                        <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                            <div class="flex-1 space-y-1">
                                <CardTitle class="text-xl sm:text-2xl font-bold">
                                    Assessment Terakhir
                                </CardTitle>
                                <CardDescription class="text-sm sm:text-base font-medium">
                                    {formatDate(latestQuiz.date)}
                                </CardDescription>
                            </div>
                            <Badge 
                                variant="outline" 
                                class="text-sm sm:text-base font-bold px-4 py-2.5 w-fit {config.borderColor} {config.textColor} bg-white/90 backdrop-blur-sm shadow-sm"
                            >
                                Skor: {latestQuiz.score} / 40
                            </Badge>
                        </div>
                    </CardHeader>

                    <!-- Content Section -->
                    <CardContent class="pt-0 pb-6 px-6">
                        <div class="flex flex-col items-center text-center sm:flex-row sm:items-start sm:text-left gap-6">
                            <!-- Icon Section -->
                            <div class="flex-shrink-0">
                                <div class="flex h-20 w-20 sm:h-24 sm:w-24 items-center justify-center rounded-full {config.bgColor} {config.borderColor} border-[3px] shadow-lg ring-2 ring-white/50">
                                    <CategoryIcon class="h-10 w-10 sm:h-12 sm:w-12 {config.textColor}" />
                                </div>
                            </div>

                            <!-- Text Section -->
                            <div class="flex-1 min-w-0 space-y-4">
                                <div class="space-y-2">
                                    <h3 class="text-lg sm:text-xl font-bold {config.textColor}">
                                        Tingkat Stres: {config.label}
                                    </h3>
                                    <p class="text-sm sm:text-base text-muted-foreground leading-relaxed max-w-2xl">
                                        {config.description}
                                    </p>
                                </div>

                                <!-- Action Buttons -->
                                <div class="flex flex-col sm:flex-row gap-2.5 pt-1">
                                    <Link 
                                        href={route('progress')} 
                                        class={buttonVariants({ variant: 'default' }) + ' w-full sm:w-auto justify-center shadow-sm hover:shadow-md transition-shadow'}
                                    >
                                        <TrendingUp class="mr-2 h-4 w-4" />
                                        Lihat Progres
                                    </Link>
                                    <Link 
                                        href={route('quiz')} 
                                        class={buttonVariants({ variant: 'outline' }) + ' w-full sm:w-auto justify-center border-2 hover:bg-accent/50 transition-colors'}
                                    >
                                        Assessment Baru
                                    </Link>
                                </div>
                            </div>
                        </div>
                    </CardContent>
                </div>
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
