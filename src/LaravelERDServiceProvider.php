<?php

namespace Kevincobain2000\LaravelERD;

use Closure;
use Illuminate\Database\Eloquent\Model;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Kevincobain2000\LaravelERD\Commands\LaravelERDCommand;

class LaravelERDServiceProvider extends PackageServiceProvider
{
    static private ?Closure $ribbonExtractor = null;

    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-erd')
            ->hasConfigFile('laravel-erd')
            ->hasViews()
            ->hasCommand(LaravelERDCommand::class);
    }

    /**
     * @param Closure(Model):?Ribbon $extractorClosure
     */
    static public function setRibbonClosure(Closure $extractorClosure): void
    {
        self::$ribbonExtractor = $extractorClosure;
    }

    /**
     * @return Closure(Model):?Ribbon $extractorClosure
     */
    static public function getRibbonClosure(): Closure
    {
        if (! self::$ribbonExtractor) {
            return fn (Model $model) => null;
        }

        return self::$ribbonExtractor;
    }
}
