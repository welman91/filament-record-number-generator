<?php

namespace Welman91\FilamentRecordNumberGenerator;

use Filament\Contracts\Plugin;
use Filament\Panel;
use Welman91\FilamentRecordNumberGenerator\Resources\NumberingSequenceResource;

class FilamentRecordNumberGeneratorPlugin implements Plugin
{
    protected bool $hasSequenceResource = true;

    protected ?string $navigationGroup = null;

    public static function make(): static
    {
        return app(static::class);
    }

    public function getId(): string
    {
        return 'filament-record-number-generator';
    }

    public function sequenceResource(bool $enabled = true): static
    {
        $this->hasSequenceResource = $enabled;

        return $this;
    }

    public function navigationGroup(string $group): static
    {
        $this->navigationGroup = $group;

        return $this;
    }

    public function getNavigationGroup(): ?string
    {
        return $this->navigationGroup ?? config('filament-record-number-generator.navigation_group', 'Settings');
    }

    public function register(Panel $panel): void
    {
        if ($this->hasSequenceResource) {
            $panel->resources([
                NumberingSequenceResource::class,
            ]);
        }
    }

    public function boot(Panel $panel): void {}

    /**
     * Get the current plugin instance from the active Filament panel.
     */
    public static function current(): ?static
    {
        try {
            return filament()->getCurrentOrDefaultPanel()->getPlugin('filament-record-number-generator');
        } catch (\Throwable) {
            return null;
        }
    }

    /**
     * Resolve the navigation group, preferring plugin override then config.
     */
    public static function resolveNavigationGroup(): ?string
    {
        return static::current()?->getNavigationGroup()
            ?? config('filament-record-number-generator.navigation_group', 'Settings');
    }
}
