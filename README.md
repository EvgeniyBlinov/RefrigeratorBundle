[![MIT License][license-image]][license-url]

RefrigeratorBundle [RU](README_RU.md)
==================

RefrigeratorBundle - is a cache for SF2


##Install

Add to composer.json

```json
   "require":{
        "cent/refrigerator-bundle": "dev-master"
    },
    
    "minimum-stability": "dev",
    "repositories": [
        {
            "type"   :"package",
            "package": {
              "name"      : "cent/refrigerator-bundle",
              "version"   :"dev-master",
              "source": {
                  "url": "https://github.com/EvgeniyBlinov/RefrigeratorBundle",
                  "type": "git",
                  "reference":"master"
                },
                "autoload": {
                    "psr-0": { "Cent\\RefrigeratorBundle": "" }
                },
                "target-dir": "Cent/RefrigeratorBundle"
            }
        }
    ]
```

And run `composer install`

### License ###

[![MIT License][license-image]][license-url]

### Author ###

- [Blinov Evgeniy](mailto:evgeniy_blinov@mail.ru) ([http://blinov.in.ua/](http://blinov.in.ua/))

[license-image]: http://img.shields.io/badge/license-MIT-blue.svg?style=flat
[license-url]: LICENSE
