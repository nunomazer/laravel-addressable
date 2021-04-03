# Laravel Addressable

It is a polymorphic Laravel package, for addressbook management. 
You can add addresses to any eloquent model with ease.

_This is based on **Rinvex Addresses** package_

## Installation

1. Install the package via composer:
    ```shell
    composer require nunomazer/laravel-addressable
    ```

2. Publish resources (migrations and config files):
    ```shell
    php artisan vendor:publish
    ```
    
3. Edit config file `config/addressable.php` if you need to change database table name:
   ```php
    // Addresses Database Tables
    'tables' => [
        'addresses' => 'addresses',
    ],
   ```

4. Execute migrations via the following command:
    ```shell
    php artisan migrate
    ```

5. Done!


## Usage

To add addresses support to your eloquent models simply use `\NunoMazer\Addressable\Traits\Addressable` trait.

### Manage your addresses

```php
// Get instance of your model
$user = new \App\Models\User::find(1);

// Create a new address
$user->addresses()->create([
    'label' => 'Default Address',
    'organization' => 'DN42',
    'country_code' => 'br',
    'street' => 'Carlos Cavalcanti',
    'state' => 'Paraná',
    'city' => 'Ponta Grossa',
    'postal_code' => '84000-100',
    'latitude' => '31.2467601',
    'longitude' => '29.9020376',
    'is_primary' => true,
    'is_billing' => true,
    'is_shipping' => true,
]);

// Create multiple new addresses
$user->addresses()->createMany([
    [...],
    [...],
    [...],
]);

// Find an existing address
$address = app('addressable.address')->find(1);

// Update an existing address
$address->update([
    'label' => 'Default Work Address',
]);

// Delete address
$address->delete();

// Alternative way of address deletion
$user->addresses()->where('id', 123)->first()->delete();
```

### Manage your addressable model

The API is intuitive and very straight forward, so let's give it a quick look:

```php
// Get instance of your model
$user = new \App\Models\User::find(1);

// Get attached addresses collection
$user->addresses;

// Get attached addresses query builder
$user->addresses();

// Scope Primary Addresses
$primaryAddresses = app('addressable.address')->isPrimary()->get();

// Scope Billing Addresses
$billingAddresses = app('addressable.address')->isBilling()->get();

// Scope Shipping Addresses
$shippingAddresses = app('addressable.address')->isShipping()->get();

// Scope Addresses in the given country
$egyptianAddresses = app('addressable.address')->InCountry('eg')->get();

// Find all users within 5 kilometers radius from the latitude/longitude 31.2467601/29.9020376
$fiveKmAddresses = \App\Models\User::findByDistance(5, 'kilometers', '31.2467601', '29.9020376')->get();

// Alternative method to find users within certain radius
$user = new \App\Models\User();
$users = $user->lat('31.2467601')->lng('29.9020376')->within(5, 'kilometers')->get();
```


## Changelog

Refer to the [Changelog](CHANGELOG.md) for a full history of the project.


## Support

The following support channels are available at your fingertips:

- [Follow on Twitter](https://twitter.com/nunomazer)


## Contributing & Protocols

Thank you for considering contributing to this project! The contribution guide can be found in [CONTRIBUTING.md](CONTRIBUTING.md).

Bug reports, feature requests, and pull requests are very welcome.

- [Versioning](CONTRIBUTING.md#versioning)
- [Pull Requests](CONTRIBUTING.md#pull-requests)
- [Coding Standards](CONTRIBUTING.md#coding-standards)
- [Feature Requests](CONTRIBUTING.md#feature-requests)
- [Git Flow](CONTRIBUTING.md#git-flow)


## Security Vulnerabilities

If you discover a security vulnerability within this project, please open an issue.


## License

This software is released under [The MIT License (MIT)](LICENSE).
