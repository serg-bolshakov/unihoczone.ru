import './bootstrap';

// настраиваем (31.01.2025) Inertia.js:
import { createInertiaApp } from '@inertiajs/react';
import { createRoot } from 'react-dom/client';

createInertiaApp({
    resolve: name => import(`./Pages/${name}`).then(module => module.default),
    setup({ el, App, props }) {
        const root = createRoot(el);
        root.render(<App {...props} />);
    },
});