
<?php
namespace DataLive\snappyStripe;
 
use Cartalyst\Stripe\Stripe;
 
class Communicate
{
   protected $config;
   protected $stripe;
 
   public function __construct(){
       $r = new Config();
       $this->config = $r->config;
       $this->stripe = new Stripe($r->config['stripeKey'], '2015-01-11'); 
   }
 
   public function hasInstance($bool = true) 
   { 
       return $bool; 
   }
 
   public function createConstumer($from, $to, $message){
      
   }
}
