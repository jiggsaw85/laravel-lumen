# Lumen - API CRUD

## Local environment setup

Clone the repo
```
git clone git@github.com:jiggsaw85/laravel-lumen.git`
```

Install project
```
cd laravel-lumen && composer install
```

Create .env file
```
cp .env.example .env
```

NOTE: Create database in your local and put your db credentials in .env file

Run migrations
```
php artisan migrate
```

Start the application
```
php -S localhost:8080 public
```

## Available endpoints

### Authentication with Auth0
Get application token (Auth0)
```
GET /auth
```

### Positions
Create position
```
POST /api/positions
HEADERS: Authorization Bearer {token}
BODY: {
    "name": "string|required",
    "type": "string|required" (regular|management)
}
```

List all positions
```
GET /api/positions
HEADERS: Authorization Bearer {token}
```

Get single position
```
GET /api/positions/{id}
HEADERS: Authorization Bearer {token}
```

Edit position
```
PUT /api/positions/{id}
HEADERS: Authorization Bearer {token}
BODY: {
    "name": "string",
    "type": "string" (regular|management)
}
```

Delete position
```
DELETE /api/positions/{id}
HEADERS: Authorization Bearer {token}
```

### Employees
Create employee
```
POST /api/employees
HEADERS: Authorization Bearer {token}
BODY: {
    "name": "string|required",
    "position_id": "int|required",
    "superior_id": "int|optional",
    "start_date": "date|required", (Y-m-d)
    "end_date": "date|required",   (Y-m-d)
}
```

List all employees
```
GET /api/employees
HEADERS: Authorization Bearer {token}
```

Get single employee
```
GET /api/employees/{id}
HEADERS: Authorization Bearer {token}
```

Edit employee
```
PUT /api/employees/{id}
HEADERS: Authorization Bearer {token}
BODY: {
    "name": "string|optional",
    "position_id": "int|optional",
    "superior_id": "int|optional",
    "start_date": "date|optional", (Y-m-d)
    "end_date": "date|optional",   (Y-m-d)
}
```

Delete employee
```
DELETE /api/employees/{id}
HEADERS: Authorization Bearer {token}
```

Get all employees which belongs to superior
```
GET /api/superior/employees/{id}
HEADERS: Authorization Bearer {token}
```

Get all employees with specific position
```
GET /api/employees/position/{id}
HEADERS: Authorization Bearer {token}
```