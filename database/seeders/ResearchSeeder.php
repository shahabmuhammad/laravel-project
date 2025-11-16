<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Research;
use App\Models\Publisher;
use App\Models\Type;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Str;

class ResearchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create publishers
        $publishers = collect();
        for ($i = 1; $i <= 3; $i++) {
            $publishers->push(\App\Models\Publisher::create([
                'name' => fake()->company(),
                'website' => 'https://' . fake()->domainName(),
                'address' => fake()->address(),
            ]));
        }

        // Create types
        $types = collect();
        foreach (['Journal', 'Thesis', 'Report'] as $t) {
            $types->push(\App\Models\Type::create([
                'type' => $t,
                'description' => fake()->sentence(),
            ]));
        }

        // Create categories
        $categories = collect();
        for ($i = 1; $i <= 6; $i++) {
            $name = ucfirst(fake()->word());
            $categories->push(Category::firstOrCreate(
                ['name' => $name],
                ['description' => fake()->sentence()]
            ));
        }

        // Get users with Researcher role only
        $researchers = User::role('Researcher')->get();

        if ($researchers->isEmpty()) {
            $this->command->info('No users with Researcher role found! Please create some users first.');
            return;
        }

        // Create researches
        $total = 12;
        for ($i = 1; $i <= $total; $i++) {
            $isPublished = $i <= 8; // first 8 published

            $title = fake()->sentence(6);

            Research::create([
                'user_id' => $researchers->random()->id,
                'title' => $title,
                'slug' => Str::slug($title) . '-' . uniqid(),
                'description' => fake()->paragraphs(3, true),
                'keywords' => implode(', ', fake()->words(5)),
                'category_ids' => $categories->random(rand(1, 3))->pluck('id')->toArray(),
                'publisher_id' => $publishers->random()->id,
                'type_id' => $types->random()->id,
                'status' => $isPublished ? 'published' : 'draft',
                'downloads' => rand(0, 500),
                'views' => rand(0, 1000),
            ]);
        }

        $this->command->info('Research seeding completed successfully!');
    }
}
