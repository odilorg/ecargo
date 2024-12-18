<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Package;
use Filament\Forms\Get;
use App\Models\Category;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\Subcategory;
use Filament\Resources\Resource;
use Illuminate\Support\Collection;
use Filament\Tables\Filters\Filter;
use Illuminate\Support\Facades\Log;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Repeater;
use Filament\Tables\Columns\SelectColumn;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\PackageResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PackageResource\RelationManagers;

class PackageResource extends Resource
{
    protected static ?string $model = Package::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Shipment';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Package Name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('tracking_number')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('purchase_source')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                Select::make('status')
                    ->options([
                        'waiting' => 'Waiting',
                        'arrived' => 'Arrived',
                        'packing' => 'Packing',
                        'sent' => 'Sent',
                    ]),

                Repeater::make('products')
                    ->relationship()
                    ->label('Declaration')
                    ->schema([
                        Section::make('Product details')

                            ->schema([
                                Forms\Components\Select::make('category_id')
                                    ->relationship('category', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->reactive()
                                    ->required(),
                                // Subcategory field
                                Forms\Components\Select::make('subcategory_id')
                                    ->label('Subcategory')
                                    ->options(function (callable $get) {
                                        $categoryId = $get('category_id'); // Get the category_id dynamically
                                        if ($categoryId) {
                                            return Subcategory::where('category_id', $categoryId)->pluck('name', 'id');
                                        }
                                        return [];
                                    })
                                    ->searchable()
                                    ->preload()
                                    ->required(),

                                Forms\Components\TextInput::make('product_name')
                                    ->required()
                                    ->maxLength(255),
                            ])->columns(3),

                        Section::make('Add quantity')

                            ->schema([
                                Forms\Components\TextInput::make('quantity')
                                    ->required()
                                    ->numeric(),
                                Forms\Components\TextInput::make('amount')
                                    ->required()
                                    ->numeric(),
                            ])->columns(2),


                    ])->columnSpanFull()

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tracking_number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('purchase_source')
                    ->searchable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->numeric()
                    ->sortable(),
                SelectColumn::make('status')
                    ->options([
                        'waiting' => 'Waiting',
                        'arrived' => 'Arrived',
                        'packing' => 'Packing',
                        'sent' => 'Sent',
                    ]),
            ])
            ->filters([
                
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
            //  RelationManagers\ProductsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPackages::route('/'),
            'create' => Pages\CreatePackage::route('/create'),
            'edit' => Pages\EditPackage::route('/{record}/edit'),
        ];
    }
}
