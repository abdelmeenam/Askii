<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>
</p>

# Askii built with Laravel 9.x
Welcome to our Askii project built using Laravel! This project aims to provide a platform where users can ask questions, post answers, and engage in a community-driven knowledge-sharing experience, much like the popular StackOverflow platform.

## Features

- **User Authentication**: Users can register, login, and verify their email addresses to access the platform.
- **Question Management**: Users can create questions with specific tags such as PHP, MySQL, etc. They can update or delete their own questions.
- **Answering Questions**: Other users can answer questions, triggering email using MAILtrap, SMS using NEXMO, and real-time notifications using PUSHER  to the question owner. Question owners can mark a specific answer as the best answer.
- **Views Functionality**: Each question has a view counter that tracks how many times it has been viewed. This feature helps to identify popular questions and engage users.
- **Multilanguage Support**: The website supports multiple languages including Arabic and English.
- **Profile Management**: Users can edit their profile data, upload profile images, and change passwords.
- **Search Functionality**: Users can search for questions using any keyword with live search functionality powered by Algolia, enabling fast and relevant search results.
- **Admin Dashboard**: Administrators have access to a dashboard to view statistics such as the number of users, questions, and answers. They can also view graphs showing the number of answers and questions per day, as well as a donut chart to determine the distribution of questions among different tags (e.g., PHP, MySQL).


## Installation
Clone the repo & Install dependencies
```bash
git clone https://github.com/abdelmeenam/Askii.git
composer install
npm install
npm run build
php artisan storage:link
cp .env.example .env
php artisan key:generate
php artisan migrate
```

```bash
php artisan db:seed --class=UsersTableSeeder
php artisan db:seed --class=TagsTableSeeder
php artisan db:seed --class=QuestionsTableSeeder
```


    
## Future Features
While the current version of this project offers a robust set of functionalities, there are additional features planned for future development:

- **Socialite and Two-Factor Authentication (2FA):** Enhance user security and ease of login through social media integration and 2FA.
- **Sorting Questions and Filtering by Tags:** Improve user experience by allowing users to sort questions and filter them based on selected tags.
- **Repository Design Pattern:** Implement a structured and maintainable codebase using the repository design pattern.
- **Notification Settings:** Enable users to customize their notification preferences, choosing to receive updates via email or SMS.
- **Public Profile for Users:** Create a public profile for each user showcasing all their questions, enhancing user visibility and engagement.


