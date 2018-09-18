<?php
namespace suseche\walletstripe;
 
class Config
{
   public $config;
 
   public function __construct(){
$this->config = [ "stripeKey" => getenv("STRIPE_KEY"),
                   "stripeId"  => getenv("STRIPE_ID"),
                ];
       }
}
