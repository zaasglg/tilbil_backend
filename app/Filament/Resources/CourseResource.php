<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CourseResource\Pages;
use App\Filament\Resources\CourseResource\RelationManagers;
use App\Models\Course;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CourseResource extends Resource
{
    protected static ?string $model = Course::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

    protected static ?string $navigationGroup = 'Обучение';

    protected static ?string $modelLabel = 'Курс';

    protected static ?string $pluralModelLabel = 'Курсы';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('level_id')
                    ->relationship('level', 'name')
                    ->required()
                    ->label('Уровень'),
                TextInput::make('title')
                    ->required()
                    ->maxLength(255)
                    ->label('Название'),
                RichEditor::make('description')
                    ->maxLength(65535)
                    ->label('Описание'),
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
                Tables\Columns\TextColumn::make('level.name')
                    ->sortable()
                    ->searchable()
                    ->label('Уровень'),
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->label('Название'),
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
            'index' => Pages\ListCourses::route('/'),
            'create' => Pages\CreateCourse::route('/create'),
            'edit' => Pages\EditCourse::route('/{record}/edit'),
        ];
    }
}
