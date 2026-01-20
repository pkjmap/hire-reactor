
## About Project

The goal of this assessment is to evaluate the candidate’s ability to design and implement a
Laravel application that meets real-world requirements. The submitted solution will be assessed
to determine whether it reflects the skills.

## How to install and run the project


- git clone https://github.com/pkjmap/hire-reactor
- run `composer install`.
- run `npm install` on root folder
- Create a mysql database `hire_reactor`
- run `php artisan migrate` on root folder.
- run `php artisan serve` on root folder.
- run `npm run dev` on root folder.
- run `php artisan queue:work redis` on root folder.
- setup a cron job on server machine using `* * * * * cd /path-to-project && php artisan schedule:run >> /dev/null 2>&1` command.
- Then visit https://localhost:8000 to add clients, websites etc