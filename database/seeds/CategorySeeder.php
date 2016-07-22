<?php

use Magnus\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * Top tier categories
         */
        Category::create(['name' => 'Digital Art',
            'slug' => 'digital',
            'description' => '',
            'category_tier' => 1,
            'open' => false,
            'parent_category_id' => null]);

        Category::create(['name' => 'Traditional Art',
            'slug' => 'traditional',
            'description' => '',
            'category_tier' => 1,
            'open' => false,
            'parent_category_id' => null]);

        Category::create(['name' => 'Photography',
            'slug' => 'photography',
            'description' => '',
            'category_tier' => 1,
            'open' => false,
            'parent_category_id' => null]);


        $digitalId = Category::whereSlug('digital')->value('id');
        $photographyId = Category::whereSlug('photography')->value('id');
        $traditionalId = Category::whereSlug('traditional')->value('id');

        /**
         * Digital Art 2nd tier categories
         */
        Category::create(['name' => 'Drawings & Paintings',
            'slug' => 'drawings-paintings',
            'description' => '',
            'category_tier' => 2,
            'open' => false,
            'parent_category_id' => $digitalId]);

        Category::create(['name' => 'Fractal Art',
            'slug' => 'fractals',
            'description' => '',
            'category_tier' => 2,
            'open' => false,
            'parent_category_id' => $digitalId]);

        Category::create(['name' => 'Vector',
            'slug' => 'vector',
            'description' => '',
            'category_tier' => 2,
            'open' => true,
            'parent_category_id' => $digitalId]);

        Category::create(['name' => 'Pixel Art',
            'slug' => 'pixel',
            'description' => '',
            'category_tier' => 2,
            'open' => true,
            'parent_category_id' => $digitalId]);

        $fractalId = Category::whereSlug('fractals')->value('id');
        $drawingsDigitalId = Category::whereSlug('drawings-paintings')->value('id');

        /**
         * Digital art 3rd tier categories
         */

        Category::create(['name' => 'Fractal Manipulations',
            'slug' => 'manipulations',
            'description' => '',
            'category_tier' => 3,
            'open' => true,
            'parent_category_id' => $fractalId]);

        /**
         * Digital Art > Drawing and Paintings subcategories
         */
        Category::create(['name' => 'Abstract',
            'slug' => 'abstract',
            'description' => '',
            'category_tier' => 3,
            'open' => true,
            'parent_category_id' => $drawingsDigitalId]);

        Category::create(['name' => 'Animals',
            'slug' => 'animals',
            'description' => '',
            'category_tier' => 3,
            'open' => true,
            'parent_category_id' => $drawingsDigitalId]);

        Category::create(['name' => 'Illustrations',
            'slug' => 'illustrations',
            'description' => '',
            'category_tier' => 3,
            'open' => true,
            'parent_category_id' => $drawingsDigitalId]);

        Category::create(['name' => 'Landscapes & Scenery',
            'slug' => 'landscapes-scenery',
            'description' => '',
            'category_tier' => 3,
            'open' => true,
            'parent_category_id' => $drawingsDigitalId]);

        Category::create(['name' => 'Other',
            'slug' => 'other',
            'description' => '',
            'category_tier' => 3,
            'open' => true,
            'parent_category_id' => $drawingsDigitalId]);

        Category::create(['name' => 'People',
            'slug' => 'people',
            'description' => '',
            'category_tier' => 3,
            'open' => true,
            'parent_category_id' => $drawingsDigitalId]);

        Category::create(['name' => 'Pop Art',
            'slug' => 'pop-art',
            'description' => '',
            'category_tier' => 3,
            'open' => true,
            'parent_category_id' => $drawingsDigitalId]);

        Category::create(['name' => 'Sci-Fi',
            'slug' => 'sci-fi',
            'description' => '',
            'category_tier' => 3,
            'open' => true,
            'parent_category_id' => $drawingsDigitalId]);

        Category::create(['name' => 'Space Art',
            'slug' => 'space-art',
            'description' => '',
            'category_tier' => 3,
            'open' => true,
            'parent_category_id' => $drawingsDigitalId]);

        Category::create(['name' => 'fantasy',
            'slug' => 'fantasy',
            'description' => '',
            'category_tier' => 3,
            'open' => true,
            'parent_category_id' => $drawingsDigitalId]);

        /**
         * Traditional Second Tier categories
         */
        Category::create(['name' => 'Drawings',
            'slug' => 'drawings',
            'description' => '',
            'category_tier' => 2,
            'open' => false,
            'parent_category_id' => $traditionalId]);

        Category::create(['name' => 'Paintings',
            'slug' => 'paintings',
            'description' => '',
            'category_tier' => 2,
            'open' => false,
            'parent_category_id' => $traditionalId]);

        Category::create(['name' => 'Scratch Board',
            'slug' => 'scratch-board',
            'description' => '',
            'category_tier' => 2,
            'open' => true,
            'parent_category_id' => $traditionalId]);

        Category::create(['name' => 'Other',
            'slug' => 'other',
            'description' => '',
            'category_tier' => 2,
            'open' => true,
            'parent_category_id' => $traditionalId]);


        $drawingsTraditionalId = Category::whereSlug('drawings')->value('id');
        $paintingsTraditionalId = Category::whereSlug('paintings')->value('id');
        /**
         * Third tier traditional categories
         */

        // Drawing 3rd tier
        Category::create(['name' => 'Animals',
            'slug' => 'animals',
            'description' => '',
            'category_tier' => 3,
            'open' => true,
            'parent_category_id' => $drawingsTraditionalId]);

        Category::create(['name' => 'Fantasy',
            'slug' => 'fantasy',
            'description' => '',
            'category_tier' => 3,
            'open' => true,
            'parent_category_id' => $drawingsTraditionalId]);

        Category::create(['name' => 'People',
            'slug' => 'people',
            'description' => '',
            'category_tier' => 3,
            'open' => true,
            'parent_category_id' => $drawingsTraditionalId]);

        Category::create(['name' => 'Illustration',
            'slug' => 'illustration',
            'description' => '',
            'category_tier' => 3,
            'open' => true,
            'parent_category_id' => $drawingsTraditionalId]);

        Category::create(['name' => 'Sci-Fi',
            'slug' => 'sci-fi',
            'description' => '',
            'category_tier' => 3,
            'open' => true,
            'parent_category_id' => $drawingsTraditionalId]);

        Category::create(['name' => 'Other',
            'slug' => 'other',
            'description' => '',
            'category_tier' => 3,
            'open' => true,
            'parent_category_id' => $drawingsTraditionalId]);

        Category::create(['name' => 'Surreal',
            'slug' => 'surreal',
            'description' => '',
            'category_tier' => 3,
            'open' => true,
            'parent_category_id' => $drawingsTraditionalId]);

        Category::create(['name' => 'Abstract',
            'slug' => 'abstract',
            'description' => '',
            'category_tier' => 3,
            'open' => true,
            'parent_category_id' => $drawingsTraditionalId]);

        /**
         * paintings traditional 3rd tier
         */

        Category::create(['name' => 'Fantasy',
            'slug' => 'fantasy',
            'description' => '',
            'category_tier' => 3,
            'open' => true,
            'parent_category_id' => $paintingsTraditionalId]);

        Category::create(['name' => 'Animals',
            'slug' => 'animals',
            'description' => '',
            'category_tier' => 3,
            'open' => true,
            'parent_category_id' => $paintingsTraditionalId]);

        Category::create(['name' => 'People',
            'slug' => 'people',
            'description' => '',
            'category_tier' => 3,
            'open' => true,
            'parent_category_id' => $paintingsTraditionalId]);

        Category::create(['name' => 'Illustrations',
            'slug' => 'illustration',
            'description' => '',
            'category_tier' => 3,
            'open' => true,
            'parent_category_id' => $paintingsTraditionalId]);

        Category::create(['name' => 'Sci-Fi',
            'slug' => 'sci-fi',
            'description' => '',
            'category_tier' => 3,
            'open' => true,
            'parent_category_id' => $paintingsTraditionalId]);

        Category::create(['name' => 'Other',
            'slug' => 'other',
            'description' => '',
            'category_tier' => 3,
            'open' => true,
            'parent_category_id' => $paintingsTraditionalId]);

        Category::create(['name' => 'Surreal',
            'slug' => 'surreal',
            'description' => '',
            'category_tier' => 3,
            'open' => true,
            'parent_category_id' => $paintingsTraditionalId]);

        Category::create(['name' => 'Abstract',
            'slug' => 'abstract',
            'description' => '',
            'category_tier' => 3,
            'open' => true,
            'parent_category_id' => $paintingsTraditionalId]);

        /**
         * Photography second tier
         */
        Category::create(['name' => 'Animals, Plants & Nature',
            'slug' => 'animals-plants-nature',
            'description' => '',
            'category_tier' => 2,
            'open' => true,
            'parent_category_id' => $photographyId]);

        Category::create(['name' => 'People & Portraits',
            'slug' => 'people-portraits',
            'description' => '',
            'category_tier' => 2,
            'open' => true,
            'parent_category_id' => $photographyId]);

        Category::create(['name' => 'Still Life',
            'slug' => 'still-life',
            'description' => '',
            'category_tier' => 2,
            'open' => true,
            'parent_category_id' => $photographyId]);

        Category::create(['name' => 'Architecture',
            'slug' => 'architecture',
            'description' => '',
            'category_tier' => 2,
            'open' => true,
            'parent_category_id' => $photographyId]);

        Category::create(['name' => 'Abstract & Surreal',
            'slug' => 'abstract-surreal',
            'description' => '',
            'category_tier' => 2,
            'open' => true,
            'parent_category_id' => $photographyId]);
    }
}
