<?php

namespace Database\Seeders;

use App\Models\Tenure;
use App\Models\WorkIndustry;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WorkIndustrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            'Accounting',
            "Activities of Private Households as Employer's & Undifferentiated Production Activities of Private Households",
            'Aerospace & Defense',
            'Agriculture, Hunting, Forestry & Fishing',
            'Air Freight & Logistics',
            'Automobile Components',
            'Automobiles',
            'Banks',
            'Basic Materials',
            'Beverages',
            'Biotechnology',
            'Broadline Retail',
            'Building Products',
            'Business Process and Outsourcing (BPO)',
            'Business Process Outsourcing (BPO)',
            'Capital Markets',
            'Chemicals',
            'Commercial Services & Supplies',
            'Communications Equipment',
            'Construction',
            'Construction & Engineering',
            'Construction Materials',
            'Consumer Finance',
            'Consumer Staples Distribution & Retail',
            'Containers & Packaging',
            'Distributors',
            'Diversified Consumer Services',
            'Diversified REITs',
            'Diversified Telecommunication Services',
            'Education',
            'Education & Training',
            'Electric Utilities',
            'Electrical Equipment',
            'Electricity, Gas and Water Supply',
            'Electronic Equipment, Instruments & Components',
            'Energy Equipment & Services',
            'Entertainment',
            'Extra-Territorial Organization & Bodies',
            'Financial Services',
            'Financial Services/ Intermediation',
            'Food Products',
            'Funeral',
            'Gas Utilities',
            'Ground Transportation',
            'Health and Social Work; Health and Medical Services',
            'Health Care Equipment & Supplies',
            'Health Care Providers & Services',
            'Health Care REITs',
            'Health Care Technology',
            'Hotel & Resort REITs',
            'Hotels, Restaurants & Leisure',
            'Household Durables',
            'Household Products',
            'HR/Recruitment',
            'HR/Recuritment',
            'Independent Power and Renewable Electricity Producers',
            'Industrial Conglomerates',
            'Industrial REITs',
            'Insurance',
            'Interactive Media & Services',
            'Internet Software & Services',
            'IT Services',
            'Leisure Products',
            'Life Sciences',
            'Life Sciences Tools & Services',
            'Machinery',
            'Management',
            'Manpower',
            'Manufacturing',
            'Marine Transportation',
            'Media',
            'Metals & Mining',
            'Mining & Quarrying',
            'Mining and Quarrying',
            'Mortgage Real Estate Investment Trusts (REITs)',
            'Multi-Utilities',
            'Office REITs',
            'Oil, Gas & Consumable Fuels',
            'Other Community, Social & Personal Service Activities',
            'Paper & Forest Products',
            'Passenger Airlines',
            'Personal Care Products',
            'Pharmaceuticals',
            'Professional Services',
            'Public Administration & Defense; Compulsory Social Security',
            'Real Estate Management & Development',
            'Residential REITs',
            'Retail REITs',
            'Semiconductors & Semiconductor Equipment',
            'Software',
            'Specialized REITs',
            'Specialty Retail',
            'Technology',
            'Technology Hardware, Storage & Peripherals',
            'Textiles, Apparel & Luxury Goods',
            'Tobacco',
            'Trading Companies & Distributors',
            'Transport, Storage & Communications',
            'Transport, Storage and Communications',
            'Transportation Infrastructure',
            'Travel & Leisure',
            'Unemployed',
            'Water Utilities',
            'Wholesale & Retail Trade; Repair of Motor vehicles, Motorcycles, Personal and Household Goods',
            'Wholesale & Retail Trade; Repair of Motor Vehicles, Motorcycles, Personal & Household Goods',
            'Wireless Telecommunication Services',
        ];

        foreach ($data as $index => $d) {
            WorkIndustry::updateOrCreate(['code' => str_pad($index + 1, 3, '0', STR_PAD_LEFT)], ['description' => $d]);
        }
    }
}