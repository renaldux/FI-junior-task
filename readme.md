# Simple accounts and money transfer application

Based on Laravel 5.8

## Requirements

- Laravel 5.8
- PHP >= 7.1


## Installation

```
git clone https://github.com/PetrasSip/FI-junior-task
cd FI-junior-task
composer install
copy .env.example .env
php artisan key:generate
php artisan migrate


## Author

- Petras

## App description:
- Users must register or login (if registered) using email.
- After successful registration user account is created and 
  bonus of 1000 Eur is transfered to the account.
- Users can make transfers between accounts using unique account numbers.
- Account balance does not drop below 0.
- After login user can see his account balance and all transfers
  to ant from his account.

