<?php

namespace Welman91\FilamentRecordNumberGenerator\Enums;

use Filament\Support\Contracts\HasLabel;

enum ResetFrequency: string implements HasLabel
{
    case Never = 'never';
    case Yearly = 'yearly';
    case Monthly = 'monthly';
    case Daily = 'daily';

    public function getLabel(): string
    {
        return match ($this) {
            self::Never => __('filament-record-number-generator::record-number-generator.reset_frequency.never'),
            self::Yearly => __('filament-record-number-generator::record-number-generator.reset_frequency.yearly'),
            self::Monthly => __('filament-record-number-generator::record-number-generator.reset_frequency.monthly'),
            self::Daily => __('filament-record-number-generator::record-number-generator.reset_frequency.daily'),
        };
    }
}
