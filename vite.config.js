import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import dotenv from 'dotenv';

export default defineConfig(({ mode }) => {
  dotenv.config({ path: `./.env.${mode}` }); // Load environment variables based on the current mode

  return {
    plugins: [
      laravel({
        input: ['resources/css/app.css', 'resources/js/app.js'],
        refresh: true,
      }),
    ],
  };
});
