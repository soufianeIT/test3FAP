<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            Forms\Components\TextInput::make('title')
                ->required()
                ->label('Title'),
            Forms\Components\TextInput::make('slug')
                ->required()
                ->label('Slug'),
            Forms\Components\TextInput::make('subtitle')
                ->required()
                ->label('Subtitle'),
            Forms\Components\Textarea::make('description')
                ->label('Description'),
            Forms\Components\TextInput::make('price')
                ->required()
                ->numeric()
                ->label('Price'),
            // Forms\Components\TagsInput::make('categories')
            //     ->label('Categories')
            //     ->placeholder('Select categories...')
            //     ->options(\App\Models\Category::all()->pluck('name', 'id')->toArray())
            //     ->saveToPivotTable('category_product')
            //     ->relationshipTo('categories'),
            Forms\Components\Select::make('category_id')->relationship('categories', 'name'),
            Forms\Components\FileUpload::make('image')
                ->label('Product Image')
                ->image()
                ->directory('product-images')
                ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            Tables\Columns\TextColumn::make('title')
                ->label('Title')
                ->sortable()
                ->searchable(),
            Tables\Columns\TextColumn::make('slug')
                ->label('Slug')
                ->sortable(),
            Tables\Columns\TextColumn::make('subtitle')
                ->label('Subtitle')
                ->sortable(),
            Tables\Columns\TextColumn::make('description')
                ->label('Description')
                ->limit(50),
            Tables\Columns\TextColumn::make('price')
                ->label('Price')
                ->sortable(),
            // Tables\Columns\TextColumn::make('categories')
            //     ->label('Categories')
            //     ->getValue(function ($product) {
            //         return $product->categories->pluck('name')->implode(', ');
            //         }),

            Tables\Columns\ImageColumn::make('image')
                ->label('Product Image')
                ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
           // 'categories' => \App\Filament\Resources\CategoryResource::class,

        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
