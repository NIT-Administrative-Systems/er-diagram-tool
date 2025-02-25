# Entity Relationship Diagram Tool for Laravel [![Coverage Status](https://coveralls.io/repos/github/NIT-Administrative-Systems/er-diagram-tool/badge.svg)](https://coveralls.io/github/NIT-Administrative-Systems/er-diagram-tool)
Automatically generate interactive entity relationship diagram for models & their relationships in Laravel and emit a static HTML file for use in a VuePress site.

This package is a heavily-customized fork from [kevincobain2000/laravel-erd](https://github.com/kevincobain2000/laravel-erd) meant for use in some very specific circumstances. If you're not part of @NIT-Administrative-Systems, you should probably check out the original package instead!

The changes include:

- Adding ribbons to models in the diagram with PHP attributes on the model class
- Different default settings for goJS to render huge diagrams efficiently 
- Different default settings for discovering models in `App\Domains\<something>\Models` namespaces

## Installation
You can install the package via composer.

```bash
composer require northwestern-sysdev/er-diagram-tool --dev
```

## Usage
You can generate a static HTML file with the artisan command:

```php
php artisan erd:generate
```

This will be placed in `docs/.vuepress/public/erd`, or whatever path you have configured in `config/laravel-erd.php`.

## Using Ribbons
Enabling ribbon support is done by registering a function to get ribbons.

First, create an attribute with some properties you want to include in the ribbon:

```php
#[Attribute(Attribute::TARGET_CLASS)]
class LookupAttr
{
    public function __construct(
        public readonly string $source,
    ) {
        //
    }
}
```

Next, register a callback in a provider's

```php
class AppServiceProvider extends ServiceProvider {
    public function boot(): void
    {
        /** @var ModelRibbonAdapter $adapter */
        $adapter = resolve(ModelRibbonAdapter::class);
        
        \Kevincobain2000\LaravelERD\LaravelERDServiceProvider::setRibbonClosure($adapter->callback());  
    }
    
    private function ribbonCallback(): Closure
    {
        return function (Model $model) {
            $reflection = new ReflectionClass($model);
            $attributes = collect($reflection->getAttributes())
                ->map->newInstance()
                ->filter(fn (object $attrObj) => $attrObj instanceof LookupAttr);

            return $attributes
                ->map(function (LookupAttr $attr) {
                    return new \Kevincobain2000\LaravelERD\Diagram\Ribbon(
                        text: $attribute->source,
                        bgColour: '#FFE342',
                        textColour: 'black',
                    );
                })
                ->first();
        };
    }
}
```

And then use the attribute on some models:

```php
#[LookupAttr('Student System')]
class DegreeType extends Model
{
    // . . .
}
```

This will pick them up and add a ribbon with the "Student System" text on it, indicating the table is populated from the student system's degree types.
