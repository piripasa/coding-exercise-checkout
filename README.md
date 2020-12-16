## Coding Exercise: Checkout

### Language & tools

- PHP >= 7.0
- Composer (for installing dependencies)

> Class diagram: /assets/

> Unit test cases: /tests/


### Installation
This is a dockerized application. Do the following

Make sure: 
* `docker` & `docker-compose` installed in your PC.

To do:

- `cd project_directory/` into the project root directory.
- `sh start.sh` (Will do installation)
- `docker-compose run --rm composer install` for installing dependencies
- `docker-compose run --rm php vendor/bin/phpunit` for PHPUnit test
- `docker-compose run --rm php index.php` for run app

### Create new Rule
- Extend `AbstractPriceRules` for creating new sku price rule
    ``` 
    class BundlePriceRule extends AbstractPriceRules
    {
        public abstract function calculateTotal(CartInterface $cart)
        {
        }
    }
    ```
- Extend `AbstractCheckoutRules` for creating new checkout rule
   ``` 
     class CheckoutPriceRule extends AbstractCheckoutRules
     {
         public abstract function calculateTotal(CheckoutInterface $cart)
         {
         }
     }
     ```
  
### Checkout steps
> Step 1: Add rules to repository
``` 
$rulesRepository = new RulesRepository();
$rulesRepository->add(new BundlePriceRule([
'A' => [
    'count' => 3,
    'price' => 130,
]
]));
```
 > Step 2: Pass rules repository to Checkout
```
$co = new Checkout($rulesRepository);
```
> Step 3: Scan item
``` 
$co->scan(new Item('A', 50));
```
> Step 4: Get total
``` 
$co->total();
```


 ### CheckList
 
 - [x] Apply price rules to checkout process
 - [x] Apply checkout rules to cart total after apply price rule
 - [x] Scan item
 - [x] Get total

### Todo
 - [ ] Handle multiple same SKU rules
