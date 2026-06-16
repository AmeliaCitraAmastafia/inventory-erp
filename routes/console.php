<?php

use Illuminate\Support\Facades\Artisan;

Artisan::command('service:role', function () {
    $this->info(config('app.service_role'));
})->purpose('Display current service role');
