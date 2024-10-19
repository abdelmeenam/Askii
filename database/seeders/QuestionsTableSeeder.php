<?php

namespace Database\Seeders;

use App\Models\Tag;
use App\Models\Question;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Carbon;

class QuestionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Truncate the tags table
        DB::table('questions')->truncate();
        DB::table('question_tag')->truncate();

        // Enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');






        $questions = [
            [
                'title' => 'How to fix CORS issues in a Vue.js project?',
                'description' => "I'm working on a Vue.js project with a Laravel backend, but I keep encountering CORS errors when trying to make API calls. How can I properly configure CORS in my Laravel application?",

                'user_id' => 1,
                'created_at' => Carbon::now()->subDays(10 - 9),
            ],
            [
                'title' => "What's the difference between `var`, `let`, and `const` in JavaScript?",
                'description' => "Can someone explain the key differences between `var`, `let`, and `const` in JavaScript? When should I use each one, and what are the pitfalls of using `var`?",

                'user_id' => 2,
                'created_at' => Carbon::now()->subDays(10 - 8),

            ],
            [
                'title' => 'How to improve SQL query performance?',
                'description' => 'I have a complex SQL query that\'s running very slowly. What are some general tips for optimizing SQL queries? Should I focus on indexing, or are there other strategies I should consider?',

                'user_id' => 3,
                'created_at' => Carbon::now()->subDays(10 - 7),

            ],
            [
                'title' => 'What are the benefits of using Docker for development?',
                'description' => "I've heard a lot about Docker but haven't used it in my projects. What are the key benefits of using Docker in a development environment? How does it help with deployment?",

                'user_id' => 4,
                'created_at' => Carbon::now()->subDays(10 - 6),

            ],
            [
                'title' => 'How to handle state management in React applications?',
                'description' => "I'm new to React and struggling with managing state across components. Should I use React's built-in `useState` or opt for a library like Redux? What are the pros and cons?",

                'user_id' => 5,
                'created_at' => Carbon::now()->subDays(10 - 5),

            ],
            [
                'title' => 'What is the best way to handle user authentication in a Laravel API?',
                'description' => "I'm building an API using Laravel and need to implement user authentication. Should I use Laravel Passport or JWT tokens? What are the differences between the two approaches?",

                'user_id' => 6,
                'created_at' => Carbon::now()->subDays(10 - 4),

            ],
            [
                'title' => 'How to deploy a Node.js app on AWS EC2?',
                'description' => "I have a Node.js app that I want to deploy on an AWS EC2 instance. What are the steps for setting up the server, installing Node.js, and ensuring the app runs properly on startup?",

                'user_id' => 7,
                'created_at' => Carbon::now()->subDays(10 - 3),

            ],
            [
                'title' => "What's the difference between NoSQL and SQL databases?",
                'description' => "I've heard about NoSQL databases like MongoDB, but I'm not sure when to use them over traditional SQL databases like MySQL. Can someone explain the main differences and use cases?",

                'user_id' => 8,
                'created_at' => Carbon::now()->subDays(10 - 2),

            ],
            [
                'title' => 'How to set up continuous integration with GitHub Actions?',
                'description' => "I want to automate my build and testing process using GitHub Actions. How do I set up a simple CI pipeline for a Node.js project? Are there any best practices I should follow?",

                'user_id' => 9,
                'created_at' => Carbon::now()->subDays(10 - 4),

            ],
            [
                'title' => 'How to use Python for web scraping?',
                'description' => "I'm trying to scrape a website using Python but am getting blocked by the site. What are some best practices for web scraping, and how can I avoid being blocked? Should I use libraries like BeautifulSoup or Scrapy?",

                'user_id' => 10,
                'created_at' => Carbon::now()->subDays(10 - 1),

            ],
            [
                'title' => 'What is the difference between monolithic and microservices architecture?',
                'description' => "I often hear about monolithic vs microservices architecture, but I don't fully understand the differences. Could someone explain the benefits and drawbacks of each approach?",

                'user_id' => 11,
                'created_at' => Carbon::now()->subDays(10 - 2),

            ],
            [
                'title' => 'How does garbage collection work in Java?',
                'description' => "Can someone explain how Java's garbage collection mechanism works? How does it manage memory, and are there any strategies to optimize garbage collection in a large-scale application?",

                'user_id' => 12,
                'created_at' => Carbon::now()->subDays(10 - 5),

            ],
            [
                'title' => 'What is the best way to secure a REST API?',
                'description' => "I'm developing a REST API and want to ensure it is secure. What are the best practices for securing REST APIs? Should I focus on OAuth, JWT, or some other mechanism?",

                'user_id' => 13,
            ],
            [
                'title' => 'How to handle large file uploads in a web application?',
                'description' => "I need to allow users to upload large files (up to several GBs) in a web application. What are the best practices for handling large file uploads in terms of server configuration and user experience?",

                'user_id' => 14,
            ],
            [
                'title' => 'What is event-driven programming and when should I use it?',
                'description' => "I keep hearing about event-driven programming, but I'm not sure when it's appropriate to use it. Can someone explain what it is and in which scenarios it is most beneficial?",

                'user_id' => 15,
            ],
            [
                'title' => 'How do you prevent SQL injection attacks in PHP?',
                'description' => "I'm building a PHP application and want to ensure it's secure. How can I prevent SQL injection attacks? Should I use prepared statements or are there other techniques I should consider?",

                'user_id' => 16,
            ],
            [
                'title' => 'What is the best way to optimize front-end performance?',
                'description' => "I'm building a website and I want to optimize front-end performance for faster loading times. Should I focus on minifying assets, lazy loading images, or are there other important techniques?",

                'user_id' => 17,
            ],
            [
                'title' => 'How does the event loop work in Node.js?',
                'description' => "I know that Node.js is asynchronous, but I'm confused about how the event loop works. Can someone explain how the event loop operates and how it manages asynchronous callbacks?",

                'user_id' => 18,
            ],
            [
                'title' => 'What is the difference between MVC and MVVM architecture?',
                'description' => "I've heard of both MVC (Model-View-Controller) and MVVM (Model-View-ViewModel) architectural patterns, but I'm not sure when to use each one. Can someone explain the key differences and use cases?",

                'user_id' => 19,
            ],
            [
                'title' => 'How to implement OAuth2 in a web application?',
                'description' => "I need to implement OAuth2 for authentication in my web application, but I'm struggling to understand the different grant types and how to secure it properly. Can someone provide a step-by-step guide?",

                'user_id' => 20,
            ]
        ];

        // Get valid tag IDs from the `tags` table
        $tagIds = Tag::pluck('id')->toArray();

        // Insert each question and attach random valid tags
        foreach ($questions as $index => $questionData) {
            $question = Question::create($questionData);

            // Attach random tags (between 1 to 5 tags per question)
            $tagIds = range(1, 19); // Assuming tag IDs range from 0 to 19
            shuffle($tagIds);
            $selectedTags = array_slice($tagIds, 1, length: rand(1, 3)); // Select random 1-5 tags
            $question->tags()->attach($selectedTags);
        }
    }
    //php artisan db:seed --class=QuestionsTableSeeder


}
