<?php

namespace Welman91\FilamentRecordNumberGenerator\Resources\NumberingSequenceResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use Welman91\FilamentRecordNumberGenerator\Resources\NumberingSequenceResource;

class CreateNumberingSequence extends CreateRecord
{
    protected static string $resource = NumberingSequenceResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (config('filament-record-number-generator.multi_tenancy.enabled', false)) {
            $column = config('filament-record-number-generator.multi_tenancy.column', 'company_id');
            $data[$column] = auth()->user()?->{$column};
        }

        return $data;
    }
}
