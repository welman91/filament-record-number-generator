<?php

namespace Welman91\FilamentRecordNumberGenerator\Resources;

use Carbon\Carbon;
use Filament\Facades\Filament;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Welman91\FilamentRecordNumberGenerator\Concerns\HasNumbering;
use Welman91\FilamentRecordNumberGenerator\Enums\ResetFrequency;
use Welman91\FilamentRecordNumberGenerator\FilamentRecordNumberGeneratorPlugin;
use Welman91\FilamentRecordNumberGenerator\Models\NumberingSequence;
use Welman91\FilamentRecordNumberGenerator\Resources\NumberingSequenceResource\Pages\CreateNumberingSequence;
use Welman91\FilamentRecordNumberGenerator\Resources\NumberingSequenceResource\Pages\EditNumberingSequence;
use Welman91\FilamentRecordNumberGenerator\Resources\NumberingSequenceResource\Pages\ListNumberingSequences;

class NumberingSequenceResource extends Resource
{
    protected static ?string $model = NumberingSequence::class;

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedHashtag;

    public static function getModelLabel(): string
    {
        return __('filament-record-number-generator::record-number-generator.resource_label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('filament-record-number-generator::record-number-generator.resource_plural');
    }

    public static function getNavigationGroup(): ?string
    {
        return FilamentRecordNumberGeneratorPlugin::resolveNavigationGroup();
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make(__('filament-record-number-generator::record-number-generator.form.sequence_details'))->schema([
                TextInput::make('name')
                    ->label(__('filament-record-number-generator::record-number-generator.form.name'))
                    ->required()
                    ->maxLength(255),
                Select::make('model_type')
                    ->label(__('filament-record-number-generator::record-number-generator.form.model_type'))
                    ->options(fn () => static::getNumberableModels())
                    ->required()
                    ->searchable(),
                TextInput::make('attribute')
                    ->label(__('filament-record-number-generator::record-number-generator.form.attribute'))
                    ->required()
                    ->maxLength(255)
                    ->helperText(__('filament-record-number-generator::record-number-generator.form.attribute_helper')),
                TextInput::make('pattern')
                    ->label(__('filament-record-number-generator::record-number-generator.form.pattern'))
                    ->required()
                    ->maxLength(255)
                    ->default(config('filament-record-number-generator.default_pattern'))
                    ->helperText(__('filament-record-number-generator::record-number-generator.form.pattern_helper')),
            ])->columns(2),

            Section::make(__('filament-record-number-generator::record-number-generator.form.formatting'))->schema([
                TextInput::make('prefix')
                    ->label(__('filament-record-number-generator::record-number-generator.form.prefix'))
                    ->maxLength(50),
                TextInput::make('suffix')
                    ->label(__('filament-record-number-generator::record-number-generator.form.suffix'))
                    ->maxLength(50),
                TextInput::make('initial_value')
                    ->label(__('filament-record-number-generator::record-number-generator.form.initial_value'))
                    ->numeric()
                    ->default(1)
                    ->minValue(1),
            ])->columns(3),

            Section::make(__('filament-record-number-generator::record-number-generator.form.reset_settings'))->schema([
                Select::make('reset_frequency')
                    ->label(__('filament-record-number-generator::record-number-generator.form.reset_frequency'))
                    ->options(ResetFrequency::class)
                    ->default(config('filament-record-number-generator.default_reset_frequency'))
                    ->required()
                    ->live(),
                Select::make('fiscal_year_start_month')
                    ->label(__('filament-record-number-generator::record-number-generator.form.fiscal_year_start_month'))
                    ->options(fn () => collect(range(1, 12))->mapWithKeys(fn (int $m) => [
                        $m => Carbon::create()->month($m)->translatedFormat('F'),
                    ])->all())
                    ->default(config('filament-record-number-generator.default_fiscal_year_start_month'))
                    ->visible(fn (Get $get): bool => $get('reset_frequency') === ResetFrequency::Yearly->value),
                Toggle::make('is_gap_free')
                    ->label(__('filament-record-number-generator::record-number-generator.form.is_gap_free'))
                    ->default(config('filament-record-number-generator.default_gap_free'))
                    ->helperText(__('filament-record-number-generator::record-number-generator.form.is_gap_free_helper')),
                Toggle::make('is_active')
                    ->label(__('filament-record-number-generator::record-number-generator.form.is_active'))
                    ->default(true),
            ])->columns(2),

            Section::make(__('filament-record-number-generator::record-number-generator.form.custom_tokens'))->schema([
                KeyValue::make('custom_tokens')
                    ->label(__('filament-record-number-generator::record-number-generator.form.custom_tokens'))
                    ->keyLabel(__('filament-record-number-generator::record-number-generator.form.token_name'))
                    ->valueLabel(__('filament-record-number-generator::record-number-generator.form.token_resolver'))
                    ->helperText(__('filament-record-number-generator::record-number-generator.form.custom_tokens_helper')),
            ])->collapsible()->collapsed(),
        ]);
    }

    /**
     * Get models that use the HasNumbering trait from registered panel resources.
     *
     * @return array<string, string>
     */
    protected static function getNumberableModels(): array
    {
        $models = [];

        foreach (Filament::getCurrentOrDefaultPanel()->getResources() as $resource) {
            $modelClass = $resource::getModel();

            if (in_array(HasNumbering::class, class_uses_recursive($modelClass))) {
                $models[$modelClass] = $resource::getModelLabel();
            }
        }

        return $models;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label(__('filament-record-number-generator::record-number-generator.table.name'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('model_type')
                    ->label(__('filament-record-number-generator::record-number-generator.table.model_type'))
                    ->formatStateUsing(fn (string $state): string => class_basename($state))
                    ->sortable(),
                TextColumn::make('pattern')
                    ->label(__('filament-record-number-generator::record-number-generator.table.pattern'))
                    ->searchable(),
                TextColumn::make('reset_frequency')
                    ->label(__('filament-record-number-generator::record-number-generator.table.reset_frequency'))
                    ->badge(),
                IconColumn::make('is_gap_free')
                    ->label(__('filament-record-number-generator::record-number-generator.table.is_gap_free'))
                    ->boolean(),
                IconColumn::make('is_active')
                    ->label(__('filament-record-number-generator::record-number-generator.table.is_active'))
                    ->boolean(),
                TextColumn::make('created_at')
                    ->label(__('filament-record-number-generator::record-number-generator.table.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListNumberingSequences::route('/'),
            'create' => CreateNumberingSequence::route('/create'),
            'edit' => EditNumberingSequence::route('/{record}/edit'),
        ];
    }
}
