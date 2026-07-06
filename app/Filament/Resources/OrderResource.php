<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-inbox';
    
    protected static ?string $navigationLabel = 'Заявки';
    
    protected static ?string $navigationGroup = 'Управление';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Информация о заявке')
                ->schema([
                    Forms\Components\TextInput::make('name')
                        ->label('Имя')
                        ->required(),
                    Forms\Components\TextInput::make('contact')
                        ->label('Контакт')
                        ->required()
                        ->helperText('Телефон или email'),
                    Forms\Components\TextInput::make('project_type')
                        ->label('Тип проекта'),
                    Forms\Components\Select::make('status')
                        ->options([
                            'new' => 'Новая',
                            'in_progress' => 'В работе',
                            'done' => 'Завершена',
                        ])
                        ->required(),
                    Forms\Components\Textarea::make('description')
                        ->label('Описание')
                        ->rows(4),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Имя')
                    ->searchable(),
                Tables\Columns\TextColumn::make('contact')
                    ->label('Контакт')
                    ->searchable(),
                Tables\Columns\TextColumn::make('project_type')
                    ->label('Тип проекта'),
                Tables\Columns\TextColumn::make('status')
                    ->label('Статус')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'new' => 'warning',
                        'in_progress' => 'primary',
                        'done' => 'success',
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Дата')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'new' => 'Новая',
                        'in_progress' => 'В работе',
                        'done' => 'Завершена',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
            //'view' => Pages\ViewOrder::route('/{record}'),
        ];
    }
}