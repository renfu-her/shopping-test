<?php

namespace App\Filament\Resources\Products\Tables;

use App\Models\Category;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class ProductsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('primaryImage.image_path')
                    ->label('Image')
                    ->circular()
                    ->size(50)
                    ->defaultImageUrl(asset('images/no-image.png')),

                TextColumn::make('name')
                    ->label('Product Name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->limit(30),

                TextColumn::make('category.name')
                    ->label('Category')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('primary'),

                TextColumn::make('price')
                    ->label('Price')
                    ->money('TWD')
                    ->sortable()
                    ->alignEnd(),

                TextColumn::make('cash_price')
                    ->label('Cash Price')
                    ->money('TWD')
                    ->sortable()
                    ->alignEnd()
                    ->color('success'),

                TextColumn::make('stock')
                    ->label('Stock')
                    ->numeric()
                    ->sortable()
                    ->alignCenter()
                    ->color(fn ($state) => $state > 10 ? 'success' : ($state > 0 ? 'warning' : 'danger')),

                ToggleColumn::make('is_active')
                    ->label('Active')
                    ->onColor('success')
                    ->offColor('danger'),

                IconColumn::make('is_new')
                    ->label('New')
                    ->boolean()
                    ->trueIcon('heroicon-o-star')
                    ->falseIcon('heroicon-o-star')
                    ->trueColor('warning')
                    ->falseColor('gray'),

                IconColumn::make('is_hot')
                    ->label('Hot')
                    ->boolean()
                    ->trueIcon('heroicon-o-fire')
                    ->falseIcon('heroicon-o-fire')
                    ->trueColor('danger')
                    ->falseColor('gray'),

                TextColumn::make('sort_order')
                    ->label('Sort')
                    ->numeric()
                    ->sortable()
                    ->alignCenter(),

                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime('M j, Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('category_id')
                    ->label('Category')
                    ->relationship('category', 'name')
                    ->searchable()
                    ->preload(),

                TernaryFilter::make('is_active')
                    ->label('Active Status')
                    ->placeholder('All products')
                    ->trueLabel('Active only')
                    ->falseLabel('Inactive only'),

                TernaryFilter::make('is_new')
                    ->label('New Products')
                    ->placeholder('All products')
                    ->trueLabel('New products only')
                    ->falseLabel('Not new products'),

                TernaryFilter::make('is_hot')
                    ->label('Hot Products')
                    ->placeholder('All products')
                    ->trueLabel('Hot products only')
                    ->falseLabel('Not hot products'),

                SelectFilter::make('stock_status')
                    ->label('Stock Status')
                    ->options([
                        'in_stock' => 'In Stock',
                        'low_stock' => 'Low Stock (1-10)',
                        'out_of_stock' => 'Out of Stock',
                    ])
                    ->query(function ($query, array $data) {
                        return match ($data['value']) {
                            'in_stock' => $query->where('stock', '>', 10),
                            'low_stock' => $query->whereBetween('stock', [1, 10]),
                            'out_of_stock' => $query->where('stock', 0),
                            default => $query,
                        };
                    }),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
