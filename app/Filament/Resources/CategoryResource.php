<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Filament\Resources\CategoryResource\RelationManagers;
use App\Models\Category;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                Forms\Components\TextInput::make('name')
                ->label('Name')
                ->required(),
            Forms\Components\TextInput::make('slug')
                ->label('Slug')
                ->required(),
        ]);
    
        // Ajoutez un groupe de champs pour les produits
        $productsGroup = Forms\Components\ComponentGroup::make('products')
            ->label('Products');
    
        // Ajoutez un bouton pour ajouter de nouveaux champs de produits
        $addProductButton = Forms\Components\Button::make('add_product')
            ->label('Add Product')
            ->variant('primary')
            ->onClick(<<<'JS'
                (event, form) => {
                    const productFields = form.getField('products').fields();
                    const index = productFields.length;
                    const newProductFields = {
                        product_id: Forms.Components.RelationSelect.make(`products.${index}.product_id`)
                            .label('Product')
                            .relationshipTo('products')
                            .display('name')
                            .searchable(),
                    };
                    form.getField('products').addFields(newProductFields);
                }
            JS);
    
        $form->addComponent($addProductButton);
    
        $form->addComponent($productsGroup);
    
            
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            Tables\Columns\TextColumn::make('name')
                ->label('Name')
                ->sortable()
                ->searchable(),
            Tables\Columns\TextColumn::make('slug')
                ->label('Slug')
                ->sortable(),
            // Tables\Columns\TextColumn::make('created_at')
            //     ->label('Created At')
            //     ->sortable(),
            // Tables\Columns\TextColumn::make('updated_at')
            //     ->label('Updated At')
            //     ->sortable(),
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
            
          // 'products' => \App\Filament\Resources\ProductResource::class,

        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}
