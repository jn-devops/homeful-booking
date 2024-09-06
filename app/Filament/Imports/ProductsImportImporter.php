<?php

namespace App\Filament\Imports;

use App\Models\ProductsImport;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class ProductsImportImporter extends Importer
{
    protected static ?string $model = ProductsImport::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('code')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('project_location')
                ->rules(['max:255']),
            ImportColumn::make('project_code')
                ->rules(['max:255']),
            ImportColumn::make('property_name')
                ->rules(['max:255']),
            ImportColumn::make('phase')
                ->rules(['max:255']),
            ImportColumn::make('block')
                ->rules(['max:255']),
            ImportColumn::make('lot')
                ->rules(['max:255']),
            ImportColumn::make('lot_area')
                ->rules(['max:255']),
            ImportColumn::make('floor_area')
                ->rules(['max:255']),
            ImportColumn::make('project_address')
                ->rules(['max:255']),
            ImportColumn::make('property_type')
                ->rules(['max:255']),
            ImportColumn::make('unit_type')
                ->rules(['max:255']),
            ImportColumn::make('unit_type_interior')
                ->rules(['max:255']),
            ImportColumn::make('house_color')
                ->rules(['max:255']),
            ImportColumn::make('building')
                ->rules(['max:255']),
            ImportColumn::make('processing_fee')
                ->numeric(),
            ImportColumn::make('brand')
                ->rules(['max:255']),
            ImportColumn::make('sku')
                ->label('SKU')
                ->rules(['max:255']),
            ImportColumn::make('name')
                ->rules(['max:255']),
            ImportColumn::make('price')
                ->requiredMapping()
                ->numeric()
                ->rules(['required']),
            ImportColumn::make('market_segment')
                ->rules(['max:255']),
            ImportColumn::make('category')
                ->rules(['max:255']),
            ImportColumn::make('description'),
            ImportColumn::make('product_location_details'),
            ImportColumn::make('lifestyle_destinations'),
            ImportColumn::make('amenities'),
            ImportColumn::make('how_to_get_there'),
            ImportColumn::make('appraised_value')
                ->numeric(),
        ];
    }

    public function resolveRecord(): ?ProductsImport
    {
        // return ProductsImport::firstOrNew([
        //     // Update existing records, matching them by `$this->data['column_name']`
        //     'email' => $this->data['email'],
        // ]);

        return new ProductsImport();
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your products import import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
