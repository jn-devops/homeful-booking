<?php

namespace App\Filament\Exports;

use App\Models\PhilippineBarangay;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class PhilippineBarangayExporter extends Exporter
{
    protected static ?string $model = PhilippineBarangay::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('ID'),
            ExportColumn::make('region.region_description'),
            ExportColumn::make('province.province_description'),
            ExportColumn::make('city.city_municipality_description'),
            ExportColumn::make('barangay_code'),
            ExportColumn::make('barangay_description'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your philippine barangay export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
