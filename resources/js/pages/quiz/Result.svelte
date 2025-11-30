<script lang="ts">
    import { Button } from '@/components/ui/button';
    import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
    import { Alert, AlertDescription, AlertTitle } from '@/components/ui/alert';
    import { Badge } from '@/components/ui/badge';
    import AppLayout from '@/layouts/AppLayout.svelte';
    import { router } from '@inertiajs/svelte';
    import { AlertCircle, CheckCircle2, ExternalLink, Info } from 'lucide-svelte';

    interface Recommendation {
        title: string;
        description: string;
        recommendations: string[];
        showWarning?: boolean;
        warning?: string;
        showConsultationLinks?: boolean;
        consultationLinks?: Array<{ name: string; url: string }>;
    }

    interface QuizResult {
        score: number;
        category: 'rendah' | 'sedang' | 'berat';
        recommendations: Recommendation;
    }

    interface Props {
        result: QuizResult;
    }

    let { result }: Props = $props();

    // Category colors and labels
    const categoryConfig = {
        rendah: {
            label: 'Rendah',
            color: 'bg-green-500',
            textColor: 'text-green-700',
            bgColor: 'bg-green-50',
            borderColor: 'border-green-200',
            icon: CheckCircle2,
        },
        sedang: {
            label: 'Sedang',
            color: 'bg-yellow-500',
            textColor: 'text-yellow-700',
            bgColor: 'bg-yellow-50',
            borderColor: 'border-yellow-200',
            icon: Info,
        },
        berat: {
            label: 'Berat',
            color: 'bg-red-500',
            textColor: 'text-red-700',
            bgColor: 'bg-red-50',
            borderColor: 'border-red-200',
            icon: AlertCircle,
        },
    };

    const config = categoryConfig[result.category];
    const CategoryIcon = config.icon;

    function goToHomepage() {
        router.visit(route('dashboard'));
    }
</script>

<svelte:head>
    <title>Hasil Assessment</title>
</svelte:head>

<AppLayout breadcrumbs={[{ title: 'Hasil Assessment', href: route('quiz.result') }]}>
    <div class="container mx-auto max-w-4xl px-4 py-8">
        <!-- Score Card -->
        <Card class="mb-6">
            <CardHeader>
                <div class="flex items-center justify-between">
                    <CardTitle class="text-2xl">Hasil Assessment Anda</CardTitle>
                    <Badge variant="outline" class="text-lg px-4 py-2">
                        Skor: {result.score} / 40
                    </Badge>
                </div>
            </CardHeader>
            <CardContent>
                <div class="flex items-center gap-4">
                    <div class="flex h-16 w-16 items-center justify-center rounded-full {config.bgColor} {config.borderColor} border-2">
                        <CategoryIcon class="h-8 w-8 {config.textColor}" />
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold {config.textColor}">
                            Tingkat Stres: {config.label}
                        </h3>
                        <p class="text-muted-foreground">{result.recommendations.description}</p>
                    </div>
                </div>
            </CardContent>
        </Card>

        <!-- Recommendations Card -->
        <Card class="mb-6">
            <CardHeader>
                <CardTitle>Rekomendasi</CardTitle>
                <CardDescription>
                    Berikut adalah beberapa rekomendasi yang dapat membantu Anda mengelola tingkat stres:
                </CardDescription>
            </CardHeader>
            <CardContent>
                <ul class="space-y-3">
                    {#each result.recommendations.recommendations as recommendation}
                        <li class="flex items-start gap-3">
                            <CheckCircle2 class="mt-0.5 h-5 w-5 text-green-500 shrink-0" />
                            <span class="text-sm">{recommendation}</span>
                        </li>
                    {/each}
                </ul>
            </CardContent>
        </Card>

        <!-- Warning Alert (for berat category) -->
        {#if result.recommendations.showWarning && result.recommendations.warning}
            <Alert variant="destructive" class="mb-6">
                <AlertCircle class="h-4 w-4" />
                <AlertTitle>Peringatan Penting</AlertTitle>
                <AlertDescription>{result.recommendations.warning}</AlertDescription>
            </Alert>
        {/if}

        <!-- Consultation Links (for berat category) -->
        {#if result.recommendations.showConsultationLinks && result.recommendations.consultationLinks}
            <Card class="mb-6">
                <CardHeader>
                    <CardTitle>Konsultasi Profesional</CardTitle>
                    <CardDescription>
                        Jika Anda mengalami gejala yang mengganggu, pertimbangkan untuk berkonsultasi dengan tenaga kesehatan profesional:
                    </CardDescription>
                </CardHeader>
                <CardContent>
                    <div class="flex flex-wrap gap-4">
                        {#each result.recommendations.consultationLinks as link}
                            <Button
                                variant="outline"
                                href={link.url}
                                target="_blank"
                                rel="noopener noreferrer"
                                class="gap-2"
                            >
                                {link.name}
                                <ExternalLink class="h-4 w-4" />
                            </Button>
                        {/each}
                    </div>
                </CardContent>
            </Card>
        {/if}

        <!-- Action Button -->
        <div class="flex justify-center">
            <Button size="lg" onclick={goToHomepage} class="min-w-[200px]">
                Kembali ke Beranda
            </Button>
        </div>
    </div>
</AppLayout>

