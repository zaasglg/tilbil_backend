<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VocabularyResource\Pages;
use App\Models\Vocabulary;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Repeater;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class VocabularyResource extends Resource
{

    protected static ?string $model = Vocabulary::class;

    protected static ?string $navigationIcon = 'heroicon-o-language';

    protected static ?string $navigationGroup = 'Обучение';

    protected static ?string $modelLabel = 'Словарь';

    protected static ?string $pluralModelLabel = 'Словарь';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('lesson_id')
                    ->relationship('lesson', 'title')
                    ->required()
                    ->label('Урок'),
                TextInput::make('word_kz')
                    ->required()
                    ->label('Слово (Каз)'),
                TextInput::make('word_ru')
                    ->required()
                    ->label('Слово (Рус)'),
                TextInput::make('word_en')
                    ->required()
                    ->label('Слово (Анг)'),
                TextInput::make('transcription')
                    ->label('Транскрипция'),
                FileUpload::make('audio_url')
                    ->directory('vocabulary/audio')
                    ->acceptedFileTypes(['audio/mpeg', 'audio/wav', 'audio/mp3'])
                    ->maxSize(10 * 1024)
                    ->label('Аудио произношения'),
                Repeater::make('examples_kz')
                    ->schema([
                        TextInput::make('example')
                            ->label('Пример')
                            ->required(),
                    ])
                    ->label('Примеры (Каз)')
                    ->defaultItems(0)
                    ->reorderable(false),
                Repeater::make('examples_ru')
                    ->schema([
                        TextInput::make('example')
                            ->label('Пример')
                            ->required(),
                    ])
                    ->label('Примеры (Рус)')
                    ->defaultItems(0)
                    ->reorderable(false),
                Repeater::make('examples_en')
                    ->schema([
                        TextInput::make('example')
                            ->label('Пример')
                            ->required(),
                    ])
                    ->label('Примеры (Анг)')
                    ->defaultItems(0)
                    ->reorderable(false),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('lesson.title')
                    ->sortable()
                    ->searchable()
                    ->label('Урок'),
                Tables\Columns\TextColumn::make('word_kz')
                    ->searchable()
                    ->label('Слово (Каз)'),
                Tables\Columns\TextColumn::make('word_ru')
                    ->searchable()
                    ->label('Слово (Рус)'),
                Tables\Columns\TextColumn::make('word_en')
                    ->searchable()
                    ->label('Слово (Анг)'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('Создан'),
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListVocabularies::route('/'),
            'create' => Pages\CreateVocabulary::route('/create'),
            'edit' => Pages\EditVocabulary::route('/{record}/edit'),
        ];
    }
}
