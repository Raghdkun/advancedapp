# Useful Commands

## Server Management

### Start Development Server
```bash
cd c:\Users\Jaden\Desktop\advancedapp\backend\dynamicForms
php artisan serve
```
Server will be available at: `http://127.0.0.1:8000`

### Stop Server
Press `Ctrl+C` in the terminal

## Database Commands

### Run Migrations
```bash
php artisan migrate
```

### Fresh Migration (Drop all tables and re-migrate)
```bash
php artisan migrate:fresh
```

### Seed Database
```bash
php artisan db:seed
```

### Fresh Migration with Seeding
```bash
php artisan migrate:fresh --seed
```

### Rollback Last Migration
```bash
php artisan migrate:rollback
```

## Cache Commands

### Clear All Caches
```bash
php artisan optimize:clear
```

### Clear Specific Caches
```bash
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear
```

### Cache Configuration
```bash
php artisan config:cache
php artisan route:cache
```

## Route Commands

### List All Routes
```bash
php artisan route:list
```

### List API Routes Only
```bash
php artisan route:list --path=api
```

### List Routes with Details
```bash
php artisan route:list --verbose
```

## Artisan Make Commands

### Create New Model
```bash
php artisan make:model ModelName
```

### Create Model with Migration
```bash
php artisan make:model ModelName -m
```

### Create Controller
```bash
php artisan make:controller ControllerName
```

### Create API Controller
```bash
php artisan make:controller Api/ControllerName --api
```

### Create Form Request
```bash
php artisan make:request RequestName
```

### Create Migration
```bash
php artisan make:migration create_table_name
```

### Create Seeder
```bash
php artisan make:seeder SeederName
```

## Testing with cURL (PowerShell)

### GET Request
```powershell
Invoke-WebRequest -Uri "http://127.0.0.1:8000/api/field-types" -Method GET
```

### POST Request
```powershell
$body = @{
    name = "Test Form"
    description = "Test Description"
} | ConvertTo-Json

Invoke-WebRequest -Uri "http://127.0.0.1:8000/api/forms" `
    -Method POST `
    -Body $body `
    -ContentType "application/json"
```

### PUT Request
```powershell
$body = @{
    name = "Updated Form"
} | ConvertTo-Json

Invoke-WebRequest -Uri "http://127.0.0.1:8000/api/forms/1" `
    -Method PUT `
    -Body $body `
    -ContentType "application/json"
```

### DELETE Request
```powershell
Invoke-WebRequest -Uri "http://127.0.0.1:8000/api/forms/1" -Method DELETE
```

## Composer Commands

### Install Dependencies
```bash
composer install
```

### Update Dependencies
```bash
composer update
```

### Dump Autoload
```bash
composer dump-autoload
```

## Debugging

### Enable Debug Mode
Edit `.env` file:
```
APP_DEBUG=true
```

### Tinker (Laravel REPL)
```bash
php artisan tinker
```

Example in Tinker:
```php
// Get all forms
App\Models\Form::all();

// Create a form
App\Models\Form::create(['name' => 'Test', 'version' => 1]);

// Get field types
App\Models\FieldType::all();
```

## Git Commands (if using version control)

### Initialize Repository
```bash
git init
```

### Add All Files
```bash
git add .
```

### Commit Changes
```bash
git commit -m "Initial commit - Dynamic Forms API"
```

### Check Status
```bash
git status
```

## Quick API Tests

### Test Field Types Endpoint
```bash
# PowerShell
Invoke-RestMethod -Uri "http://127.0.0.1:8000/api/field-types" -Method GET
```

### Test Create Form
```bash
# PowerShell
$formData = @{
    name = "Contact Form"
    description = "Simple contact form"
    fields = @(
        @{
            label = "Name"
            field_type_id = 1
            is_required = $true
        }
    )
} | ConvertTo-Json -Depth 10

Invoke-RestMethod -Uri "http://127.0.0.1:8000/api/forms" `
    -Method POST `
    -Body $formData `
    -ContentType "application/json"
```

## Environment Setup

### Copy Environment File
```bash
cp .env.example .env
```

### Generate Application Key
```bash
php artisan key:generate
```

### Set Database Configuration
Edit `.env` file:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

## Maintenance

### Put Application in Maintenance Mode
```bash
php artisan down
```

### Bring Application Back Up
```bash
php artisan up
```

## Logs

### View Logs
```bash
# Windows
type storage\logs\laravel.log

# View last 50 lines
Get-Content storage\logs\laravel.log -Tail 50
```

### Clear Logs
```bash
# Windows
del storage\logs\laravel.log
```

## Performance

### Optimize Application
```bash
php artisan optimize
```

### Generate Manifest
```bash
php artisan package:discover
```

## Common Issues

### Permission Issues
```bash
# Windows - Run PowerShell as Administrator
icacls "storage" /grant "Users:(OI)(CI)F" /T
icacls "bootstrap/cache" /grant "Users:(OI)(CI)F" /T
```

### Clear Everything and Start Fresh
```bash
php artisan optimize:clear
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
composer dump-autoload
```

---

## Quick Reference: API Endpoints

```
GET    /api/field-types
GET    /api/field-types/{id}

GET    /api/forms
POST   /api/forms
GET    /api/forms/{id}
PUT    /api/forms/{id}
DELETE /api/forms/{id}
POST   /api/forms/{id}/duplicate

GET    /api/fields?form_id=X
POST   /api/fields
GET    /api/fields/{id}
PUT    /api/fields/{id}
DELETE /api/fields/{id}

GET    /api/submissions?form_id=X
GET    /api/submissions/{id}
DELETE /api/submissions/{id}
POST   /api/forms/{id}/submit
POST   /api/forms/{id}/submissions/query
GET    /api/forms/{id}/submissions/statistics
```
