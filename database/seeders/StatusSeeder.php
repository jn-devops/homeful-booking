<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            'Approved',
            'Cancelled',
            'Disapproved',
            'Not Qualified',
            'Pre-Qualified',
            'Qualified for Document Pending',
            'Qualified for Document Signing',
            'Qualified for Document Uploading',
            'Qualified for Filing',
            'Qualified for Signing',
            'Send Form to Add Co-Borrower',
            'Send to Add Co-Borrower',
        ];
        foreach ($data as $index => $d) {
            Status::updateOrCreate(['code' => str_pad($index + 1, 3, '0', STR_PAD_LEFT)], ['description' => $d]);
        }
    }
}
