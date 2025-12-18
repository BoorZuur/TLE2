# NM-klikker
NMklikker is a web clicker game that allows users to play with animals from Natuurmonumenten.
User can view animals, habitats, and products to buy animals for the game.

## ER Diagram
```mermaid
erDiagram
    users ||--o{ animals : "owns"
    users ||--o{ user_purchases : "makes"
    users ||--o{ user_species_unlocks : "unlocks"
    users ||--o{ user_friend : "has friends (user_id1)"
    users ||--o{ user_friend : "has friends (user_id2)"
    
    habitats ||--o{ species : "contains"
    
    species ||--o{ animals : "belongs to"
    species ||--o{ products : "related to"
    species ||--o{ user_species_unlocks : "unlocked by"
    
    products ||--o{ user_purchases : "purchased in"
    
    users {
        bigint id PK
        string username
        string email UK
        timestamp email_verified_at
        string password
        bigint coins
        bigint energy
        boolean is_admin
        string remember_token
        timestamp created_at
        timestamp updated_at
    }
    
    habitats {
        bigint id PK
        string name
        text description
        string info_image
        string image_0
        string image_20
        string image_40
        string image_60
        string image_80
        string image_100
    }
    
    species {
        bigint id PK
        string name
        string scientific_name
        string image
        string beheerder
        text info
        boolean locked
        smallint status
        bigint habitat_id FK
    }
    
    animals {
        bigint id PK
        bigint user_id FK
        string name
        bigint happiness
        bigint hunger
        bigint cleanliness
        bigint species_id FK
        timestamp adopted_at
        timestamp updated_at
        timestamp last_hunger_update
        timestamp last_fed
    }
    
    products {
        bigint id PK
        enum product_type
        string name
        text description
        text image_url
        decimal price
        enum currency_type
        bigint species_id FK
        json powerup_effects
        string qr_filename
        timestamp created_at
        timestamp updated_at
    }
    
    user_purchases {
        bigint id PK
        bigint user_id FK
        bigint product_id FK
        enum purchase_type
        decimal amount_paid
        timestamp created_at
        timestamp updated_at
    }
    
    user_species_unlocks {
        bigint id PK
        bigint user_id FK
        bigint species_id FK
        timestamp created_at
        timestamp updated_at
    }
    
    user_friend {
        bigint id PK
        bigint user_id1 FK
        bigint user_id2 FK
        timestamp sent_at
        boolean is_approved
    }
```

## Contributing

1. Clone the repository to your local machine.
2. Copy `.env.example` to `.env`.
3. Install the project dependencies using [Composer](https://getcomposer.org) with `composer install`.
4. Install npm dependencies using `npm install`.
5. Run `php artisan key:generate` to generate the application key.
6. Run `php artisan migrate` to create the database tables (type yes if you are asked to create a `.sqlite` file).
7. Finally run the application with `composer run dev`.

## Deployment
NMklikker is hosted at: http://145.24.237.18

The host is a VPS Provided by the Rotterdam University of Applied Sciences running Ubuntu 24.04 server with nginx.

[These](https://github.com/HR-CMGT/PRG05-2025-2026/blob/main/deployment-tle/README.md) instructions were used to deploy the application.


## Built With
![image](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![image](https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)

### Libraries & Packages

- [Laravel Breeze](https://github.com/laravel/breeze)
- [Blade MDI Icons](https://github.com/postare/blade-mdi)

## Edge cases
- When a user is created, that user automatically gets assigned a starter animal. For that to work there have to be species and habitats in the database. Seeders have been created to make that easier. Make sure to add `--seed` when migrating the database.
- Having too much coins could lead to an Integer overflow
