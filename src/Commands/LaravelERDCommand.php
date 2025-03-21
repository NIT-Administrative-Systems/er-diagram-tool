<?php

namespace Kevincobain2000\LaravelERD\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Kevincobain2000\LaravelERD\Diagram\RoutingType;
use Kevincobain2000\LaravelERD\LaravelERD;

class LaravelERDCommand extends Command
{
    public $signature = 'erd:generate';

    public $description = 'Generate ERD files';

    private string $appName;

    private string $modelsPath;

    private string $destinationPath;

    private RoutingType $routingType;

    public function __construct()
    {
        parent::__construct();

        $this->modelsPath = config('laravel-erd.models_path');
        $this->destinationPath = config('laravel-erd.docs_path');
        $this->appName = config('app.name') ?? 'Laravel';

        $routing = config('laravel-erd.display.routing');
        if (is_string($routing)) {
            $routing = RoutingType::from($routing);
        }

        $this->routingType = $routing;
    }

    public function handle(LaravelERD $modelReflector): int
    {
        if (! File::exists($this->destinationPath)) {
            File::makeDirectory($this->destinationPath, 0755, true);
        }

        /**
         * I think the package erd:: prefix is confusing it; it doesn't see this as a view-string.
         *
         * @var view-string $view
         */
        $view = 'erd::index';

        File::put($this->destinationPath.'/index.html',
            view($view)
                ->with([
                    'appName' => $this->appName,
                    'routingType' => $this->routingType->value,
                    'link_data' => $modelReflector->getLinkDataArray($this->modelsPath),
                    'node_data' => $modelReflector->getNodeDataArray($this->modelsPath),
                ])
                ->render()
        );

        $this->info("ERD data written successfully to {$this->destinationPath}");

        return self::SUCCESS;
    }
}
