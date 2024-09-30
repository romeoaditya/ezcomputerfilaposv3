<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SupplierResource\Pages;
use App\Filament\Resources\SupplierResource\RelationManagers;
use App\Models\Supplier;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;



class SupplierResource extends Resource
{
    protected static ?string $model = Supplier::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';
    protected static ?string $label = 'Link Pembelian';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('link_pembelian')
                ->label('Link Eccomerce')
                ->placeholder('https://www.example.com')
                ->autocomplete('off')
                ->url() // Validasi URL
                ->required(), // Opsional, jika ingin wajib diisi
                Forms\Components\TextInput::make('nama_toko')->autocomplete('off')
                ->required()
                ->minLength(3),
                Forms\Components\TextInput::make('nama_produk')->autocomplete('off')
                
                ->required()
                ->minLength(3),
                Forms\Components\TextInput::make('harga')->autocomplete('off')
                ->required()
                ->minLength(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_produk')->searchable(),
                Tables\Columns\TextColumn::make('nama_toko')->searchable(),
                Tables\Columns\TextColumn::make('harga')->searchable(),
                TextColumn::make('link_pembelian')
                ->label('Link Eccomerce')
                ->url(fn ($record) => $record->link_pembelian) 
                ->openUrlInNewTab() 
                ->formatStateUsing(fn ($state) => 'Buka Link'), 
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSuppliers::route('/'),
            'create' => Pages\CreateSupplier::route('/create'),
            'edit' => Pages\EditSupplier::route('/{record}/edit'),
        ];
    }
}
