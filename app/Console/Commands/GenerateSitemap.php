<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Sitemap\SitemapGenerator;
use Spatie\Sitemap\Tags\Url;

class GenerateSitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-sitemap';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a sitemap.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $path = public_path('sitemap.xml');

        $map = SitemapGenerator::create(config('app.url'))->getSitemap();

        $map->add(
            Url::create('/')
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                ->setPriority(0.8)
        );

        // Add the rest of your pages here...

        $map->writeToFile($path);
    }
}
