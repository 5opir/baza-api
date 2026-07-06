<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FilmResource\Pages;
use App\Models\Film;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class FilmResource extends Resource
{
    protected static ?string $model = Film::class;

    protected static ?string $navigationIcon = 'heroicon-o-film';
    
    protected static ?string $navigationLabel = 'Кино и сериалы';
    
    protected static ?string $pluralLabel = 'Фильмы';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Основная информация')
                ->schema([
                    Forms\Components\Select::make('type')
                        ->options([
                            'fiction' => 'Художественное',
                            'documentary' => 'Документальное',
                        ])
                        ->required(),
                    Forms\Components\TextInput::make('title')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('genre')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('format')
                        ->required()
                        ->maxLength(255)
                        ->helperText('Например: "Полнометражный фильм" или "Сериал (8 серий)"'),
                ])->columns(2),

            Forms\Components\Section::make('Медиа')
                ->schema([
                    Forms\Components\Textarea::make('cover')
                        ->label('Обложка')
                        ->rows(10)
                        ->required()
                        ->helperText('Ссылка на обложку'),
                    Forms\Components\Textarea::make('poster')
                        ->label('Постер')
                        ->rows(10)
                        ->required()
                        ->helperText('Ссылка на постер'),
                    Forms\Components\TextInput::make('trailer_url')
                        ->label('URL трейлера')
                        ->url()
                        ->helperText('Ссылка на YouTube или другой видеохостинг'),
                ])->columns(2),

            Forms\Components\Section::make('Описание')
                ->schema([
                    Forms\Components\Textarea::make('description')
                        ->label('Краткое описание')
                        ->required()
                        ->rows(3)
                        ->helperText('Отображается на карточке'),
                    Forms\Components\RichEditor::make('full_description')
                        ->label('Полное описание')
                        ->helperText('Отображается на странице фильма'),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('cover')
                    ->label('Обложка')
                    ->square(),
                Tables\Columns\TextColumn::make('title')
                    ->label('Название')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('type')
                    ->label('Тип')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'fiction' => 'primary',
                        'documentary' => 'success',
                    }),
                Tables\Columns\TextColumn::make('genre')
                    ->label('Жанр'),
                Tables\Columns\TextColumn::make('format')
                    ->label('Формат'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Создано')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->options([
                        'fiction' => 'Художественное',
                        'documentary' => 'Документальное',
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

    public static function getRelations(): array
    {
        return [
            // Здесь добавим управление титрами
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFilms::route('/'),
            'create' => Pages\CreateFilm::route('/create'),
            'edit' => Pages\EditFilm::route('/{record}/edit'),
        ];
    }
}