<?php

namespace App\Providers;

use Illuminate\Foundation\Precognition;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // 重写 Request 中的 validate 方法
        Request::macro('validate', function (array $rules, ...$params) {
            return tap(validator($this->all(), $rules, ...$params), function ($validator) {
                if ($this->isPrecognitive()) {
                    $validator->after(Precognition::afterValidationHook($this))
                        ->setRules(
                            $this->filterPrecognitiveRules($validator->getRulesWithoutPlaceholders())
                        );
                }
            })->stopOnFirstFailure()->validate();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
