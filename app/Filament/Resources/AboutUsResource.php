<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AboutUsResource\Pages;
use App\Models\AboutUs;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AboutUsResource extends Resource
{
    protected static ?string $model = AboutUs::class;

    protected static ?string $navigationIcon = 'heroicon-o-information-circle';
    
    protected static ?string $navigationLabel = 'О нас';
    
    protected static ?string $navigationGroup = 'Контент';
    
    protected static ?string $slug = 'about-us';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Информация о студии')
                ->schema([
                    Forms\Components\Textarea::make('cover')
                        ->label('Общее фото')
                        ->rows(10)
                        ->required()
                        ->helperText('Ссылка на фотографию'),
                    Forms\Components\Textarea::make('info')
                        ->label('Текстовая информация')
                        ->rows(10)
                        ->required()
                        ->helperText('Основной текст о киностудии'),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('cover')
                    ->label('Фото')
                    ->square(),
                Tables\Columns\TextColumn::make('info')
                    ->label('Информация')
                    ->limit(100),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Обновлено')
                    ->dateTime()
                    ->sortable(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ;
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAboutUs::route('/'),
            'edit' => Pages\EditAboutUs::route('/{record}/edit'),
        ];
    }
}