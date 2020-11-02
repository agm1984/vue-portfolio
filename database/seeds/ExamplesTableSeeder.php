<?php

use App\Category;
use App\Example;
use App\ExampleImage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ExamplesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $projects_id = Category::query()->firstWhere('name', 'Projects');
        $courses_id = Category::query()->firstWhere('name', 'Courses');
        // $university_id = Category::query()->firstWhere('name', 'University');

        $examples = [
            [
                'status' => Example::STATUS_ACTIVE,
                'category_id' => $projects_id,
                'name' => 'content management system',
                'images' => [
                    'cms-articles.gif',
                    'cms-dashboards.gif',
                    'cms-graphql.gif',
                    'cms-pagination.gif',
                    'cms-people.gif',
                    'cms-polyglot.gif',
                    'cms-relatedData.gif',
                    'cms.searchFilter.gif',
                    'cms-signIn.gif',
                    'cms-signUp.gif',
                ],
            ],
            [
                'status' => Example::STATUS_ACTIVE,
                'category_id' => $projects_id,
                'name' => 'business management portal',
                'images' => [
                    'router.png',
                    'workflow-addLead.gif',
                    'workflow-geoLocation.gif',
                    'workflow-navMenu.gif',
                    'workflow-passwordQuality.gif',
                    'workflow-photoSLider.gif',
                    'workflow-taskBoard.gif',
                ],
            ],
            [
                'status' => Example::STATUS_ACTIVE,
                'category_id' => $projects_id,
                'name' => 'mackintosh windows',
                'images' => [
                    'windows-adamHobbies.gif',
                    'windows-adamProperties.gif',
                    'windows-adamResume.gif',
                    'windows-menu.gif',
                    'windows-responsive.gif',
                ],
            ],
            [
                'status' => Example::STATUS_ACTIVE,
                'category_id' => $projects_id,
                'name' => 'clock angle calculator',
                'images' => [
                    'clockAngle.gif',
                    'clockUnitTest.gif',
                ],
            ],
            [
                'status' => Example::STATUS_ACTIVE,
                'category_id' => $courses_id,
                'name' => 'react 16 complete guide',
                'images' => [
                    'burger-creation.gif',
                    'burger-signup.gif',
                ],
            ],
            [
                'status' => Example::STATUS_ACTIVE,
                'category_id' => $courses_id,
                'name' => 'modern react with redux',
                'images' => [
                    'modern-weather.gif',
                    'modern-youtube.gif',
                    'modern1.png',
                ],
            ],
            [
                'status' => Example::STATUS_ACTIVE,
                'category_id' => $courses_id,
                'name' => 'advanced react and redux',
                'images' => [
                    'action-creators-old.png',
                    'advanced-signup.gif',
                    'fetchUsersOld.png',
                ],
            ],
            [
                'status' => Example::STATUS_ACTIVE,
                'category_id' => $courses_id,
                'name' => 'graphql with react',
                'images' => [
                    'add-songs.gif',
                ],
            ],
            [
                'status' => Example::STATUS_ACTIVE,
                'category_id' => $courses_id,
                'name' => 'advanced node.js',
                'images' => [
                    'chatbot.gif',
                ],
            ],
            [
                'status' => Example::STATUS_ACTIVE,
                'category_id' => $courses_id,
                'name' => 'react native and redux',
                'images' => [
                    'album-purchase.gif',
                    'employee-manager.gif',
                    'tech-stack.gif',
                ],
            ],
            [
                'status' => Example::STATUS_ACTIVE,
                'category_id' => $courses_id,
                'name' => 'web developer bootcamp',
                'images' => [
                    'campsite-addNew.gif',
                    'campsite-comments.gif',
                    'campsite-signup.gif',
                    'movie-search.gif',
                    'rgb-game.gif',
                    'yelp-camp.gif',
                ],
            ],
            // [
            //     'status' => Example::STATUS_ACTIVE,
            //     'category_id' => $university_id,
            //     'name' => 'Vancouver Island University',
            //     'images' => [
            //         'transcript.png',
            //     ],
            // ],
        ];

        foreach ($examples as $example) {
            $exists = Example::query()->where('name', $example['name'])->first();

            if (!$exists) {
                $new_example = factory(Example::class, 1)->create([
                    'status' => $example['status'],
                    'category_id' => $example['category_id'],
                    'slug' => Str::slug($example['name']),
                    'name' => $example['name'],
                ])->first();

                foreach ($example['images'] as $filename) {
                    ExampleImage::generate($new_example->id, $filename);
                }
            }
        }

    }
}
