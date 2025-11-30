<script lang="ts">
    import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
    import { buttonVariants } from '@/components/ui/button';
    import AppLayout from '@/layouts/AppLayout.svelte';
    import { Link } from '@inertiajs/svelte';
    import { type BreadcrumbItem } from '@/types';
    import { Heart, PlayCircle, Wind, Sparkles, BookOpen } from 'lucide-svelte';

    const breadcrumbs: BreadcrumbItem[] = [
        {
            title: 'Beranda',
            href: route('dashboard'),
        },
        {
            title: 'Mindfulness',
            href: route('mindfulness'),
        },
    ];
</script>

<svelte:head>
    <title>Mindfulness - MeNu Care</title>
</svelte:head>

<AppLayout {breadcrumbs}>
    <div class="space-y-6 px-4 pt-4">
        <!-- Header -->
        <div>
            <h1 class="text-3xl font-bold tracking-tight">Mindfulness</h1>
            <p class="text-muted-foreground mt-2">
                Konten mindfulness yang disesuaikan dengan kondisi stres Anda
            </p>
        </div>

        <!-- Features Grid -->
        <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
            <!-- Short Meditation -->
            <Card>
                <CardHeader>
                    <div class="flex items-center gap-2">
                        <div class="rounded-lg bg-primary/10 p-2">
                            <PlayCircle class="h-5 w-5 text-primary" />
                        </div>
                        <CardTitle class="text-lg">Meditasi Singkat</CardTitle>
                    </div>
                    <CardDescription>
                        Video meditasi singkat untuk menenangkan pikiran dan mengurangi stres
                    </CardDescription>
                </CardHeader>
                <CardContent>
                    <Link href={route('meditation')} class={buttonVariants({ variant: 'outline' }) + ' w-full'}>
                        Mulai Meditasi
                    </Link>
                </CardContent>
            </Card>

            <!-- Deep Breathing -->
            <Card>
                <CardHeader>
                    <div class="flex items-center gap-2">
                        <div class="rounded-lg bg-primary/10 p-2">
                            <Wind class="h-5 w-5 text-primary" />
                        </div>
                        <CardTitle class="text-lg">Relaksasi Nafas Dalam</CardTitle>
                    </div>
                    <CardDescription>
                        Latihan pernapasan dalam untuk membantu relaksasi dan mengurangi kecemasan
                    </CardDescription>
                </CardHeader>
                <CardContent>
                    <Link href={route('breathing')} class={buttonVariants({ variant: 'outline' }) + ' w-full'}>
                        Mulai Relaksasi
                    </Link>
                </CardContent>
            </Card>

            <!-- Positive Affirmation -->
            <Card>
                <CardHeader>
                    <div class="flex items-center gap-2">
                        <div class="rounded-lg bg-primary/10 p-2">
                            <Sparkles class="h-5 w-5 text-primary" />
                        </div>
                        <CardTitle class="text-lg">Afirmasi Positif</CardTitle>
                    </div>
                    <CardDescription>
                        Video afirmasi positif untuk meningkatkan motivasi dan semangat
                    </CardDescription>
                </CardHeader>
                <CardContent>
                    <Link href={route('affirmation')} class={buttonVariants({ variant: 'outline' }) + ' w-full'}>
                        Mulai Afirmasi
                    </Link>
                </CardContent>
            </Card>

            <!-- Tips and Education -->
            <Card class="md:col-span-2 lg:col-span-3">
                <CardHeader>
                    <div class="flex items-center gap-2">
                        <div class="rounded-lg bg-primary/10 p-2">
                            <BookOpen class="h-5 w-5 text-primary" />
                        </div>
                        <CardTitle class="text-lg">Tips dan Edukasi Mental Health</CardTitle>
                    </div>
                    <CardDescription>
                        Artikel-artikel tentang cara mengatasi stres dan menjaga kesehatan mental
                    </CardDescription>
                </CardHeader>
                <CardContent>
                    <Link href={route('articles')} class={buttonVariants({ variant: 'outline' }) + ' w-full'}>
                        Baca Artikel
                    </Link>
                </CardContent>
            </Card>
        </div>
    </div>
</AppLayout>

