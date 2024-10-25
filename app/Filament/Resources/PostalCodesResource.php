<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostalCodesResource\Pages;
use App\Filament\Resources\PostalCodesResource\RelationManagers;
use App\Models\PostalCodes;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PostalCodesResource extends Resource
{
    protected static ?string $model = PostalCodes::class;

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
                Forms\Components\TextInput::make('country_code')
                    ->required()
                    ->maxLength(2),
                Forms\Components\TextInput::make('postal_code')
                    ->required()
                    ->maxLength(20),
                Forms\Components\TextInput::make('place_name')
                    ->required()
                    ->maxLength(180),
                Forms\Components\TextInput::make('admin_name1')
                    ->maxLength(100),
                Forms\Components\TextInput::make('admin_code1')
                    ->maxLength(20),
                Forms\Components\TextInput::make('admin_name2')
                    ->maxLength(100),
                Forms\Components\TextInput::make('admin_code2')
                    ->maxLength(20),
                Forms\Components\TextInput::make('admin_name3')
                    ->maxLength(100),
                Forms\Components\TextInput::make('admin_code3')
                    ->maxLength(20),
                Forms\Components\TextInput::make('latitude')
                    ->numeric(),
                Forms\Components\TextInput::make('longitude')
                    ->numeric(),
                Forms\Components\TextInput::make('accuracy')
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('country_code')
                    ->searchable(),
                Tables\Columns\TextColumn::make('postal_code')
                    ->searchable(),
                Tables\Columns\TextColumn::make('place_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('admin_name1')
                    ->searchable(),
                Tables\Columns\TextColumn::make('admin_code1')
                    ->searchable(),
                Tables\Columns\TextColumn::make('admin_name2')
                    ->searchable(),
                Tables\Columns\TextColumn::make('admin_code2')
                    ->searchable(),
                Tables\Columns\TextColumn::make('admin_name3')
                    ->searchable(),
                Tables\Columns\TextColumn::make('admin_code3')
                    ->searchable(),
                Tables\Columns\TextColumn::make('latitude')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('longitude')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('accuracy')
                    ->numeric()
                    ->sortable(),
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
            'index' => Pages\ManagePostalCodes::route('/'),
        ];
    }
}
