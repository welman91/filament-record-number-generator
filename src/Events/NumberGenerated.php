<?php

namespace Welman91\FilamentRecordNumberGenerator\Events;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Events\Dispatchable;
use Welman91\FilamentRecordNumberGenerator\Models\NumberingSequence;

class NumberGenerated
{
    use Dispatchable;

    public function __construct(
        public Model $model,
        public string $attribute,
        public string $generatedNumber,
        public NumberingSequence $sequence,
    ) {}
}
