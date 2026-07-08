<?php

namespace Welman91\FilamentRecordNumberGenerator;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Welman91\FilamentRecordNumberGenerator\Services\NumberingEngine;
use Welman91\FilamentRecordNumberGenerator\Services\PatternParser;

class FilamentRecordNumberGeneratorServiceProvider extends PackageServiceProvider
{
    public static string $name = 'filament-record-number-generator';

    public function configurePackage(Package $package): void
    {
        $package->name(static::$name)
            ->hasConfigFile()
            ->hasMigrations([
                'create_numbering_sequences_table',
                'create_numbering_counters_table',
            ])
            ->hasTranslations();
    }

    public function packageRegistered(): void
    {
        $this->app->singleton(PatternParser::class, function () {
            $parser = new PatternParser;

            foreach (config('filament-record-number-generator.custom_resolvers', []) as $resolverClass) {
                $parser->registerResolver(app($resolverClass));
            }

            return $parser;
        });

        $this->app->singleton(NumberingEngine::class);
    }
}
