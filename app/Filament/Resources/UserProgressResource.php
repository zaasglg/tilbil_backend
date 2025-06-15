<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserProgressResource\Pages;
use App\Models\UserProgress;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserProgressResource extends Resource
{
    protected static ?string $model = UserProgress::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

    protected static ?string $navigationGroup = 'Пользователи';

    protected static ?string $modelLabel = 'Прогресс';

    protected static ?string $pluralModelLabel = 'Прогресс пользователей';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required()
                    ->searchable()
                    ->label('Пользователь'),
                Select::make('level_id')
                    ->relationship('level', 'name')
                    ->required()
                    ->searchable()
                    ->label('Уровень'),
                Select::make('course_id')
                    ->relationship('course', 'title')
                    ->required()
                    ->searchable()
                    ->label('Курс'),
                Select::make('lesson_id')
                    ->relationship('lesson', 'title')
                    ->required()
                    ->searchable()
                    ->label('Урок'),
                Select::make('status')
                    ->options([
                        'not_started' => 'Не начато',
                        'in_progress' => 'В процессе',
                        'completed' => 'Завершено'
                    ])
                    ->required()
                    ->label('Статус'),
                TextInput::make('score')
                    ->numeric()
                    ->required()
                    ->default(0)
                    ->minValue(0)
                    ->maxValue(100)
                    ->label('Баллы'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->sortable()
                    ->searchable()
                    ->label('Пользователь'),
                Tables\Columns\TextColumn::make('level.name')
                    ->sortable()
                    ->searchable()
                    ->label('Уровень'),
                Tables\Columns\TextColumn::make('course.title')
                    ->sortable()
                    ->searchable()
                    ->label('Курс'),
                Tables\Columns\TextColumn::make('lesson.title')
                    ->sortable()
                    ->searchable()
                    ->label('Урок'),
                Tables\Columns\TextColumn::make('status')
                    ->sortable()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'not_started' => 'Не начато',
                        'in_progress' => 'В процессе',
                        'completed' => 'Завершено',
                        default => $state,
                    })
                    ->label('Статус'),
                Tables\Columns\TextColumn::make('score')
                    ->sortable()
                    ->label('Баллы'),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'not_started' => 'Не начато',
                        'in_progress' => 'В процессе',
                        'completed' => 'Завершено'
                    ])
                    ->label('Статус'),
                SelectFilter::make('level')
                    ->relationship('level', 'name')
                    ->label('Уровень'),
                SelectFilter::make('course')
                    ->relationship('course', 'title')
                    ->label('Курс'),
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
            'index' => Pages\ListUserProgress::route('/'),
            'create' => Pages\CreateUserProgress::route('/create'),
            'edit' => Pages\EditUserProgress::route('/{record}/edit'),
        ];
    }
}
