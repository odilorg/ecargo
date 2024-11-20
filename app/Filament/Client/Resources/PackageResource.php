<?php

namespace App\Filament\Client\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Package;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\Subcategory;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Repeater;
use Filament\Navigation\NavigationItem;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Client\Resources\PackageResource\Pages;
use App\Filament\Client\Resources\PackageResource\RelationManagers;

class PackageResource extends Resource
{

    // public static function getNavigationItems(): array
    // {
    //     return [
    //         NavigationItem::make('Packages')
    //             ->url('/client/packages')
    //             ->icon('heroicon-o-rectangle-stack')
    //             ->sort(1), // Order in the sidebar
    //         NavigationItem::make('Arrived')
    //             ->url('/client/packages?tableFilters[Waiting][isActive]=true')
    //             ->icon('heroicon-o-rectangle-stack')
    //             ->sort(2),
    //     ];
    // }

    protected static ?string $model = Package::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Посылки';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('tracking_number')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('purchase_source')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Hidden::make('user_id')
                    ->default(auth()->id()),
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
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();
        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['user_id'] = auth()->id();
        return $data;
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
                    // Tables\Columns\TextColumn::make('status')
                    // ->searchable(),    

            ])
            ->filters([
                // Filter::make('Waiting')->query(
                //     function (Builder $query): Builder {
                //         return $query->where('status', 'waiting');
                //     }
                // )
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
