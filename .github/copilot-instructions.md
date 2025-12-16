# Project Overview

This project is a work in progress for a web clicker game that allows users to play with animals from Natuurmonumenten.
User can view animals, habitats, and products to buy animals for the game.
It is built using Laravel, and uses sqlite for data storage.
The frontend is built using Tailwind CSS, and Breeze is used for authentication.

# Features, User Roles and Permissions

## Logged in Users

- Users can view and interact with animals.
- Users can view and manage their profile.
- Users can view and purchase products.
- Users can view habitats (areas) and the animals within them.

## Administrators

- Administrators can manage all users.
- Administrators can manage all animals.
- Administrators can manage habitats (areas).
- Administrators can manage products .

## Folder Structure

- `/routes`: Contains all the route definitions.
- `/app/Models`: Contains all the Eloquent models.
- `/app/Http/Controllers`: Contains all the controllers for handling requests.
- `/resources/views`: Contains all the Blade templates for rendering views.
- `/database/migrations`: Contains all the database migration files.
- `/public`: Contains all the public assets like CSS, JavaScript, and images.

## Libraries and Frameworks

- Tailwind CSS for the frontend.
- Laravel for the backend.
- Breeze for authentication.
- sqlite for data storage.
- blade-mdi icons library for icons.

## Coding Standards

- All input should be validated on the server side.
- Use Eloquent ORM for database interactions.
- OWASP security best practices should be followed.
- WCAG 2.1 Level A compliance for accessibility.
- Use Blade templating engine for views.

## UI guidelines

- A toggle is provided to switch between light and dark mode.
- Application should have a modern and clean design.
