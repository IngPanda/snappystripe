# WalletStripe

Description
--------------------

php component to connect applications with stripe


Installation / Usage
--------------------


Via Composer

``` bash
$ composer require suseche/walletstripe
```
After installing via composer, run the migration command


``` bash
$ php artisan migrate 
```


Methods
---------

- createConstumer

	-code 
	---------

	``` php
			$wallet = new WalletStripe;
	    	$customer = $wallet->createConstumer($user->id);
	```

	- params
	---------

	- account_id: Local identifier of the account to which you want to link the customer stripe

	- return 
	---------
	- all customer data stored in stripe

- getCostumerId

	-code 
	---------

	``` php
			$wallet = new WalletStripe;
	    	$customer = $wallet->getCostumerId($user->id);
	```

	- params
	---------

	- account_id: Local identifier of the account.

	- return 
	---------
	- the customer identifier in stripe


- getDataCustomer
- createCreditCard
- getCreditCards
- deleteCreditCard
- updateCreditCard
- generateTokenCreditCard
- loadCharge

Usage
---------


``` php

namespace App\Http\Controllers;


use suseche\walletstripe\WalletStripe;

class UserController extends Controller
{
    public function createCustomer(Request $request)
    {
    	$wallet = new WalletStripe;
    	$customer = $wallet->createConstumer($user->id);
    }
}

```
Requirements
------------

- PHP 7.1.3
- Laravel 5.6


