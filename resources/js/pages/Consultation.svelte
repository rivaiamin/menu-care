<script lang="ts">
    import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
    import { buttonVariants } from '@/components/ui/button';
    import { Alert, AlertDescription, AlertTitle } from '@/components/ui/alert';
    import AppLayout from '@/layouts/AppLayout.svelte';
    import { Link } from '@inertiajs/svelte';
    import { type BreadcrumbItem } from '@/types';
    import { AlertTriangle, ExternalLink, ArrowLeft, Phone, Stethoscope } from 'lucide-svelte';

    const breadcrumbs: BreadcrumbItem[] = [
        {
            title: 'Beranda',
            href: route('dashboard'),
        },
        {
            title: 'Konsultasi',
            href: route('consultation'),
        },
    ];
</script>

<svelte:head>
    <title>Konsultasi - MeNu Care</title>
</svelte:head>

<AppLayout {breadcrumbs}>
    <div class="space-y-6 px-4 pt-4">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold tracking-tight">Konsultasi Profesional</h1>
                <p class="text-muted-foreground mt-2">
                    Dapatkan bantuan profesional untuk kesehatan mental Anda
                </p>
            </div>
            <Link href={route('dashboard')} class={buttonVariants({ variant: 'outline' })}>
                <ArrowLeft class="mr-2 h-4 w-4" />
                Kembali
            </Link>
        </div>

        <!-- Warning Alert -->
        <Alert variant="destructive">
            <AlertTriangle class="h-4 w-4" />
            <AlertTitle>Penting</AlertTitle>
            <AlertDescription>
                Jika Anda mengalami gejala berat seperti gangguan tidur yang parah, merasa tidak dapat mengendalikan diri, atau memiliki pikiran untuk menyakiti diri sendiri atau orang lain, segera cari bantuan profesional.
            </AlertDescription>
        </Alert>

        <!-- When to Seek Help -->
        <Card>
            <CardHeader>
                <CardTitle>Kapan Harus Mencari Bantuan Profesional?</CardTitle>
                <CardDescription>
                    Kenali tanda-tanda yang memerlukan konsultasi segera
                </CardDescription>
            </CardHeader>
            <CardContent>
                <ul class="list-disc space-y-2 pl-6 text-muted-foreground">
                    <li>Tingkat stres yang sangat tinggi dan berkelanjutan</li>
                    <li>Gangguan tidur yang parah dan berlangsung lama</li>
                    <li>Merasa tidak dapat mengendalikan emosi atau pikiran</li>
                    <li>Pikiran untuk menyakiti diri sendiri atau orang lain</li>
                    <li>Kesulitan melakukan aktivitas sehari-hari</li>
                    <li>Perasaan putus asa atau tidak berharga yang berkelanjutan</li>
                    <li>Perubahan drastis dalam pola makan atau berat badan</li>
                    <li>Kesulitan berkonsentrasi atau membuat keputusan</li>
                </ul>
            </CardContent>
        </Card>

        <!-- Recommended Steps -->
        <Card>
            <CardHeader>
                <CardTitle>Langkah yang Disarankan</CardTitle>
                <CardDescription>
                    Ikuti langkah-langkah berikut untuk mendapatkan bantuan
                </CardDescription>
            </CardHeader>
            <CardContent class="space-y-4">
                <div class="space-y-2">
                    <h3 class="font-semibold">1. Konsultasi Online</h3>
                    <p class="text-sm text-muted-foreground">
                        Gunakan platform konsultasi online untuk berbicara dengan profesional kesehatan mental dari kenyamanan rumah Anda.
                    </p>
                </div>
                <div class="space-y-2">
                    <h3 class="font-semibold">2. Konsultasi Langsung</h3>
                    <p class="text-sm text-muted-foreground">
                        Jika memungkinkan, kunjungi psikolog atau psikiater terdekat untuk konsultasi langsung.
                    </p>
                </div>
                <div class="space-y-2">
                    <h3 class="font-semibold">3. Dukungan Darurat</h3>
                    <p class="text-sm text-muted-foreground">
                        Untuk situasi darurat, hubungi layanan darurat kesehatan mental atau rumah sakit terdekat.
                    </p>
                </div>
            </CardContent>
        </Card>

        <!-- Consultation Platforms -->
        <div class="grid gap-4 md:grid-cols-2">
            <Card>
                <CardHeader>
                    <div class="flex items-center gap-2">
                        <div class="rounded-lg bg-primary/10 p-2">
                            <Stethoscope class="h-5 w-5 text-primary" />
                        </div>
                        <CardTitle class="text-lg">Halodoc</CardTitle>
                    </div>
                    <CardDescription>
                        Platform konsultasi kesehatan online terpercaya di Indonesia
                    </CardDescription>
                </CardHeader>
                <CardContent>
                    <a href="https://www.halodoc.com/tanya-dokter/psikolog" target="_blank" rel="noopener noreferrer" class={buttonVariants({ variant: 'outline' }) + ' w-full'}>
                        Kunjungi Halodoc
                        <ExternalLink class="ml-2 h-4 w-4" />
                    </a>
                </CardContent>
            </Card>

            <Card>
                <CardHeader>
                    <div class="flex items-center gap-2">
                        <div class="rounded-lg bg-primary/10 p-2">
                            <Phone class="h-5 w-5 text-primary" />
                        </div>
                        <CardTitle class="text-lg">Alodokter</CardTitle>
                    </div>
                    <CardDescription>
                        Konsultasi dengan dokter dan psikolog secara online
                    </CardDescription>
                </CardHeader>
                <CardContent>
                    <a href="https://www.alodokter.com/tanya-dokter/psikolog" target="_blank" rel="noopener noreferrer" class={buttonVariants({ variant: 'outline' }) + ' w-full'}>
                        Kunjungi Alodokter
                        <ExternalLink class="ml-2 h-4 w-4" />
                    </a>
                </CardContent>
            </Card>
        </div>

        <!-- Additional Resources -->
        <Card>
            <CardHeader>
                <CardTitle>Sumber Daya Tambahan</CardTitle>
            </CardHeader>
            <CardContent class="space-y-2">
                <p class="text-sm text-muted-foreground">
                    <strong>Layanan Darurat:</strong> 119 (Ambulans) atau 112 (Darurat Umum)
                </p>
                <p class="text-sm text-muted-foreground">
                    <strong>Konseling Krisis:</strong> Hubungi rumah sakit terdekat atau pusat kesehatan mental
                </p>
                <p class="text-sm text-muted-foreground">
                    Ingat: Mencari bantuan adalah tanda kekuatan, bukan kelemahan. Kesehatan mental Anda penting.
                </p>
            </CardContent>
        </Card>
    </div>
</AppLayout>

