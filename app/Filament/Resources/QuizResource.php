<?php

namespace App\Filament\Resources;

use App\Filament\Resources\QuizResource\Pages;
use App\Models\Quiz;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Tabs;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class QuizResource extends Resource
{
    protected static ?string $model = Quiz::class;

    protected static ?string $navigationIcon = 'heroicon-o-question-mark-circle';

    protected static ?string $navigationGroup = 'Обучение';

    protected static ?string $modelLabel = 'Тест';

    protected static ?string $pluralModelLabel = 'Тесты';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('lesson_id')
                    ->relationship('lesson', 'title_ru')
                    ->required()
                    ->label('Урок'),
                Select::make('question_type')
                    ->options([
                        'multiple' => 'Множественный выбор',
                        'single' => 'Одиночный выбор',
                        'true_false' => 'Верно/Неверно',
                        'input' => 'Ввод текста'
                    ])
                    ->required()
                    ->label('Тип вопроса'),
                Tabs::make('Переводы')
                    ->tabs([
                        Tabs\Tab::make('Русский')
                            ->schema([
                                Textarea::make('question_text_ru')
                                    ->required()
                                    ->label('Текст вопроса'),
                                Repeater::make('options_ru')
                                    ->schema([
                                        TextInput::make('option')
                                            ->required()
                                            ->label('Вариант ответа'),
                                    ])
                                    ->label('Варианты ответов')
                                    ->minItems(2)
                                    ->defaultItems(4)
                                    ->columns(2),
                                TextInput::make('correct_answer_ru')
                                    ->required()
                                    ->label('Правильный ответ'),
                            ]),
                        Tabs\Tab::make('Казахский')
                            ->schema([
                                Textarea::make('question_text_kk')
                                    ->label('Текст вопроса'),
                                Repeater::make('options_kk')
                                    ->schema([
                                        TextInput::make('option')
                                            ->label('Вариант ответа'),
                                    ])
                                    ->label('Варианты ответов')
                                    ->minItems(2)
                                    ->defaultItems(4)
                                    ->columns(2),
                                TextInput::make('correct_answer_kk')
                                    ->label('Правильный ответ'),
                            ]),
                        Tabs\Tab::make('Английский')
                            ->schema([
                                Textarea::make('question_text_en')
                                    ->label('Текст вопроса'),
                                Repeater::make('options_en')
                                    ->schema([
                                        TextInput::make('option')
                                            ->label('Вариант ответа'),
                                    ])
                                    ->label('Варианты ответов')
                                    ->minItems(2)
                                    ->defaultItems(4)
                                    ->columns(2),
                                TextInput::make('correct_answer_en')
                                    ->label('Правильный ответ'),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('lesson.title_ru')
                    ->sortable()
                    ->searchable()
                    ->label('Урок'),
                Tables\Columns\TextColumn::make('question_text_ru')
                    ->searchable()
                    ->limit(50)
                    ->label('Вопрос'),
                Tables\Columns\TextColumn::make('question_type')
                    ->searchable()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'multiple' => 'Множественный выбор',
                        'single' => 'Одиночный выбор',
                        'true_false' => 'Верно/Неверно',
                        'input' => 'Ввод текста',
                        default => $state,
                    })
                    ->label('Тип'),
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
            'index' => Pages\ListQuizzes::route('/'),
            'create' => Pages\CreateQuiz::route('/create'),
            'edit' => Pages\EditQuiz::route('/{record}/edit'),
        ];
    }
}
