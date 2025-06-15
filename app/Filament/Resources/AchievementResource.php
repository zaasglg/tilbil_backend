<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AchievementResource\Pages;
use App\Models\Achievement;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\ImageColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AchievementResource extends Resource
{
    protected static ?string $model = Achievement::class;

    protected static ?string $navigationIcon = 'heroicon-o-trophy';

    protected static ?string $navigationGroup = 'Обучение';

    protected static ?string $modelLabel = 'Достижение';

    protected static ?string $pluralModelLabel = 'Достижения';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('code')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255)
                    ->label('Код')
                    ->placeholder('first_lesson_completed'),
                TextInput::make('title')
                    ->required()
                    ->maxLength(255)
                    ->label('Название')
                    ->placeholder('Первый урок завершен'),
                Textarea::make('description')
                    ->required()
                    ->maxLength(65535)
                    ->label('Описание')
                    ->placeholder('Завершите свой первый урок'),
                FileUpload::make('icon_url')
                    ->image()
                    ->directory('achievements/icons')
                    ->maxSize(1024)
                    ->label('Иконка'),
                Select::make('type')
                    ->options([
                        'single' => 'Однократное достижение',
                        'streak' => 'Серия достижений',
                        'level' => 'Уровневое достижение',
                        'quiz_master' => 'Мастер тестов',
                        'dictionary_hero' => 'Герой словаря'
                    ])
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(fn ($state, callable $set) => $set('criteria', []))
                    ->label('Тип достижения'),
                Forms\Components\KeyValue::make('criteria')
                    ->label('Критерии достижения')
                    ->keyLabel('Параметр')
                    ->valueLabel('Значение')
                    ->rules('array')
                    ->hint(fn ($state, $component, $get) => match($get('type')) {
                        'single' => 'Например: event_type = first_lesson_complete',
                        'streak' => 'Например: days = 7',
                        'level' => 'Например: level_code = A1',
                        'quiz_master' => 'Например: min_score = 90',
                        'dictionary_hero' => 'Например: words_count = 100',
                        default => ''
                    }),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('code')
                    ->searchable()
                    ->sortable()
                    ->label('Код'),
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->label('Название'),
                ImageColumn::make('icon_url')
                    ->circular()
                    ->label('Иконка'),
                Tables\Columns\TextColumn::make('type')
                    ->sortable()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'single' => 'Однократное достижение',
                        'streak' => 'Серия достижений',
                        'level' => 'Уровневое достижение',
                        'quiz_master' => 'Мастер тестов',
                        'dictionary_hero' => 'Герой словаря',
                        default => $state,
                    })
                    ->label('Тип'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('Создано'),
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
            'index' => Pages\ListAchievements::route('/'),
            'create' => Pages\CreateAchievement::route('/create'),
            'edit' => Pages\EditAchievement::route('/{record}/edit'),
        ];
    }
}
