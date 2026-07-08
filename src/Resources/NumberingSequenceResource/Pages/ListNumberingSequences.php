<?php

namespace Welman91\FilamentRecordNumberGenerator\Resources\NumberingSequenceResource\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Welman91\FilamentRecordNumberGenerator\Resources\NumberingSequenceResource;

class ListNumberingSequences extends ListRecords
{
    protected static string $resource = NumberingSequenceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
