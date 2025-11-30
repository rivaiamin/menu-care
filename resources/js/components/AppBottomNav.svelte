<script lang="ts">
    import { type NavItem } from '@/types';
    import { Link, page } from '@inertiajs/svelte';
    import { Home, TrendingUp, BookOpen, Heart, User } from 'lucide-svelte';
    import { cn } from '@/lib/utils';

    const navItems: NavItem[] = [
        {
            title: 'Beranda',
            href: '/dashboard',
            icon: Home,
        },
        {
            title: 'Progres',
            href: '/progress',
            icon: TrendingUp,
        },
        {
            title: 'Jurnal',
            href: '/journals',
            icon: BookOpen,
        },
        {
            title: 'Mindfulness',
            href: '/mindfulness',
            icon: Heart,
        },
        {
            title: 'Profil',
            href: '/settings/profile',
            icon: User,
        },
    ];

    const currentPath = $derived($page.url);

    function isActive(href: string, currentPath: string): boolean {
        if (href === '/dashboard') {
            return currentPath === '/dashboard';
        }
        // For other routes, check if current path starts with the href
        // This handles nested routes like /journals, /journals/create, /journals/1, etc.
        return currentPath === href || currentPath.startsWith(href + '/');
    }
</script>

<nav
    class="fixed bottom-0 left-0 right-0 z-50 border-t border-sidebar-border bg-background md:hidden"
    role="navigation"
    aria-label="Bottom navigation"
    style="padding-bottom: max(env(safe-area-inset-bottom, 0px), 0px);"
>
    <div class="flex h-16 items-center justify-around px-2">
        {#each navItems as item (item.title)}
            {@const Icon = item.icon}
            {@const isActiveItem = isActive(item.href, currentPath)}

            <Link
                href={item.href}
                class={cn(
                    'flex flex-col items-center justify-center gap-1 rounded-lg px-3 py-2 text-xs font-medium transition-colors',
                    'hover:bg-sidebar-accent hover:text-sidebar-accent-foreground',
                    'focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2',
                    isActiveItem
                        ? 'text-primary bg-sidebar-accent'
                        : 'text-muted-foreground'
                )}
                aria-current={isActiveItem ? 'page' : undefined}
            >
                <Icon class="h-5 w-5 shrink-0" />
                <span class="text-[10px] leading-tight">{item.title}</span>
            </Link>
        {/each}
    </div>
</nav>

