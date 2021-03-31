<?php

declare(strict_types=1);

return [

    // Manage autoload migrations
    'autoload_migrations' => true,

    // Addresses Database Tables
    'tables' => [
        'addresses' => 'addresses',
    ],

    // Addresses Models
    'models' => [
        'address' => \NunoMazer\Addressable\Models\Address::class,
    ],

    // Addresses Geocoding Options
    'geocoding' => false,

];
