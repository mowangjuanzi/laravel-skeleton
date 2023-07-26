<?php

namespace App\Providers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Log::channel("sql")->debug(app(Request::class)->url());
        DB::listen(function ($event) {
            $query = $event->sql; // 获取SQL语句
            foreach ($event->bindings as $bind) {
                $query = preg_replace('/\?/', (is_numeric($bind) ? $bind : '\'' . $bind . '\''), $query, 1);
            }

            Log::channel("sql")->debug("query: {$query}; time: {$event->time}ms");
        });
    }
}
