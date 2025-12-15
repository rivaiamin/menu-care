import { createInertiaApp } from '@inertiajs/svelte';
import createServer from '@inertiajs/svelte/server';
import { render } from 'svelte/server';

createServer((page) =>
    createInertiaApp({
        page,
        resolve: async (name) => {
            const pages = import.meta.glob<{ default: any }>('./pages/**/*.svelte', { eager: false });
            const module = await pages[`./pages/${name}.svelte`]();
            return module as any;
        },
        setup({ App, props }) {
            return render(App, { props });
        },
    }),
);
