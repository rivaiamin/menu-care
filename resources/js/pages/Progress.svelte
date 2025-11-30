<script lang="ts">
    import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
    import { Badge } from '@/components/ui/badge';
    import AppLayout from '@/layouts/AppLayout.svelte';
    import { type BreadcrumbItem } from '@/types';
    import { onMount } from 'svelte';
    import axios from 'axios';
    import {
        Chart,
        CategoryScale,
        LinearScale,
        PointElement,
        LineElement,
        BarElement,
        LineController,
        BarController,
        Title,
        Tooltip,
        Legend,
        type ChartConfiguration,
    } from 'chart.js';

    // Register Chart.js components
    Chart.register(
        CategoryScale,
        LinearScale,
        PointElement,
        LineElement,
        BarElement,
        LineController,
        BarController,
        Title,
        Tooltip,
        Legend
    );

    interface ScoreData {
        date: string;
        score: number;
    }

    interface CategoryDistribution {
        rendah: number;
        sedang: number;
        berat: number;
    }

    interface ProgressData {
        scoreProgression: ScoreData[];
        categoryDistribution: CategoryDistribution;
    }

    const breadcrumbs: BreadcrumbItem[] = [
        {
            title: 'Cek Progres',
            href: route('progress'),
        },
    ];

    let progressData = $state<ProgressData | null>(null);
    let loading = $state(true);
    let error = $state<string | null>(null);
    let lineChartCanvas: HTMLCanvasElement | null = $state(null);
    let barChartCanvas: HTMLCanvasElement | null = $state(null);
    let lineChartInstance: Chart | null = $state(null);
    let barChartInstance: Chart | null = $state(null);

    onMount(async () => {
        try {
            const response = await axios.get(route('progress.api'));
            progressData = response.data;
            loading = false;
        } catch (err) {
            error = 'Gagal memuat data progres';
            loading = false;
            console.error('Error loading progress:', err);
        }
    });

    // Cleanup charts on unmount
    $effect(() => {
        return () => {
            if (lineChartInstance) {
                lineChartInstance.destroy();
                lineChartInstance = null;
            }
            if (barChartInstance) {
                barChartInstance.destroy();
                barChartInstance = null;
            }
        };
    });

    function formatDate(dateString: string): string {
        const date = new Date(dateString);
        return date.toLocaleDateString('id-ID', {
            day: 'numeric',
            month: 'short',
        });
    }

    function getCategoryLabel(category: 'rendah' | 'sedang' | 'berat'): string {
        const labels = {
            rendah: 'Rendah',
            sedang: 'Sedang',
            berat: 'Berat',
        };
        return labels[category];
    }

    function getCategoryColor(category: 'rendah' | 'sedang' | 'berat'): string {
        const colors = {
            rendah: 'bg-green-500',
            sedang: 'bg-yellow-500',
            berat: 'bg-red-500',
        };
        return colors[category];
    }

    function initializeCharts() {
        if (!progressData || !lineChartCanvas || !barChartCanvas) return;

        // Prevent re-initialization if charts already exist
        if (lineChartInstance || barChartInstance) return;

        // Line Chart - Score Progression
        const lineChartConfig: ChartConfiguration<'line'> = {
            type: 'line',
            data: {
                labels: progressData.scoreProgression.map((item) => formatDate(item.date)),
                datasets: [
                    {
                        label: 'Skor Stres',
                        data: progressData.scoreProgression.map((item) => item.score),
                        borderColor: 'rgb(59, 130, 246)',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        borderWidth: 2,
                        tension: 0.4,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                    },
                ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: (context) => {
                                return `Skor: ${context.parsed.y} / 40`;
                            },
                        },
                    },
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 40,
                        title: {
                            display: true,
                            text: 'Skor',
                        },
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Tanggal',
                        },
                    },
                },
            },
        };

        lineChartInstance = new Chart(lineChartCanvas, lineChartConfig);

        // Bar Chart - Category Distribution
        const barChartConfig: ChartConfiguration<'bar'> = {
            type: 'bar',
            data: {
                labels: ['Rendah', 'Sedang', 'Berat'],
                datasets: [
                    {
                        label: 'Jumlah Assessment',
                        data: [
                            progressData.categoryDistribution.rendah,
                            progressData.categoryDistribution.sedang,
                            progressData.categoryDistribution.berat,
                        ],
                        backgroundColor: [
                            'rgba(34, 197, 94, 0.8)', // green
                            'rgba(234, 179, 8, 0.8)', // yellow
                            'rgba(239, 68, 68, 0.8)', // red
                        ],
                        borderColor: [
                            'rgb(34, 197, 94)',
                            'rgb(234, 179, 8)',
                            'rgb(239, 68, 68)',
                        ],
                        borderWidth: 1,
                    },
                ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: (context) => {
                                return `Jumlah: ${context.parsed.y}`;
                            },
                        },
                    },
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1,
                        },
                        title: {
                            display: true,
                            text: 'Jumlah',
                        },
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Kategori',
                        },
                    },
                },
            },
        };

        barChartInstance = new Chart(barChartCanvas, barChartConfig);
    }

    // Watch for canvas elements to be available and initialize charts once
    $effect(() => {
        if (
            lineChartCanvas &&
            barChartCanvas &&
            progressData &&
            progressData.scoreProgression.length > 0 &&
            !lineChartInstance &&
            !barChartInstance
        ) {
            initializeCharts();
        }
    });
</script>

<svelte:head>
    <title>Cek Progres - MeNu Care</title>
</svelte:head>

<AppLayout {breadcrumbs}>
    <div class="space-y-6 px-4 pt-4">
        <div>
            <h1 class="text-3xl font-bold tracking-tight">Cek Progres</h1>
            <p class="text-muted-foreground mt-2">
                Pantau perkembangan tingkat stres Anda dari waktu ke waktu
            </p>
        </div>

        {#if loading}
            <Card>
                <CardContent class="flex items-center justify-center py-12">
                    <p class="text-muted-foreground">Memuat data...</p>
                </CardContent>
            </Card>
        {:else if error}
            <Card>
                <CardContent class="flex items-center justify-center py-12">
                    <p class="text-destructive">{error}</p>
                </CardContent>
            </Card>
        {:else if progressData && progressData.scoreProgression.length > 0}
            <!-- Score Progression Chart -->
            <Card>
                <CardHeader>
                    <CardTitle>Perkembangan Skor Stres</CardTitle>
                    <CardDescription>
                        Grafik menunjukkan perubahan skor stres Anda dari waktu ke waktu (0-40)
                    </CardDescription>
                </CardHeader>
                <CardContent>
                    <div class="h-[400px] w-full">
                        <canvas bind:this={lineChartCanvas}></canvas>
                    </div>
                </CardContent>
            </Card>

            <!-- Category Distribution Chart -->
            <Card>
                <CardHeader>
                    <CardTitle>Distribusi Kategori Stres</CardTitle>
                    <CardDescription>
                        Jumlah assessment berdasarkan kategori tingkat stres
                    </CardDescription>
                </CardHeader>
                <CardContent>
                    <div class="h-[400px] w-full">
                        <canvas bind:this={barChartCanvas}></canvas>
                    </div>
                </CardContent>
            </Card>

            <!-- Data Table -->
            <Card>
                <CardHeader>
                    <CardTitle>Riwayat Assessment</CardTitle>
                    <CardDescription>
                        Daftar lengkap hasil assessment Anda
                    </CardDescription>
                </CardHeader>
                <CardContent>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b">
                                    <th class="text-left p-2 font-medium">Tanggal</th>
                                    <th class="text-left p-2 font-medium">Skor</th>
                                    <th class="text-left p-2 font-medium">Kategori</th>
                                </tr>
                            </thead>
                            <tbody>
                                {#each [...progressData.scoreProgression].reverse() as item}
                                    {@const category = item.score <= 13 ? 'rendah' : item.score <= 26 ? 'sedang' : 'berat'}
                                    <tr class="border-b">
                                        <td class="p-2">{formatDate(item.date)}</td>
                                        <td class="p-2 font-medium">{item.score} / 40</td>
                                        <td class="p-2">
                                            <Badge variant="outline" class={getCategoryColor(category)}>
                                                {getCategoryLabel(category)}
                                            </Badge>
                                        </td>
                                    </tr>
                                {/each}
                            </tbody>
                        </table>
                    </div>
                </CardContent>
            </Card>
        {:else}
            <Card>
                <CardContent class="flex flex-col items-center justify-center py-12">
                    <p class="text-muted-foreground mb-4">Belum ada data assessment</p>
                    <p class="text-sm text-muted-foreground">
                        Selesaikan assessment pertama Anda untuk melihat progres
                    </p>
                </CardContent>
            </Card>
        {/if}
    </div>
</AppLayout>
