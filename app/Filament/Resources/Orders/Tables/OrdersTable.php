<?php

namespace App\Filament\Resources\Orders\Tables;

use App\Models\Member;
use App\Models\Order;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class OrdersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('order_number')
                    ->label('Order Number')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->copyable(),

                TextColumn::make('member.name')
                    ->label('Customer')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('primary'),

                TextColumn::make('total_amount')
                    ->label('Total Amount')
                    ->money('TWD')
                    ->sortable()
                    ->alignEnd()
                    ->weight('bold'),

                TextColumn::make('status')
                    ->label('Order Status')
                    ->badge()
                    ->color(fn (string $state): string => Order::getStatusColor($state))
                    ->formatStateUsing(fn (string $state): string => Order::getStatusList()[$state] ?? $state),

                TextColumn::make('payment_status')
                    ->label('Payment Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        Order::PAYMENT_STATUS_PAID => 'success',
                        Order::PAYMENT_STATUS_PENDING => 'warning',
                        Order::PAYMENT_STATUS_FAILED => 'danger',
                        Order::PAYMENT_STATUS_REFUNDED => 'info',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        Order::PAYMENT_STATUS_PENDING => 'Pending',
                        Order::PAYMENT_STATUS_PAID => 'Paid',
                        Order::PAYMENT_STATUS_FAILED => 'Failed',
                        Order::PAYMENT_STATUS_REFUNDED => 'Refunded',
                        Order::PAYMENT_STATUS_PROCESSING => 'Processing',
                        default => $state,
                    }),

                TextColumn::make('shipping_status')
                    ->label('Shipping Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        Order::SHIPPING_STATUS_DELIVERED => 'success',
                        Order::SHIPPING_STATUS_SHIPPED => 'info',
                        Order::SHIPPING_STATUS_PENDING => 'warning',
                        Order::SHIPPING_STATUS_FAILED => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        Order::SHIPPING_STATUS_PENDING => 'Pending',
                        Order::SHIPPING_STATUS_SHIPPED => 'Shipped',
                        Order::SHIPPING_STATUS_ARRIVING => 'Arriving',
                        Order::SHIPPING_STATUS_ARRIVED_STORE => 'Arrived Store',
                        Order::SHIPPING_STATUS_DELIVERED => 'Delivered',
                        Order::SHIPPING_STATUS_RETURNING => 'Returning',
                        Order::SHIPPING_STATUS_RETURNED => 'Returned',
                        Order::SHIPPING_STATUS_REJECTED => 'Rejected',
                        Order::SHIPPING_STATUS_STORE_CLOSED => 'Store Closed',
                        Order::SHIPPING_STATUS_FAILED => 'Failed',
                        Order::SHIPPING_STATUS_EXPIRED => 'Expired',
                        default => $state,
                    }),

                TextColumn::make('payment_method')
                    ->label('Payment Method')
                    ->badge()
                    ->color('secondary')
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        Order::PAYMENT_METHOD_CREDIT => 'Credit Card',
                        Order::PAYMENT_METHOD_ATM => 'ATM Transfer',
                        Order::PAYMENT_METHOD_TRANSFER => 'Bank Transfer',
                        Order::PAYMENT_METHOD_COD => 'Cash on Delivery',
                        default => $state,
                    }),

                TextColumn::make('shipping_method')
                    ->label('Shipping Method')
                    ->badge()
                    ->color('info')
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        Order::SHIPPING_METHOD_MAIL => 'Mail Send',
                        Order::SHIPPING_METHOD_711 => '7-11 B2C',
                        Order::SHIPPING_METHOD_FAMILY => 'Family B2C',
                        default => $state,
                    }),

                TextColumn::make('recipient_name')
                    ->label('Recipient')
                    ->searchable()
                    ->sortable()
                    ->limit(20),

                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime('M j, Y g:i A')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('payment_date')
                    ->label('Payment Date')
                    ->dateTime('M j, Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Order Status')
                    ->options(Order::getStatusList()),

                SelectFilter::make('payment_status')
                    ->label('Payment Status')
                    ->options([
                        Order::PAYMENT_STATUS_PENDING => 'Pending',
                        Order::PAYMENT_STATUS_PAID => 'Paid',
                        Order::PAYMENT_STATUS_FAILED => 'Failed',
                        Order::PAYMENT_STATUS_REFUNDED => 'Refunded',
                        Order::PAYMENT_STATUS_PROCESSING => 'Processing',
                    ]),

                SelectFilter::make('shipping_status')
                    ->label('Shipping Status')
                    ->options([
                        Order::SHIPPING_STATUS_PENDING => 'Pending',
                        Order::SHIPPING_STATUS_SHIPPED => 'Shipped',
                        Order::SHIPPING_STATUS_ARRIVING => 'Arriving',
                        Order::SHIPPING_STATUS_ARRIVED_STORE => 'Arrived Store',
                        Order::SHIPPING_STATUS_DELIVERED => 'Delivered',
                        Order::SHIPPING_STATUS_RETURNING => 'Returning',
                        Order::SHIPPING_STATUS_RETURNED => 'Returned',
                        Order::SHIPPING_STATUS_REJECTED => 'Rejected',
                        Order::SHIPPING_STATUS_STORE_CLOSED => 'Store Closed',
                        Order::SHIPPING_STATUS_FAILED => 'Failed',
                        Order::SHIPPING_STATUS_EXPIRED => 'Expired',
                    ]),

                SelectFilter::make('payment_method')
                    ->label('Payment Method')
                    ->options([
                        Order::PAYMENT_METHOD_CREDIT => 'Credit Card',
                        Order::PAYMENT_METHOD_ATM => 'ATM Transfer',
                        Order::PAYMENT_METHOD_TRANSFER => 'Bank Transfer',
                        Order::PAYMENT_METHOD_COD => 'Cash on Delivery',
                    ]),

                SelectFilter::make('member_id')
                    ->label('Customer')
                    ->relationship('member', 'name')
                    ->searchable()
                    ->preload(),

                TrashedFilter::make(),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
