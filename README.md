![Feature Flag](logo.png)


<p align="center">
    <a href="https://github.com/mohamedahmed01/feature-flag/actions"><img src="https://github.com/mohamedahmed01/feature-flag/actions/workflows/main.yml/badge.svg" alt="Build Status"></a>
    <a href="https://packagist.org/packages/mohamedahmed01/feature-flag"><img src="https://img.shields.io/packagist/dt/mohamedahmed01/feature-flag" alt="Total Downloads"></a>
    <a href="https://packagist.org/packages/mohamedahmed01/feature-flag"><img src="https://img.shields.io/packagist/v/mohamedahmed01/feature-flag" alt="Latest Stable Version"></a>
    <a href="https://packagist.org/packages/mohamedahmed01/feature-flag"><img src="https://img.shields.io/packagist/l/mohamedahmed01/feature-flag" alt="License"></a>
</p>

## Introduction

**Feature Flag** is the easiest way to enable and disable features on your different **Laravel** enviroments it also enable you to do A/B testing and supporting your **users** with **different** features sets.

## Installtion 

- Adding the package using composer 

``` php
    composer require mohamedahmed01/feature-flag
```
- publishing configuration 
``` php
    php artisan vendor:publish --provider="Mohamedahmed01\FeatureFlag\FeatureFlagServiceProvider" --tag="config"
```
- Facade is automatically loaded using composer unless you have laravel version < 5.4
 you will need to add the facade manually in config/app.php
 ``` php
    'FeatureFlag'=> Mohamedahmed01\FeatureFlag\FeatureFlagFacade::class
```
## Usage
``` php
    //Feature Flagging can be simple done by creating the flag
    $featureFlag = new FeatureFlag([
            'name' => 'test',
            'description' => 'Test feature flag',
        ]);
    $featureFlag->save();
    
    //using the flag to scope your your code using if condition or any other way you like
    if ($featureFlag->isEnabled()) {
        // Implement the feature for the user
    }

    //or you can use the method Targted and checking the audience to match to specific audience
    if($featureFlag->isTargeted() && in_array($user->id, $featureFlag->getAudience())) {
        // Implement the feature for the user
    }

    //Feature Flagging can be also used to target users based on percentage
    $featureFlag = new FeatureFlag([
            'name' => 'test',
            'description' => 'Test feature flag',
            'percentage'=>50
        ]);
    $featureFlag->save();
    // you can use the method isEnabledForUser and checking the audience to match to specific audience i.e 50%
    if($featureFlag->isEnabledForUser($user)) {
        // Implement the feature for the user
    }
    //then simply call feature-flag:manage followed by the name of your flag to enable Or disable it 
    php artisan feature-flag:manage {flag : The name of the feature flag} 
    {--enable : Enable the feature flag} {--disable : Disable the feature flag}
```
### Configuration :

| Config Name | Description |
| --- | --- |
| FEATURE_FLAG_DRIVER | Allow you to change the backend driver currently support eleqount|


### Methods :

| Method | Description |
| --- | --- |
| getName() | getthe name of the flag |
| getDescription() | get the description of the flag |
| setEnabled(bool) | enable the flag or disable it depending on the value |
| isEnabled() | check if the flag is enabled or not |
| Targted() | check if the flag has specific audience |
| setAudience(array) | set the flag audience by sending array of user's id's i.e [1,2,3,4] |
| getAudience() | get the audience id's of the users for this flag |
| isEnabledForUser($user) | check random user for falling within the percentage |
## Contributing

Thank you for considering contributing to Pint! You can read the contribution guide [here](.github/CONTRIBUTING.md).

### Testing

``` bash
composer test
```

### Security

If you discover any security related issues, please email mohamedabdelmenem01@gmail.com instead of using the issue tracker.

<a name="license"></a>
## License

Feature-Flag is open-sourced software licensed under the [MIT license](LICENSE.md).