# Stingray [![Code Climate](https://codeclimate.com/github/rwillians/stingray/badges/gpa.svg)](https://codeclimate.com/github/rwillians/stingray) [![Test Coverage](https://codeclimate.com/github/rwillians/stingray/badges/coverage.svg)](https://codeclimate.com/github/rwillians/stingray/coverage) 

Dot notation reader/writer for multidimensional arrays in PHP.


## Installing via Composer

Add Stingray to your project:

```bash
$>  composer.phar require rwillians/stingray ^2.0
```

or directly to composer.json:

```json
{
    "require": {
        "rwillians/stingray": "^2.0"
    }
}
```

Then update your dependencies:

```bash
$>  composer.phar update
```


## Example Usage

To get any node from an array:

```php
use Rwillians\Stingray\Stingray;

$someArray = array(
    'client' => array(
        'name' = 'John Doe'
    )
);

// Getting a value using dot notation:
echo Stingray::get($someArray, 'client.name'); // Outputs: 'John Doe'

// Changing a value using dot notation:
Stingray::set($someArray, 'client.name', 'Jane Doe');

// Create a new key-value to an existent array using dot notation:
Stingray::set($someArray, 'client.address', 'Some Street, 123');
```