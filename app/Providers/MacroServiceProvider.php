<?php

namespace App\Providers;

use App\Macros\AssertableInertiaMixin;
use App\Macros\RedirectResponseMixin;
use App\Macros\RequestMixin;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Traits\Macroable;
use Inertia\Testing\AssertableInertia;
use ReflectionException;

class MacroServiceProvider extends ServiceProvider
{
    /**
     * @var array<class-string, class-string>
     */
    protected array $mixins = [
        AssertableInertia::class => AssertableInertiaMixin::class,
        RedirectResponse::class => RedirectResponseMixin::class,
        Request::class => RequestMixin::class,
    ];

    /**
     * @var array<class-string, class-string>
     */
    protected array $testMixins = [
        AssertableInertia::class => AssertableInertiaMixin::class,
    ];

    /**
     * Register services.
     *
     * @return void
     *
     * @throws ReflectionException
     */
    public function register(): void
    {
        foreach ($this->mixins as $class => $mixin) {
            /* @var Macroable $class */
            $class::mixin(new $mixin);
        }

        if ($this->app->environment('testing')) {
            foreach ($this->testMixins as $class => $mixin) {
                /* @var Macroable $class */
                $class::mixin(new $mixin);
            }
        }
    }
}
