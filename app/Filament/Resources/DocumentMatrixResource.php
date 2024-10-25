<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DocumentMatrixResource\Pages;
use App\Filament\Resources\DocumentMatrixResource\RelationManagers;
use App\Models\DocumentMatrix;
use App\Models\Documents;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TagsColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DocumentMatrixResource extends Resource
{
    protected static ?string $model = DocumentMatrix::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Admin';
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\Select::make('civil_status_code')
                    ->preload()
                    ->relationship('civilStatus','description')
                    ->native(false)
                    ->required(),
                Forms\Components\Select::make('employment_status_code')
                    ->preload()
                    ->relationship('employmentStatus','description')
                    ->native(false)
                    ->required(),
                Forms\Components\Select::make('market_segment_code')
                    ->preload()
                    ->relationship('marketSegment','description')
                    ->native(false)
                    ->required(),
                Forms\Components\Select::make('documents')
                    ->preload()
                    ->multiple()
                    ->options(Documents::all()->pluck('description', 'code'))
                    ->native(false)
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('marketSegment.description')
                    ->searchable(),
                Tables\Columns\TextColumn::make('civilStatus.description')
                    ->searchable(),
                Tables\Columns\TextColumn::make('employmentStatus.description')
                    ->searchable(),
                TagsColumn::make('documents')
                    ->label('Documents')
                    ->getStateUsing(fn ($record) => $record->documentsDescriptions->toArray()),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageDocumentMatrices::route('/'),
        ];
    }
}
