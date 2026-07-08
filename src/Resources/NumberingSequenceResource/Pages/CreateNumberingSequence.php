<?php

namespace Welman91\FilamentRecordNumberGenerator\Resources\NumberingSequenceResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use Welman91\FilamentRecordNumberGenerator\Resources\NumberingSequenceResource;

class CreateNumberingSequence extends CreateRecord
{
	protected static string $resource = NumberingSequenceResource::class;

	protected function mutateFormDataBeforeCreate(array $data): array
	{
		return $data;
	}
}
