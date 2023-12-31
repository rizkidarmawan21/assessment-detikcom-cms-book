# Bookstore Apps

This apps for test assesment detik.com msib batch 5. Maked with Laravel , Inertia, and Vue JS 3

## This Feature
- Login and Register
- Management Book (CRUD)
- Management Book Categories
- Management User
- Management Role & Permission
- Download books data PDF

## Tech Stack
- Laravel 9 (PHP 8)
- Laravel UI
- Inertia JS
- Vue JS 3
- Tailwind CSS
- DOMPDF
- Laravel Spatie Permission


## How to use ?
- Clone this repo
- Run `composer install`
- Run `yarn` or `npm install`
- Create Database
- Copy `.env.example` paste `.env`
- Setup database in `.env`
- Run `php artisan key:generate`
- Run `php artisan storage:link`
- Migrate database run `php artisan migrate --seed`
- Running `php artisan serve`
- Running in another terminal `yarn dev` or `npm run dev`

## Which must be required in the `.env` file
Make sure these 3 variables are required otherwise an error will error
1. APP_URL (must be filled ex: `http://assessment-detikcom-cms-book.test`)
2. FAKER_LOCALE (ex: `ID_id`)
3. DASHBOARD_TIMEZONE (ex: `Asia/Jakarta`)


## Account
### User Another Admin
Accounts for users other than admins, you can register first or create an account via the admin dashboard. By default the three registering roles will be assigned as users

### Admin
email : superadmin@boilerplate.com
<br>
password : rahasia123

## ERD
<img width="1157" alt="image" src="https://github.com/rizkidarmawan21/assessment-detikcom-cms-book/assets/80609220/aa746981-681e-4132-8c10-7db980bb6723">

## Preview Demo

<img width="1679" alt="image" src="https://github.com/rizkidarmawan21/assessment-detikcom-cms-book/assets/80609220/047d5516-64e1-4fac-ac68-16d027a7fb92">
<img width="1679" alt="image" src="https://github.com/rizkidarmawan21/assessment-detikcom-cms-book/assets/80609220/a41aab12-c01b-422d-bacd-c890f1813a62">
<img width="1679" alt="image" src="https://github.com/rizkidarmawan21/assessment-detikcom-cms-book/assets/80609220/d063fd42-eb8b-4b99-bae6-89e05a098c0b">
<img width="1679" alt="image" src="https://github.com/rizkidarmawan21/assessment-detikcom-cms-book/assets/80609220/374ce317-d40d-4b52-ab11-d7474f373f8d">
<img width="525" alt="image" src="https://github.com/rizkidarmawan21/assessment-detikcom-cms-book/assets/80609220/1be30f4c-52d3-4edc-8f8b-02916ee0aa81">
<img width="1679" alt="image" src="https://github.com/rizkidarmawan21/assessment-detikcom-cms-book/assets/80609220/78321d6d-bc5a-4497-abc9-a374dc60cde6">
<img width="1677" alt="image" src="https://github.com/rizkidarmawan21/assessment-detikcom-cms-book/assets/80609220/ee195582-47f5-4de3-b06a-17d65604803f">
<img width="1679" alt="image" src="https://github.com/rizkidarmawan21/assessment-detikcom-cms-book/assets/80609220/5a14445b-ab11-4336-b66d-ae0020377bb3">
<img width="1679" alt="image" src="https://github.com/rizkidarmawan21/assessment-detikcom-cms-book/assets/80609220/645701bc-31d4-40d4-bc6f-418ce7925322">

