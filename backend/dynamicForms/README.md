
# Let's build a dynamic forms system designed as api

the idea of the system is createing a dynamic form builder so we should create the form with it's details

we should have table for types of the fields for example: text-email,password,dropdown,ratio,checkbox,attach etc..
with thier vaildations

the version of the form

let's build it with advanced querying on individual field values

and fit it with flutter application (no need to provide code for now)

first give me a suggestions "tables and relations"

after that we will make them migrations and models

To build a dynamic forms system with API support and advanced querying on individual field values, here are suggestions for tables and their relationships that cover:

- Form metadata and versions
- Field definitions including types and validations
- Field options for dropdowns, radios, etc.
- Storing user-submitted form responses with individual field values for querying

***

## Suggested Tables and Relations

### Forms

- id (PK)
- name (string)
- description (text, nullable)
- version (integer)
- is_active (boolean)
- created_at, updated_at (timestamps)


### FieldTypes

- id (PK)
- name (string) — e.g., "text", "email", "password", "dropdown", "radio", "checkbox", "attach"
- description (string, nullable)


### FormFields

- id (PK)
- form_id (FK -> Forms.id)
- label (string) — field label shown on form
- field_type_id (FK -> FieldTypes.id)
- validation_rules (json or text) — e.g., required, min/max length, pattern
- order (integer) — position of the field in the form
- is_required (boolean)
- created_at, updated_at (timestamps)


### FieldOptions

- id (PK)
- form_field_id (FK -> FormFields.id)
- value (string)
- label (string)
- order (integer)


### FormSubmissions

- id (PK)
- form_id (FK -> Forms.id)
- submission_date (timestamp)
- user_id (nullable FK if user system exists)
- created_at, updated_at


### SubmissionFieldValues

- id (PK)
- form_submission_id (FK -> FormSubmissions.id)
- form_field_id (FK -> FormFields.id)
- value (text) — store submitted value, considering varied types (string, JSON, etc.)
- created_at, updated_at

***

## Relations Overview

- Forms has many FormFields
- FormFields belongs to one FieldType
- FormFields may have many FieldOptions (for dropdown, radio, checkbox)
- Forms have many FormSubmissions
- FormSubmissions have many SubmissionFieldValues linked to FormFields

***

This structure supports:

- Multiple form versions via version tracking in Forms
- Advanced querying by connecting SubmissionFieldValues with their fields
- Field validation rules stored dynamically in JSON or similar format for flexibility
- Flexible field types and options expandable in FieldTypes and FieldOptions



Let's build the models and the migration in a clean way 

after that let's build : 


## Services

- **FormService**
    - Handles business logic for form creation, updating versions, retrieving forms with fields and options.
    - Performs validation logic delegation using validation rules from fields.
    - Orchestrates form version management.
- **FieldService**
    - Manages field definitions including field types and validations.
    - Handles creation and updates of form fields and their options.
    - Provides logic for field validation rules formatting and parsing.
- **SubmissionService**
    - Processes form submissions, storing submitted data aligned with fields.
    - Handles advanced querying on submissions based on individual field values.
    - Manages retrieval and aggregation of submission data and statistics.

***

## Requests (Form Request Validation)

- **CreateFormRequest**
    - Validates input for creating a form including name, description, version, and initial fields structure.
- **UpdateFormRequest**
    - Validates input for updating form metadata or fields, including validation rules adjustments.
- **CreateFieldRequest**
    - Validates field creation data focusing on label, type, validation rules, and options if necessary.
- **SubmitFormRequest**
    - Validates submitted form values by dynamically applying validation rules from the form’s field definitions.
- **QuerySubmissionRequest**
    - Validates parameters for querying submission data by field values with filters, ranges, and conditions.

***

## Repositories

- **FormRepository**
    - Abstracts all database interactions related to the Forms table including eager loading fields and options.
    - Supports versioning queries and active form filtering.
- **FieldRepository**
    - Manages CRUD operations on form fields and fetching their types and validation schemas.
- **FieldTypeRepository**
    - Accesses predefined field types for dropdowns and validation defaults.
- **FieldOptionRepository**
    - Handles storage and retrieval of options for applicable field types.
- **SubmissionRepository**
    - Manages form submissions records and links to submission values.
    - Supports querying by field inputs for analytics and reports.
- **SubmissionFieldValueRepository**
    - Handles storage and retrieval of submitted values per field with indexing for efficient queries.

***

## Controllers

- **FormController**
    - Endpoints for creating, updating, listing, and retrieving form metadata and structure.
    - Supports fetching specific form versions.
- **FieldController**
    - Manages endpoints for adding, updating, and retrieving fields in a form.
    - Includes endpoints for managing field options.
- **SubmissionController**
    - Handles endpoints for submitting filled forms.
    - Provides querying endpoints with filters according to field values for analytics.
- **FieldTypeController**
    - Exposes available field types and their schemas for frontend form builder use.



