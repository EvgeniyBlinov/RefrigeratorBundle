!!!under construction.
---

RefrigeratorBundle
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
