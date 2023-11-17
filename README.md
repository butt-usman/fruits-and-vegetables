# 🍎🥕 Fruits and Vegetables

## 🎯 Goal
We want to build a service which will take a `request.json` and:
* Process the file and create two separate collections for `Fruits` and `Vegetables`
* Each collection has methods like `add()`, `remove()`, `list()`;
* Units have to be stored as grams;
* As a bonus you might consider giving option to decide which units are returned (kilograms/grams);
* As a bonus you might consider how to implement `search()` method collections;
  
## Usage

```bash
composer install
php bin/phpunit

or

symfony server:start
http://localhost:8000
```

### Note
The route I took for it to run was by running tests, as those were the ones I made first but still in the end I also added the entry for a controller too but it was kind of a last minute change
