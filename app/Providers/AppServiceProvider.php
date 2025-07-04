<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

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
        // Detecta si la aplicación está siendo accedida a través de HTTPS
        // Esto es crucial para Ngrok que usa HTTPS por defecto.
        // Si Ngrok envía el encabezado X-Forwarded-Proto como 'https',
        // o si la APP_URL ya es HTTPS, forceScheme('https') lo asegura.
        if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
            URL::forceScheme('https');
        }
        // Otra forma, más simple para Ngrok, es forzar HTTPS si no es ambiente 'local'
        // if (env('APP_ENV') !== 'local' && env('APP_ENV') !== 'testing') {
        //     URL::forceScheme('https');
        // }


        // Esto es para asegurar que las URLs generadas usen el dominio de Ngrok,
        // no localhost, combinando con el forceScheme anterior.
        if (isset($_SERVER['HTTP_X_FORWARDED_HOST'])) {
            $ngrokHost = $_SERVER['HTTP_X_FORWARDED_HOST'];
            $ngrokUrl = 'https://' . $ngrokHost; // Construye la URL completa con HTTPS

            // Forzar la URL raíz para que asset() y url() usen el dominio de Ngrok
            URL::forceRootUrl($ngrokUrl);

            // También actualiza la configuración de APP_URL en tiempo de ejecución
            config(['app.url' => $ngrokUrl]);
        }
    }
}
