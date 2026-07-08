<?php

namespace Welman91\FilamentRecordNumberGenerator\Resources\NumberingSequenceResource\Pages;

use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Welman91\FilamentRecordNumberGenerator\Resources\NumberingSequenceResource;

class EditNumberingSequence extends EditRecord
{
    protected static string $resource = NumberingSequenceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
