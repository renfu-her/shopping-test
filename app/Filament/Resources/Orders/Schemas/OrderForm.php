<?php

namespace App\Filament\Resources\Orders\Schemas;

use App\Models\Member;
use App\Models\Order;
use Filament\Forms\Components\DatePicker;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class OrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Order Information')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('order_number')
                                    ->label('Order Number')
                                    ->required()
                                    ->maxLength(255)
                                    ->unique(ignoreRecord: true),

                                Select::make('member_id')
                                    ->label('Customer')
                                    ->relationship('member', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->required(),
                            ]),

                        Grid::make(3)
                            ->schema([
                                TextInput::make('total_amount')
                                    ->label('Total Amount')
                                    ->numeric()
                                    ->prefix('$')
                                    ->required(),

                                TextInput::make('shipping_fee')
                                    ->label('Shipping Fee')
                                    ->numeric()
                                    ->prefix('$')
                                    ->default(0),

                                TextInput::make('payment_fee')
                                    ->label('Payment Fee')
                                    ->numeric()
                                    ->prefix('$')
                                    ->default(0),
                            ]),
                    ]),

                Section::make('Order Status')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                Select::make('status')
                                    ->label('Order Status')
                                    ->options(Order::getStatusList())
                                    ->required()
                                    ->default(Order::STATUS_PENDING),

                                Select::make('payment_status')
                                    ->label('Payment Status')
                                    ->options([
                                        Order::PAYMENT_STATUS_PENDING => 'Pending',
                                        Order::PAYMENT_STATUS_PAID => 'Paid',
                                        Order::PAYMENT_STATUS_FAILED => 'Failed',
                                        Order::PAYMENT_STATUS_REFUNDED => 'Refunded',
                                        Order::PAYMENT_STATUS_PROCESSING => 'Processing',
                                    ])
                                    ->required()
                                    ->default(Order::PAYMENT_STATUS_PENDING),

                                Select::make('shipping_status')
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
                                    ])
                                    ->required()
                                    ->default(Order::SHIPPING_STATUS_PENDING),
                            ]),
                    ]),

                Section::make('Payment Information')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Select::make('payment_method')
                                    ->label('Payment Method')
                                    ->options([
                                        Order::PAYMENT_METHOD_CREDIT => 'Credit Card',
                                        Order::PAYMENT_METHOD_ATM => 'ATM Transfer',
                                        Order::PAYMENT_METHOD_TRANSFER => 'Bank Transfer',
                                        Order::PAYMENT_METHOD_COD => 'Cash on Delivery',
                                    ]),

                                DatePicker::make('payment_date')
                                    ->label('Payment Date'),
                            ]),

                        Grid::make(2)
                            ->schema([
                                TextInput::make('trade_no')
                                    ->label('Trade Number')
                                    ->maxLength(255),

                                TextInput::make('cvs_payment_no')
                                    ->label('CVS Payment Number')
                                    ->maxLength(255),
                            ]),
                    ]),

                Section::make('Shipping Information')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Select::make('shipping_method')
                                    ->label('Shipping Method')
                                    ->options([
                                        Order::SHIPPING_METHOD_MAIL => 'Mail Send',
                                        Order::SHIPPING_METHOD_711 => '7-11 B2C',
                                        Order::SHIPPING_METHOD_FAMILY => 'Family B2C',
                                    ]),

                                Select::make('logistics_type')
                                    ->label('Logistics Type')
                                    ->options([
                                        Order::SHIPPING_TYPE_SEVEN => '7-11',
                                        Order::SHIPPING_TYPE_FAMILY => 'Family Mart',
                                        Order::SHIPPING_TYPE_HILIFE => 'Hi-Life',
                                        Order::SHIPPING_TYPE_OKMART => 'OK Mart',
                                        Order::SHIPPING_TYPE_HOME => 'Home Delivery',
                                    ]),
                            ]),

                        Grid::make(2)
                            ->schema([
                                TextInput::make('logistics_id')
                                    ->label('Logistics ID')
                                    ->maxLength(255),

                                TextInput::make('shipment_no')
                                    ->label('Shipment Number')
                                    ->maxLength(255),
                            ]),
                    ]),

                Section::make('Recipient Information')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('recipient_name')
                                    ->label('Recipient Name')
                                    ->required()
                                    ->maxLength(255),

                                TextInput::make('recipient_phone')
                                    ->label('Recipient Phone')
                                    ->tel()
                                    ->required()
                                    ->maxLength(255),
                            ]),

                        Grid::make(3)
                            ->schema([
                                TextInput::make('recipient_county')
                                    ->label('County')
                                    ->maxLength(255),

                                TextInput::make('recipient_district')
                                    ->label('District')
                                    ->maxLength(255),

                                TextInput::make('recipient_zipcode')
                                    ->label('Zip Code')
                                    ->maxLength(255),
                            ]),

                        Textarea::make('recipient_address')
                            ->label('Address')
                            ->rows(2)
                            ->maxLength(500),
                    ]),

                Section::make('Store Information (CVS)')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('store_id')
                                    ->label('Store ID')
                                    ->maxLength(255),

                                TextInput::make('store_name')
                                    ->label('Store Name')
                                    ->maxLength(255),
                            ]),

                        Textarea::make('store_address')
                            ->label('Store Address')
                            ->rows(2)
                            ->maxLength(500),
                    ]),

                Section::make('Invoice Information')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Select::make('invoice_type')
                                    ->label('Invoice Type')
                                    ->options([
                                        Order::INVOICE_TYPE_PERSONAL => 'Personal',
                                        Order::INVOICE_TYPE_COMPANY => 'Company',
                                        Order::INVOICE_TYPE_DONATION => 'Donation',
                                    ]),

                                TextInput::make('tax_id')
                                    ->label('Tax ID')
                                    ->maxLength(255),
                            ]),

                        Grid::make(2)
                            ->schema([
                                TextInput::make('company_name')
                                    ->label('Company Name')
                                    ->maxLength(255),

                                TextInput::make('invoice_title')
                                    ->label('Invoice Title')
                                    ->maxLength(255),
                            ]),

                        Grid::make(2)
                            ->schema([
                                TextInput::make('invoice_number')
                                    ->label('Invoice Number')
                                    ->maxLength(255),

                                DatePicker::make('issued_invoice_date')
                                    ->label('Issued Invoice Date'),
                            ]),

                        Toggle::make('invoice_checked')
                            ->label('Invoice Checked')
                            ->default(false),
                    ]),

                Section::make('Additional Information')
                    ->schema([
                        Textarea::make('note')
                            ->label('Order Note')
                            ->rows(3)
                            ->maxLength(1000),

                        Textarea::make('booking_note')
                            ->label('Booking Note')
                            ->rows(2)
                            ->maxLength(500),
                    ]),
            ]);
    }
}
