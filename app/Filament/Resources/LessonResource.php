<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LessonResource\Pages;
use App\Filament\Resources\LessonResource\RelationManagers;
use App\Models\Lesson;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\FileUpload;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LessonResource extends Resource
{
    protected static ?string $model = Lesson::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    protected static ?string $navigationGroup = 'Обучение';

    protected static ?string $modelLabel = 'Урок';

    protected static ?string $pluralModelLabel = 'Уроки';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('course_id')
                    ->relationship('course', 'title')
                    ->required()
                    ->label('Курс'),
                TextInput::make('title')
                    ->required()
                    ->maxLength(255)
                    ->label('Название'),
                Select::make('type')
                    ->options([
                        'text' => 'Текст',
                        'video' => 'Видео',
                        'audio' => 'Аудио',
                        'quiz' => 'Тест',
                        'practice' => 'Практика'
                    ])
                    ->required()
                    ->label('Тип'),
                RichEditor::make('content')
                    ->columnSpanFull()
                    ->label('Контент'),
                FileUpload::make('audio_url')
                    ->directory('lessons/audio')
                    ->acceptedFileTypes(['audio/mpeg', 'audio/wav', 'audio/mp3'])
                    ->maxSize(50 * 1024)
                    ->label('Аудио файл'),
                FileUpload::make('video_url')
                    ->directory('lessons/video')
                    ->acceptedFileTypes(['video/mp4', 'video/mpeg', 'video/quicktime'])
                    ->maxSize(500 * 1024)
                    ->label('Видео файл'),
                TextInput::make('order')
                    ->numeric()
                    ->default(0)
                    ->required()
                    ->label('Порядок'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('course.title')
                    ->sortable()
                    ->searchable()
                    ->label('Курс'),
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->label('Название'),
                Tables\Columns\TextColumn::make('type')
                    ->searchable()
                    ->label('Тип'),
                Tables\Columns\TextColumn::make('order')
                    ->numeric()
                    ->sortable()
                    ->label('Порядок'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('Создан'),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('Обновлен'),
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
            'index' => Pages\ListLessons::route('/'),
            'create' => Pages\CreateLesson::route('/create'),
            'edit' => Pages\EditLesson::route('/{record}/edit'),
        ];
    }
}
