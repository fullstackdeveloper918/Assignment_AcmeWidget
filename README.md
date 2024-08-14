# Acme Widget Basket

## Description

This project implements a simple basket system for Acme Widget Co. It calculates the total cost of items in a shopping basket, taking into account special offers and delivery charges.

## Assumptions

- The product catalogue, delivery rules, and offers are passed to the `Basket` class during initialization.
- The special offer "buy one red widget, get the second half price" is the only offer implemented.
- Delivery charges are applied based on the total before applying any discounts.

## Usage

Please run  
``composer update `` from the root directory 

To run the tests:

```bash
vendor/bin/phpunit --bootstrap vendor/autoload.php tests/BasketTest.php
```
