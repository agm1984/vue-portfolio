<?php

use App\Category;
use App\Example;
use App\ExampleImage;
use App\Link;
use App\Tag;
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
                'name' => 'Vue Portfolio',
                'images' => [
                    '01-vp-main.gif',
                    '02-vp-comments.gif',
                    '03-vp-oauth.gif',
                    '04-vp-admin.gif',
                    '05-vp-design-system.gif',
                ],
                'summary' => 'After working with Laravel/PHP and Vue JS for almost two years, I decided to make my portfolio in Laravel and Vue. It features Oauth, a backend admin area, and an atomic design system.',
                'conclusion' => 'I plan to keep adding stuff to my portfolio over time. This design should last a while. In the future, I hope to add more elements of gamification; I want it to be enjoyable to browse.',
                'links' => [
                    [
                        'name' => 'View source code',
                        'url' => 'https://www.github.com/agm1984/vue-portfolio',
                    ],
                    [
                        'name' => 'View site',
                        'url' => 'https://adammackintosh.net',
                    ],
                ],
                'tags' => [
                    'PHP',
                    'Laravel',
                    'ES6+ JavaScript',
                    'Vue JS',
                    'Vuex',
                ],
            ],
            [
                'status' => Example::STATUS_ACTIVE,
                'category_id' => $projects_id,
                'name' => 'CommuniHelp',
                'images' => [
                    'communihelp1.png',
                    'communihelp2.jpeg',
                    'communihelp3.jpeg',
                ],
                'summary' => 'I originally applied to CommuniHelp as a software developer, but they were looking for pro bono work. Rather than reject their need, I chose to do work for them for free. I built their MVP iOS and Android app in React Native.',
                'conclusion' => 'I am still in contact with CommuniHelp, and I may do more pro bono work for them in the future. I love their stack which is node.js, Prisma, React, and React Native.',
                'links' => [
                    [
                        'name' => 'View website',
                        'url' => 'https://communihelp.ca',
                    ],
                ],
                'tags' => [
                    'ES6+ JavaScript',
                    'React JS',
                    'React Native',
                    'Node.js',
                    'GraphQL',
                    'Prisma',
                ],
            ],
            [
                'status' => Example::STATUS_ACTIVE,
                'category_id' => $projects_id,
                'name' => 'Content Management System',
                'images' => [
                    'cms-articles.gif',
                    'cms-dashboards.gif',
                    'cms-graphql.gif',
                    'cms-pagination.gif',
                    'cms-people.gif',
                    'cms-polyglot.gif',
                    'cms-relatedData.gif',
                    'cms-searchFilter.gif',
                    'cms-signIn.gif',
                    'cms-signUp.gif',
                ],
                'summary' => 'This project is a result of thousands of hours of research, trial and error, and pursuit of best practices for JavaScript engineering. It is important to note that sometimes, correct information was very hard to track down given the relative newness of isomorphic JavaScript co-mingled with 10 years of ES5. When the work day is done, I usually go home and continue coding. When tough problems arise at work, I always go home and continue researching. Details are very important to me. Details are what set a Company apart and what raise the bar of quality. I recommend taking a look at both the server and client code bases for this project if you have a couple minutes available for research.',
                'conclusion' => 'I am a systems thinker with an acute sense of patterns. If given the opportunity, I choose to work with a team of unique individuals that appreciate and utilize memes.',
                'links' => [
                    [
                        'name' => 'View backend source',
                        'url' => 'https://github.com/agm1984/adammackintosh-dot-net-server',
                    ],
                    [
                        'name' => 'View frontend source',
                        'url' => 'https://github.com/agm1984/adammackintosh-dot-net-webapp',
                    ],
                ],
                'tags' => [
                    'ES6+ JavaScript',
                    'React JS',
                    'Redux',
                    'React-Table',
                    'JSON Web Tokens',
                    'Create-React-App',
                    'Node.js',
                    'GraphQL',
                    'Neo4j',
                    'MongoDB',
                ],
            ],
            [
                'status' => Example::STATUS_ACTIVE,
                'category_id' => $projects_id,
                'name' => 'Business Management Portal',
                'images' => [
                    'workflow-addLead.gif',
                    'workflow-geoLocation.gif',
                    'workflow-navMenu.gif',
                    'workflow-passwordQuality.gif',
                    'workflow-photoSlider.gif',
                    'workflow-taskBoard.gif',
                    'router.png',
                ],
                'summary' => 'This project features logic from a book called \'Design Patterns: Elements of Reusable Object-Oriented Software.\' The app\'s routing was inspired by the Flyweight Pattern. I recommend taking a look at the Frontend code base if you have a couple minutes available for research.',
                'conclusion' => 'A rapidly growing skill and passion of mine is UI interactions during application events and state-changes. When I see things move in the browser, I see the mathematical art of motion tweens. In web browsers, there is a thing called jank. The nature of a render loop makes certain things expensive. It takes specific focus to ensure animations are buttery smooth across all devices that might encounter them. It also takes specific focus to account for Web Accessibility.',
                'links' => [
                    [
                        'name' => 'View backend source',
                        'url' => 'https://github.com/agm1984/adammackintosh-dot-net-server',
                    ],
                    [
                        'name' => 'View frontend source',
                        'url' => 'https://github.com/agm1984/project-manager-webapp',
                    ],
                ],
                'tags' => [
                    'ES6+ JavaScript',
                    'React JS',
                    'Redux',
                    'JSON Web Tokens',
                    'Node.js',
                    'GraphQL',
                    'Neo4j',
                    'MongoDB',
                ],
            ],
            [
                'status' => Example::STATUS_ACTIVE,
                'category_id' => $projects_id,
                'name' => 'Mackintosh Windows',
                'images' => [
                    'windows-adamHobbies.gif',
                    'windows-adamProperties.gif',
                    'windows-adamResume.gif',
                    'windows-menu.gif',
                    'windows-responsive.gif',
                ],
                'summary' => 'Mackintosh Windows features a responsive UI with desktop mode, mobile mode, and window-state manager. CSS Media Queries allow for fluid UI resizing from the smallest mobile devices to the largest desktop monitors. The window-state manager is heavily inspired by a book called \'Design Patterns: Elements of Reusable Object-Oriented Software.\' I tried to use as many software design patterns as possible from the book. I chose not to use Redux so I could demonstrate ES6 JavaScript functional programming techniques alongside React\'s standard implementation. I recommend taking a look at the code base if you have a couple minutes available for research.',
                'conclusion' => 'I have a long-term vision for a portfolio demonstration that involves three operating systems: Windows, MacOS, and a Linux. Each one helps me augment a particular aspect of my skills and experience. For example, Windows is an environment that brings mood of the internet\'s early days. Windows 95 incorporated at-scale UX R&D which makes its UI patterns useful still for today\'s UX concerns. MacOS represents a medium that contrasts the dated UI of Windows and allows for inclusion of the highest quality graphics. A Linux-oriented environment helps me demonstrate command-line and data-analysis topics. This Windows experiment represents the structure for the first of the three environments.',
                'links' => [
                    [
                        'name' => 'View source',
                        'url' => 'https://github.com/agm1984/mackintosh-windows',
                    ],
                ],
                'tags' => [
                    'ES6+ JavaScript',
                    'React',
                    'React-Draggable',
                    'Create-React-App',
                    'Babel',
                    'ES Lint',
                    'Jest',
                    'Puppeteer',
                ],
            ],
            [
                'status' => Example::STATUS_ACTIVE,
                'category_id' => $projects_id,
                'name' => 'Clock Angle Calculator',
                'images' => [
                    'clockAngle.gif',
                    'clockUnitTest.gif',
                ],
                'summary' => 'I was recently introduced to the Clock Angle Problem. I wanted to understand the problem better. I built a React Native application using test-driven development that would allow me to organically converge on the Clock Angle formulas. Building an analog clock is difficult using CSS. It is additionally difficult in React Native because there is no transform-origin. It takes a bit of trigonometry to rotate clock hands from a central origin.',
                'conclusion' => 'I had a lot of fun building this app even though the math and CSS were fairly complex. This is a type of app that should have lots of unit tests because of the moving parts of a clock. I would recommend building an analog clock to any developer because it\'s deceptively complex, assuming you like puzzles.',
                'links' => [
                    [
                        'name' => 'View source',
                        'url' => 'https://github.com/agm1984/rn-clock-angle',
                    ],
                ],
                'tags' => [
                    'ES6+ JavaScript',
                    'React Native',
                    'Create-React-Native-App',
                    'Babel',
                    'ES Lint',
                    'Jest',
                    'React-Native-Test-Utils',
                ],
            ],
            [
                'status' => Example::STATUS_ACTIVE,
                'category_id' => $courses_id,
                'name' => 'React 16 Complete Guide',
                'images' => [
                    'burger-creation.gif',
                    'burger-signup.gif',
                ],
                'summary' => 'This course contains a ton of Functional Reactive Programming and React theory along with comprehensive applied skills. I\'ve watched a lot of Academind\'s JavaScript tutorial videos on YouTube. He leaves no stone unturned. The main project in this course is a burger order app that features advanced architecture and best-practice patterns.',
                'conclusion' => 'I recommend this course to anyone because of its use of immutable, functional JavaScript and also because of its use of scalable component-reuse techniques.',
                'links' => [
                    [
                        'name' => 'View course',
                        'url' => 'https://www.udemy.com/react-the-complete-guide-incl-redux',
                    ],
                    [
                        'name' => 'View source code',
                        'url' => 'https://github.com/agm1984/react-burger-builder',
                    ],
                ],
                'tags' => [
                    'ES6+ JavaScript',
                    'React',
                    'Redux',
                    'React-Router-V4',
                    'Create-React-App',
                    'Babel',
                    'ES Lint',
                    'Axios',
                ],
            ],
            [
                'status' => Example::STATUS_ACTIVE,
                'category_id' => $courses_id,
                'name' => 'Modern React with Redux',
                'images' => [
                    'modern-weather.gif',
                    'modern-youtube.gif',
                    'modern1.png',
                ],
                'summary' => 'Around early-to-mid-2017, this was the first React course I took after doing months of server-side JavaScript and API development in node.js. I was working with microservices, Express.js, Hapi.js, stateless JWT authentication, worker processes, Redis semaphores, Neo4j, Mongo DB, GraphQL, and RSA encryption.',
                'conclusion' => 'I enjoyed this course because Stephen Grider did an amazing job not only explaining React and Redux architecture but also visually showing it. There was a lot of practical utility in building a YouTube API-consumer component and a weather app both using Ajax. The final project in this course involved a CRUD-based REST API and blog app.',
                'links' => [
                    [
                        'name' => 'View course',
                        'url' => 'https://www.udemy.com/react-redux',
                    ],
                    [
                        'name' => 'View source code',
                        'url' => 'https://github.com/agm1984/react-weather-app',
                    ],
                ],
                'tags' => [
                    'ES6+ JavaScript',
                    'React',
                    'Redux',
                    'React-Router-V4',
                    'React-Sparklines',
                    'Google Maps API',
                    'YouTube API',
                    'Bootstrap',
                    'NPM',
                    'Webpack',
                    'Babel',
                    'ES Lint',
                    'AJAX',
                ],
            ],
            [
                'status' => Example::STATUS_ACTIVE,
                'category_id' => $courses_id,
                'name' => 'Advanced React and Redux',
                'images' => [
                    'action-creators-old.png',
                    'advanced-signup.gif',
                    'fetchUsersOld.png',
                ],
                'summary' => 'This course was instrumental in crystallizing my server-side knowledge of JSON Web Tokens. It was around this time I became able to quickly deploy new APIs or app clients on demand. The course was a good refresher for REST endpoints and a good primer for later courses that used GraphQL.',
                'conclusion' => 'This course was a logical next-step for me after the Modern React and Redux course. It offered a fascinating twist by using an older version of React-Router and Redux-Form which are different APIs. Looking back, this was around the time I really started to understand and combine reactive programming with practices of server-side monadic and functor-based functional programming techniques in node.js. Functional Reactive Programming (FRP) reminds me a lot of Calculus in that functions can be composed to drastically simplify complex systems. Calculus relies on determinstic transformations for the same reasons that FRP prefers immutable, unidirectional data flow. That is simply another way to describe a deterministic transformation from point A to B.',
                'links' => [
                    [
                        'name' => 'View course',
                        'url' => 'https://www.udemy.com/react-redux-tutorial',
                    ],
                    [
                        'name' => 'View source code',
                        'url' => 'https://github.com/agm1984/react-graphql-auth',
                    ],
                ],
                'tags' => [
                    'ES6+ JavaScript',
                    'React',
                    'React-Testing',
                    'Redux',
                    'Redux-Form',
                    'Raect-Router V2',
                    'Higher-Order Components (HOCs)',
                    'Middleware',
                    'JSON Web Tokens',
                    'NPM',
                    'Webpack',
                    'Babel',
                    'ES Lint',
                    'AJAX'
                ],
            ],
            [
                'status' => Example::STATUS_ACTIVE,
                'category_id' => $courses_id,
                'name' => 'GraphQL with React',
                'images' => [
                    'add-songs.gif',
                ],
                'summary' => 'I was already sold on the benefits of GraphQL long before taking this course, but I was coming from a server-side perspective where data inefficiencies cost CPU, bandwidth, and time—some things GraphQL tends to minimize. This course contains lots of theory about how to structure data-centric React applications.',
                'conclusion' => 'Optimistic UI-updating is an Apollo Client feature that allows the app to assume a process will complete successfully and therefore show a result without waiting for a reply. This time savings makes for instant UI feedback and great UX. Along with optimistic UI, Apollo Client handles data pre-fetching easily. I haven\'t had a chance to implement it in a production app yet, but great performance and UX could potentially be unlocked because pre-fetching reduces later work on subsequent page loads.',
                'links' => [
                    [
                        'name' => 'View course',
                        'url' => 'https://www.udemy.com/graphql-with-react-course',
                    ],
                    [
                        'name' => 'View source code',
                        'url' => 'https://github.com/agm1984/react-graphql-song-app',
                    ],
                ],
                'tags' => [
                    'ES6+ JavaScript',
                    'GraphQL',
                    'React JS',
                    'React-Router V2',
                    'Apollo-Client',
                    'NPM',
                    'Webpack',
                    'Babel',
                    'ES Lint',
                ],
            ],
            [
                'status' => Example::STATUS_ACTIVE,
                'category_id' => $courses_id,
                'name' => 'Advanced Node.js',
                'images' => [
                    'chatbot.gif',
                ],
                'summary' => 'I completed this course in early 2017 after working with node.js for some time building out APIs that used multiple threads, child worker processes, Neo4j, and Redis. I took this course around the time I was practicing async/await syntax and composing async functions with aim for declarative, synchronous-looking code.',
                'conclusion' => 'The course was timely for many reasons. Most notably, it laid the foundations for my understanding of the JavaScript event loop and call stack. The course went into some length about LIBUV and using C++ plugins in node.js. I built a few chat programs as we explored streams and UDP and TCP sockets. I recommend it to anyone looking to skill up in reactive programming or isomorphic JavaScript.',
                'links' => [
                    [
                        'name' => 'View course',
                        'url' => 'https://www.pluralsight.com/courses/nodejs-advanced',
                    ],
                    [
                        'name' => 'View source code',
                        'url' => 'https://github.com/agm1984/advanced-nodejs-pluralsight',
                    ],
                ],
                'tags' => [
                    'ES6+ JavaScript',
                    'Node.js',
                    'UDP Sockets',
                    'Worker threads',
                    'Chatbots',
                ],
            ],
            [
                'status' => Example::STATUS_ACTIVE,
                'category_id' => $courses_id,
                'name' => 'React Native and Redux',
                'images' => [
                    'album-purchase.gif',
                    'employee-manager.gif',
                    'tech-stack.gif',
                ],
                'summary' => 'I quickly learned a lot with this course. My iOS and Android QA experience came in handy to shoulder the initial learning curve. The key takeaway for me is that React Native brings a language-agnostic bridge adapter to native mobile, and this unlocks the power of the JavaScript bundle.',
                'conclusion' => 'I recently became interested in the animation of UI interactions. I did one year of a BSc. Major in Physics Degree at Vancouver Island University. Besides learning things about Physics, Math, and Economics that I use every day, I find 2D and 3D kinematics quite useful when it comes to animating the x, y, z axes. I am always looking for opportunities to implement beautiful app interactions. I enjoy the science behind bringing a design or idea to life.',
                'links' => [
                    [
                        'name' => 'View course',
                        'url' => 'https://www.udemy.com/the-complete-react-native-and-redux-course',
                    ],
                    [
                        'name' => 'View source code',
                        'url' => 'https://github.com/agm1984/react-native-employeemanager',
                    ],
                ],
                'tags' => [
                    'ES6+ JavaScript',
                    'React Native',
                    'Redux',
                    'Firebase',
                    'Axios',
                    'Create-React-Native-App',
                    'ES Lint',
                    'Authentication',
                    'Animations',
                ],
            ],
            [
                'status' => Example::STATUS_ACTIVE,
                'category_id' => $courses_id,
                'name' => 'Web Developer Bootcamp',
                'images' => [
                    'campsite-addNew.gif',
                    'campsite-comments.gif',
                    'campsite-signup.gif',
                    'movie-search.gif',
                    'rgb-game.gif',
                    'yelp-camp.gif',
                ],
                'summary' => 'This is a very popular course and for good reason. Colt Steele is a great teacher, and he laid the JavaScript foundations for me. This course is much more comprehensive than it may appear at face value. I had already been doing development cycle work for five years prior to this, but this course provided me the drills to become strong with JavaScript.',
                'conclusion' => 'This course is great for people that have not done JavaScript or CSS in a while and want to brush up on the DOM. With the course, a person could get up and running with REST endpoints and websites in node.js. I would consider this a great precursor to more complex APIs in node.js and to more complex Frontend clients.',
                'links' => [
                    [
                        'name' => 'View course',
                        'url' => 'https://www.udemy.com/the-web-developer-bootcamp',
                    ],
                    [
                        'name' => 'View source code',
                        'url' => 'https://github.com/agm1984/YelpCamp',
                    ],
                ],
                'tags' => [
                    'HTML',
                    'CSS',
                    'DOM manipulation',
                    'ES5 JavaScript',
                    'JQuery',
                    'Node.js',
                    'Express.js',
                    'REST API',
                    'MongoDB',
                    'Passport JS',
                    'ES Lint',
                    'Bootstrap',
                    'EJS',
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
            $exists = Example::query()->firstWhere('name', $example['name']);

            if (!$exists) {
                $new_example = factory(Example::class, 1)->create([
                    'status' => $example['status'],
                    'category_id' => $example['category_id'],
                    'slug' => Str::slug($example['name']),
                    'name' => $example['name'],
                    'summary' => $example['summary'],
                    'conclusion' => $example['conclusion'],
                ])->first();

                foreach ($example['images'] as $filename) {
                    ExampleImage::generate($new_example->id, $filename);
                }

                foreach ($example['links'] as $link) {
                    $link = Link::generate(
                        $new_example->id,
                        $link['name'],
                        $link['url']
                    );
                }

                foreach ($example['tags'] as $tagname) {
                    $tag = Tag::query()->firstWhere('name', $tagname);

                    if (!$tag) {
                        $new_tag = Tag::generate($tagname);
                    }

                    $new_example->tags()->attach($tag ? $tag : $new_tag);
                }
            }
        }

    }
}
