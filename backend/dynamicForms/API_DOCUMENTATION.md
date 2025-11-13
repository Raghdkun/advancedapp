# Dynamic Forms API - Setup Complete

## Overview
A complete Laravel-based dynamic forms system with RESTful API endpoints.

## What Has Been Created

### Database Structure
- ✅ **field_types** - Stores available field types (text, email, dropdown, etc.)
- ✅ **forms** - Main forms table with versioning support
- ✅ **form_fields** - Fields belonging to each form
- ✅ **field_options** - Options for dropdown/radio/checkbox fields
- ✅ **form_submissions** - User form submissions
- ✅ **submission_field_values** - Individual field values for each submission

### Models (with relationships)
- ✅ FieldType
- ✅ Form
- ✅ FormField
- ✅ FieldOption
- ✅ FormSubmission
- ✅ SubmissionFieldValue

### Repositories (Clean Architecture)
- ✅ FormRepository
- ✅ FieldRepository
- ✅ FieldTypeRepository
- ✅ FieldOptionRepository
- ✅ SubmissionRepository
- ✅ SubmissionFieldValueRepository

### Services (Business Logic)
- ✅ FormService - Form CRUD, duplication, version management
- ✅ FieldService - Field management
- ✅ SubmissionService - Form submissions, querying, statistics

### Form Requests (Validation)
- ✅ CreateFormRequest
- ✅ UpdateFormRequest
- ✅ CreateFieldRequest
- ✅ SubmitFormRequest
- ✅ QuerySubmissionRequest

### API Controllers
- ✅ FormController - Full CRUD + duplication
- ✅ FieldController - Field management
- ✅ SubmissionController - Submissions + advanced querying
- ✅ FieldTypeController - List available field types

## API Endpoints

### Field Types
```
GET    /api/field-types           - Get all field types
GET    /api/field-types/{id}      - Get specific field type
```

### Forms
```
GET    /api/forms                 - Get all forms
POST   /api/forms                 - Create new form
GET    /api/forms/{id}            - Get specific form
PUT    /api/forms/{id}            - Update form
DELETE /api/forms/{id}            - Delete form
POST   /api/forms/{id}/duplicate  - Duplicate form (versioning)
```

### Fields
```
GET    /api/fields?form_id=X      - Get fields for a form
POST   /api/fields                - Create new field
GET    /api/fields/{id}           - Get specific field
PUT    /api/fields/{id}           - Update field
DELETE /api/fields/{id}           - Delete field
```

### Submissions
```
GET    /api/submissions?form_id=X&per_page=15  - Get all submissions
GET    /api/submissions/{id}                    - Get specific submission
DELETE /api/submissions/{id}                    - Delete submission
POST   /api/forms/{id}/submit                   - Submit form data
POST   /api/forms/{id}/submissions/query        - Advanced query by field values
GET    /api/forms/{id}/submissions/statistics   - Get submission statistics
```

## Features

### ✅ Form Management
- Create forms with multiple fields
- Update form metadata
- Version control
- Duplicate forms with new versions
- Activate/deactivate forms

### ✅ Field Types Supported
1. text - Single line text
2. email - Email validation
3. password - Password field
4. textarea - Multi-line text
5. number - Numeric input
6. dropdown - Select list
7. radio - Radio buttons
8. checkbox - Checkboxes
9. date - Date picker
10. time - Time picker
11. datetime - Date and time
12. file - File upload
13. url - URL validation
14. tel - Telephone number

### ✅ Advanced Features
- **Dynamic Validation**: Each field can have custom validation rules
- **Field Options**: Dropdowns, radios, and checkboxes support options
- **Advanced Querying**: Query submissions by individual field values
- **Multiple Filter Support**: Query submissions with multiple field filters
- **Statistics**: Get submission statistics per form
- **Pagination**: Submissions are paginated

## How to Run

### Start the Server
```bash
cd c:\Users\Jaden\Desktop\advancedapp\backend\dynamicForms
php artisan serve
```

Server will run at: `http://127.0.0.1:8000`

### Test with Postman
1. Import the `DynamicForms_API.postman_collection.json` file into Postman
2. The collection includes 30+ pre-configured requests
3. Base URL is set to `http://localhost:8000`

## Example Usage

### 1. Get Available Field Types
```
GET /api/field-types
```

### 2. Create a Contact Form
```json
POST /api/forms
{
  "name": "Contact Form",
  "description": "Simple contact form",
  "version": 1,
  "is_active": true,
  "fields": [
    {
      "label": "Full Name",
      "field_type_id": 1,
      "order": 0,
      "is_required": true,
      "validation_rules": ["min:3", "max:255"]
    },
    {
      "label": "Email Address",
      "field_type_id": 2,
      "order": 1,
      "is_required": true,
      "validation_rules": ["email"]
    }
  ]
}
```

### 3. Submit Form Data
```json
POST /api/forms/1/submit
{
  "data": {
    "1": "John Doe",
    "2": "john@example.com"
  }
}
```

### 4. Query Submissions
```json
POST /api/forms/1/submissions/query
{
  "field_id": 1,
  "value": "John"
}
```

## Database Seeded Data

The database is already seeded with 14 field types:
- text, email, password, textarea, number
- dropdown, radio, checkbox
- date, time, datetime
- file, url, tel

## Architecture

This project follows **Clean Architecture** principles:

```
Controllers (HTTP Layer)
    ↓
Services (Business Logic)
    ↓
Repositories (Data Access)
    ↓
Models (Eloquent ORM)
    ↓
Database
```

## Files Created

### Migrations
- 2025_11_13_005258_create_field_types_table.php
- 2025_11_13_005304_create_forms_table.php
- 2025_11_13_005310_create_form_fields_table.php
- 2025_11_13_005315_create_field_options_table.php
- 2025_11_13_005322_create_form_submissions_table.php
- 2025_11_13_005331_create_submission_field_values_table.php

### Seeders
- FieldTypeSeeder.php (seeds 14 field types)

### Models
- app/Models/FieldType.php
- app/Models/Form.php
- app/Models/FormField.php
- app/Models/FieldOption.php
- app/Models/FormSubmission.php
- app/Models/SubmissionFieldValue.php

### Repositories
- app/Repositories/FormRepository.php
- app/Repositories/FieldRepository.php
- app/Repositories/FieldTypeRepository.php
- app/Repositories/FieldOptionRepository.php
- app/Repositories/SubmissionRepository.php
- app/Repositories/SubmissionFieldValueRepository.php

### Services
- app/Services/FormService.php
- app/Services/FieldService.php
- app/Services/SubmissionService.php

### Form Requests
- app/Http/Requests/CreateFormRequest.php
- app/Http/Requests/UpdateFormRequest.php
- app/Http/Requests/CreateFieldRequest.php
- app/Http/Requests/SubmitFormRequest.php
- app/Http/Requests/QuerySubmissionRequest.php

### Controllers
- app/Http/Controllers/Api/FormController.php
- app/Http/Controllers/Api/FieldController.php
- app/Http/Controllers/Api/SubmissionController.php
- app/Http/Controllers/Api/FieldTypeController.php

### Routes
- routes/api.php (19 API endpoints defined)

### Documentation
- DynamicForms_API.postman_collection.json (Complete Postman collection)

## Next Steps

1. **Start the server**: `php artisan serve`
2. **Import Postman collection**: Use the provided JSON file
3. **Test endpoints**: Start with GET /api/field-types
4. **Create your first form**: Use the "Create Form" request in Postman
5. **Submit form data**: Test form submission functionality
6. **Query submissions**: Try advanced filtering

## Notes

- No authentication implemented (as per requirements)
- All endpoints are public
- Clean code with proper separation of concerns
- Full CRUD operations on all resources
- Advanced querying capabilities on submissions
- Proper validation on all inputs
- Database relationships properly defined
- Code follows PSR-12 standards

---

**System is ready for use!** 🚀
