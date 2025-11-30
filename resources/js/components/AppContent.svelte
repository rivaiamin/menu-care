<script lang="ts">
    import { SidebarInset } from '@/components/ui/sidebar';
    import type { Snippet } from 'svelte';

    type Props = {
        variant?: 'header' | 'sidebar';
        class?: string;
        children: Snippet;
    };

    let { variant, class: className, children }: Props = $props();
</script>

{#if variant === 'sidebar'}
    <SidebarInset class={className}>
        <div class="mx-auto w-full max-w-7xl pb-20 md:pb-0">
            {@render children?.()}
        </div>
    </SidebarInset>
{:else}
    <main class="mx-auto flex h-full w-full max-w-7xl flex-1 flex-col gap-4 rounded-xl pb-20 md:pb-0 {className}">
        {@render children?.()}
    </main>
{/if}
