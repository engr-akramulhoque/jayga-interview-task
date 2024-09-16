# Online Test Assignment Task
## Jayga Bangladesh


### Description:

<p>This task involves designing and developing a RESTful API using Laravel for managing products, categories, and product attributes. It includes setting up API controllers and routes, establishing complex relationships (one-to-many between categories and products, many-to-many between products and attributes), and implementing data validation. The task also requires creating a database schema with migrations, developing Eloquent models, and writing comprehensive unit and integration tests to ensure the functionality of CRUD operations. Example categories include Electronics, Clothing, and Home Appliances.</p>

## Requirements:

```bash
    "php": "^8.2",
    "laravel/framework": "^11.0",
```

# How to run the script?

### step 1: Clone the repository

```bash
    git clone https://github.com/engr-akramulhoque/jayga-interview-task.git
```

### step 2: Go to the Directory

```bash
    cd jayga-interview-task
```

### step 3: Install all dependencies

```bash
    composer install
    # or
    composer update
```

### step 4: Copy .env files

```bash
    cp .env.example .env
    # it will generate .env file from .env.example
```

### step 5: Configure environment

<p>Open .env file inside any of your code editor and fill all the following credentials</p>

```bash
    # Set .env configuration

    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=jayga_test_db
    DB_USERNAME=root
    DB_PASSWORD=
```

### step 6:

```bash
    php artisan key:generate
    # it will generate the application key
```

### step 6: Dump Database

```bash
    php artisan migrate
    # it will run the database migrations

    php artisan db:seed
    # it will seeding dummy data into the database
```

### step 7:

```bash
    php artisan serve
```

### contributions :

<p>
    Akramul Hoque (Software Engineer)<br>
</p>

<span>copyright: <a href="https://github.com/engr-akramulhoque">Engr-Akramul Hoque</a></span>

### Hope you enjoying this project. Have a good day!

## Thank you!
