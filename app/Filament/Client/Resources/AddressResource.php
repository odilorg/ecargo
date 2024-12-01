<?php

namespace App\Filament\Client\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Address;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Client\Resources\AddressResource\Pages;
use App\Filament\Client\Resources\AddressResource\RelationManagers;

class AddressResource extends Resource
{
    protected static ?string $model = Address::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Мои Адреса';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('address_name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('first_name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('last_name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('paternal_name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('street')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('house_number')
                    ->required()
                    ->numeric()
                    ->maxLength(255),
                Forms\Components\TextInput::make('apartment_number')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('country')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('region')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('city')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('phone')
                    ->tel()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('id_number')
                    ->label('Passport or ID #')
                    ->required()
                    ->maxLength(20),
                Forms\Components\TextInput::make('pinfl')
                    ->required()
                   // ->numeric()
                    //->length(19)
                    ->mask('9 999999 999 999 9')
                      ->stripCharacters(' '),
                   // View::make('components.pinfl-link'),
                Forms\Components\TextInput::make('extra_info')
                    ->maxLength(255),
                Forms\Components\Hidden::make('user_id')
                    ->default(auth()->id()),
               
                
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
                Tables\Columns\TextColumn::make('address_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('first_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('last_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('paternal_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('street')
                    ->searchable(),
                Tables\Columns\TextColumn::make('house_number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('apartment_number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('country')
                    ->searchable(),
                Tables\Columns\TextColumn::make('region')
                    ->searchable(),
                Tables\Columns\TextColumn::make('city')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('id_number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('pinfl')
                    //->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('extra_info')
                    ->searchable(),
               
                Tables\Columns\TextColumn::make('full_name')
                    ->searchable(),
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
    public static function getEloquentQuery(): Builder
    {
        // Filter data to only include records belonging to the logged-in user
        return parent::getEloquentQuery()->where('user_id', auth()->id());
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
            'index' => Pages\ListAddresses::route('/'),
            'create' => Pages\CreateAddress::route('/create'),
            'edit' => Pages\EditAddress::route('/{record}/edit'),
        ];
    }
   

}
