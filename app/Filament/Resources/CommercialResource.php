<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CommercialResource\Pages;
use App\Models\Commercial;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CommercialResource extends Resource
{
    protected static ?string $model = Commercial::class;

    protected static ?string $navigationIcon = 'heroicon-o-video-camera';
    
    protected static ?string $navigationLabel = 'Реклама и клипы';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Основная информация')
                ->schema([
                    Forms\Components\Select::make('category')
                        ->options([
                            'advertising' => 'Реклама',
                            'image' => 'Имидж',
                            'clips' => 'Клипы',
                            'reels' => 'Reels',
                        ])
                        ->required(),
                    Forms\Components\TextInput::make('title')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('company')
                        ->label('Компания-заказчик')
                        ->required()
                        ->maxLength(255),
                ])->columns(2),

            Forms\Components\Section::make('Медиа')
                ->schema([
                    Forms\Components\Textarea::make('thumbnail')
                        ->label('Превью')
                        ->rows(10)
                        ->required()
                        ->helperText('Ссылка на превью'),
                    Forms\Components\Textarea::make('video_url')
                        ->label('URL видео')
                        ->url()
                        ->helperText('Ссылка на YouTube или другой видеохостинг'),
                ])->columns(2),

            Forms\Components\Section::make('Описание')
                ->schema([
                    Forms\Components\Textarea::make('description')
                        ->rows(4),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('thumbnail')
                    ->label('Превью')
                    ->square(),
                Tables\Columns\TextColumn::make('title')
                    ->label('Название')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('company')
                    ->label('Компания')
                    ->searchable(),
                Tables\Columns\TextColumn::make('category')
                    ->label('Категория')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'advertising' => 'primary',
                        'image' => 'success',
                        'clips' => 'warning',
                        'reels' => 'danger',
                    }),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->options([
                        'advertising' => 'Реклама',
                        'image' => 'Имидж',
                        'clips' => 'Клипы',
                        'reels' => 'Reels',
                    ]),
            ])
            ->actions([
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
            'index' => Pages\ListCommercials::route('/'),
            'create' => Pages\CreateCommercial::route('/create'),
            'edit' => Pages\EditCommercial::route('/{record}/edit'),
        ];
    }
}