<?php

namespace Database\Seeders;

use App\Models\Category;
use Carbon\CarbonImmutable;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = CarbonImmutable::now()->toDateTimeString();

        Category::insert([
            [
                'name' => 'Performance',
                'inputValue' => 'PERFORMANCE',
                'description' => 'Relates to the speed and responsiveness of your website, focusing on optimizing loading times and rendering performance to enhance user experience.',
                'updated_at' => $now,
                'created_at' => $now
            ],
            [
                'name' => 'Accessibility',
                'inputValue' => 'ACCESSIBILITY',
                'description' => 'Ensures that your website is usable and navigable for people with diverse abilities and disabilities.',
                'updated_at' => $now,
                'created_at' => $now
            ],
            [
                'name' => 'Best Practices',
                'inputValue' => 'BEST_PRACTICES',
                'description' => 'Includes recommended techniques for optimizing websites to achieve optimal performance, usability, and maintainability.',
                'updated_at' => $now,
                'created_at' => $now
            ],
            [
                'name' => 'SEO - Search Engine Optimization',
                'inputValue' => 'SEO',
                'description' => 'Involves strategies aimed at improving the visibility and ranking of your website in search engine results pages, ultimately driving organic traffic.',
                'updated_at' => $now,
                'created_at' => $now
            ],
            [
                'name' => 'PWA - Progressive Web App',
                'inputValue' => 'PWA',
                'description' => 'Leverages modern web technologies to enhance user experience with features such as fast loading times, offline functionality, and mobile responsiveness.',
                'updated_at' => $now,
                'created_at' => $now
            ],
        ]);
    }
}
