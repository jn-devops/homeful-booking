<?php

namespace App\Filament\Imports;

use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;
use Homeful\Products\Models\Product;

class ProductsImportImporter extends Importer
{
    protected static ?string $model = Product::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('sku')
                ->label('SKU')
                ->rules(['max:255']),
            ImportColumn::make('name')
                ->rules(['max:255']),
            ImportColumn::make('brand')
                ->rules(['max:255']),
            ImportColumn::make('category')
                ->rules(['max:255']),
            ImportColumn::make('description'),
            ImportColumn::make('price')
                ->requiredMapping()
                ->numeric()
                ->rules(['required']),
            ImportColumn::make('market_segment')
                ->rules(['max:255']),
            ImportColumn::make('location')
                ->guess(['project_location'])
                ->rules(['max:255']),
            ImportColumn::make('destinations')
                ->guess(['lifestyle_destinations']),
            ImportColumn::make('directions'),
            ImportColumn::make('amenities'),
            ImportColumn::make('facade_url')
                ->guess(['url_links']),
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
                ->numeric(),
            ImportColumn::make('floor_area')
                ->numeric(),
            ImportColumn::make('project_address'),
            ImportColumn::make('property_type')
                ->rules(['max:255']),
            ImportColumn::make('unit_type')
                ->rules(['max:255']),
        ];
    }

    public function resolveRecord(): ?Product
    {
        $facadeUrl = $this->data['facade_url'] ?? null;

        if ($facadeUrl) {
            // Decode the JSON string into an associative array
            $facadeData = json_decode($facadeUrl, true);

            // Check if the 'facade' key exists and get its value
            $facade = $facadeData['facade'] ?? null;
        }

        // Create a new Product instance
        $productN = new Product();

        // Assign the basic product details, ensuring null values are converted to empty strings
        $productN->sku = (string) ($this->data['sku'] ?? '');
        $productN->name = (string) ($this->data['name'] ?? '');
        $productN->brand = (string) ($this->data['brand'] ?? '');
        $productN->category = (string) ($this->data['category'] ?? '');
        $productN->description = (string) ($this->data['description'] ?? '');
        $productN->price = (float) ($this->data['price'] ?? 0);  // Assuming price should be a float
        $productN->market_segment = (string) ($this->data['market_segment'] ?? '');
        $productN->location = (string) ($this->data['location'] ?? '');
        $productN->directions = (string) ($this->data['directions'] ?? '');
        $productN->amenities = (string) ($this->data['amenities'] ?? '');
        $productN->facade_url = (string) ($facade ?? '');
        $productN->destinations = (string) ($this->data['destinations'] ?? '');

        // Additional fields assignment
        $productN->project_location = (string) ($this->data['project_location'] ?? '');
        $productN->project_code = (string) ($this->data['project_code'] ?? '');
        $productN->property_name = (string) ($this->data['property_name'] ?? '');
        $productN->phase = (string) ($this->data['phase'] ?? '');
        $productN->block = (string) ($this->data['block'] ?? '');
        $productN->lot = (string) ($this->data['lot'] ?? '');
        $productN->lot_area = (float) ($this->data['lot_area'] ?? 0);  // Assuming lot_area should be a float
        $productN->floor_area = (float) ($this->data['floor_area'] ?? 0);  // Assuming floor_area should be a float
        $productN->project_address = (string) ($this->data['project_address'] ?? '');
        $productN->property_type = (string) ($this->data['property_type'] ?? '');
        $productN->unit_type = (string) ($this->data['unit_type'] ?? '');

        // Save the product
        $productN->save();

        return $productN;
    }







    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your products import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
