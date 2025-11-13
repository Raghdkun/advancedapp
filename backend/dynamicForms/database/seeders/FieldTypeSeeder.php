<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FieldTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fieldTypes = [
            ['name' => 'text', 'description' => 'Single line text input'],
            ['name' => 'email', 'description' => 'Email address input'],
            ['name' => 'password', 'description' => 'Password input field'],
            ['name' => 'textarea', 'description' => 'Multi-line text input'],
            ['name' => 'number', 'description' => 'Numeric input'],
            ['name' => 'dropdown', 'description' => 'Dropdown select list'],
            ['name' => 'radio', 'description' => 'Radio button group'],
            ['name' => 'checkbox', 'description' => 'Checkbox input'],
            ['name' => 'date', 'description' => 'Date picker'],
            ['name' => 'time', 'description' => 'Time picker'],
            ['name' => 'datetime', 'description' => 'Date and time picker'],
            ['name' => 'file', 'description' => 'File upload field'],
            ['name' => 'url', 'description' => 'URL input'],
            ['name' => 'tel', 'description' => 'Telephone number input'],
        ];

        DB::table('field_types')->insert($fieldTypes);
    }
}
