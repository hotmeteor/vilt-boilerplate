# VILT Boilerplate

This VILT ([Vue](https://vuejs.org), [Inertia.js](https://inertiajs.com/), [Laravel](https://laravel.com), [Tailwind](https://tailwindcss.com)) stack boilerplate is a ready-to-go starting point for your next project.

It's actively used and maintained by Adam Campbell [@hotmeteor](https://x.com/hotmeteor).

***

### Requirements

Since this is a Laravel-based boilerplate you'll need a compatible environment.

See the Laravel installation docs for detailed instructions: [https://laravel.com/docs/10.x/installation](https://laravel.com/docs/10.x/installation)

### What's inside

This is a **Laravel 10** app with:

- **Jetstream**, for Teams
- **Vue + Inertia.js + Tailwind** frontend

It also comes with the following tools and packages:

#### PHP

- **Laravel Debugbar** ([barryvdh/laravel-debugbar](https://github.com/barryvdh/laravel-debugbar)): For local debugging (dev only)
- **Laravel IDE Helper** ([barryvdh/laravel-ide-helper](https://github.com/barryvdh/laravel-ide-helper)): For helping with accurate autocompletion in your IDE (dev only)
- **Laravel Sitemap** ([spatie/laravel-sitemap](https://github.com/spatie/laravel-sitemap)): For automatically generating your sitemap once a day
- **Pint** ([laravel/pint](https://laravel.com/docs/10.x/pint)): For style fixing your PHP code
- **Socialite** ([laravel/socialite](https://laravel.com/docs/10.x/socialite)): For providing SSO
- **Telescope** ([laravel/telescope](https://laravel.com/docs/10.x/telescope)): For local debugging

#### Frontend

- **[Prettier](https://prettier.io)**: For frontend code formatting
- **prettier-plugin-organize-imports** ([simonhaenisch/prettier-plugin-organize-imports](https://github.com/simonhaenisch/prettier-plugin-organize-imports)): For organizing imports in your Vue files
- **prettier-plugin-tailwindcss** ([tailwindlabs/prettier-plugin-tailwindcss](https://github.com/tailwindlabs/prettier-plugin-tailwindcss)): For automatically sorting Tailwind classes based on Tailwind's recommended class order

### Installation

Make sure your environment is configured as described in the [Requirements](#requirements) section.

1. In your terminal, go to your project folder
2. Run `composer install`
3. Run `npm install`
4. Copy `.env.example` to `.env` and configure as necessary (local URL, database connection, etc)
5. Run `php artisan key:generate`

### Usage

#### Development

The development environment leverages Vite, as described in the [Asset Bundling](https://laravel.com/docs/10.x/vite) section of Laravel's docs.

To run the local server, simply run `npm run dev`

#### Code Style

##### PHP

This boilerplate comes with a `.github/workflows/tidy.yml` file that will trigger Github Actions to format your PHP code using Pint whenever code is pushed to Github.

If you want to format your PHP code locally you can run `composer tidy`. This will both clean up your formattting and run the IDE helper scripts.

##### Frontend

If you want to format your Vue or JS files locally you can run `npm run prettier`. This will clean up your formattting, plus reorganize imports and reorganize Tailwind classes.
