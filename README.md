# Transport Management App

## Setup

1. `composer install`
2. `npm install`
3. Jika tampilan berantakan:
   `npx @tailwindcss/cli -i ./public/src/tailwind.css -o ./public/src/output.css --watch`
4. `php spark migrate -all`
5. `php spark db:seed InitialDataSeeder`
6. Alternatif: import `transport-management-db.db`
7. `php spark serve`

## Server Requirements

PHP version 8.2 or higher is required, with the following extensions installed:

