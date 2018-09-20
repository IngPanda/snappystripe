<?php

namespace suseche\walletstripe;

use Cartalyst\Stripe\Stripe;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
 
class WalletStripe
{
   protected $config;
   protected $stripe;
   protected $error_M1;
   protected $error_M2;
   protected $error_M3;
   protected $error_M4;
   protected $error_M5;
 
   public function __construct(){
       $r = new Config();
       $this->config = $r->config;
       $this->stripe = new Stripe($r->config['stripeKey'], '2015-01-11'); 
       $this->error_M1 = "Not found payment method.";
       $this->error_M2 = "Not controlled exception (stripe error)";
       $this->error_M3 = "Your card number is incorrect.";
       $this->error_m4 = "Account not found";
       $this->error_M5 = "Run migrations first";
   }
 
   public function hasInstance($bool = true) 
   { 
       return $bool; 
   }

   public function getStripeInstance(){
    return $this->stripe;
   }

   /** Customers */

   public function getCostumerId($account_id){
      if (!Schema::hasTable('stripe_config_data')){
          return $this->error_M5;
      }
      $user = DB::table('stripe_config_data')->where('account_id',$account_id)->first();

      if(empty($user)){
        return $this->error_m4;
      }

      return $user->customer_id;
   }
 
   public function createConstumer($account_id){

      try{

        if (!Schema::hasTable('stripe_config_data')){
            return $this->error_M5;
        }
        
        $user = DB::table('stripe_config_data')->where('account_id',$account_id)->first();

        if(empty($user)){
          $customer = $this->stripe->customers()->create([
              'description' => getenv('APP_NAME').'_'.getenv('APP_ENV').'_'.$account_id,
              'metadata' => ['account_id' => $account_id]
          ]);

          DB::table('stripe_config_data')->insert(["customer_id"=>$customer['id'],"account_id" =>$account_id ]);
        }
        else{
          $customer = $this->getDataCustomer($account_id);
        }       

        return $customer;

      } catch (\Cartalyst\Stripe\Exception\NotFoundException $e) {
     return $this->error_M1;      
      }
      catch (\Cartalyst\Stripe\Exception\BadRequestException $e) {
        return $this->error_M2;        
      }
      catch (\Cartalyst\Stripe\Exception\InvalidRequestException $e) {
        return $this->error_M2;        
      }
      catch (\Cartalyst\Stripe\Exception\CardErrorException $e) {
        return $this->error_M3;        
      }
      catch (\Cartalyst\Stripe\Exception\NotFoundException $e) {
       return $this->error_M1;        
      } 
   }

   public function getDataCustomer($account_id){

 
      try{

        $customer_id = $this->getCostumerId($account_id);

        $customer = $this->stripe->customers()->find($customer_id);
        return $customer;

      } catch (\Cartalyst\Stripe\Exception\NotFoundException $e) {
     return $this->error_M1;      
      }
      catch (\Cartalyst\Stripe\Exception\BadRequestException $e) {
        return $this->error_M2;        
      }
      catch (\Cartalyst\Stripe\Exception\InvalidRequestException $e) {
        return $this->error_M2;        
      }
      catch (\Cartalyst\Stripe\Exception\CardErrorException $e) {
        return $this->error_M3;        
      }
      catch (\Cartalyst\Stripe\Exception\NotFoundException $e) {
       return $this->error_M1;        
      } 
   }

   /** Credit cards **/

   public function createCreditCard($account_id,$token){

        try{

          $customer_id = $this->getCostumerId($account_id);

          $card = $this->stripe->cards()->create($customer_id, $token);
          return $card;

        } catch (\Cartalyst\Stripe\Exception\NotFoundException $e) {
         return $this->error_M1;          
        }
        catch (\Cartalyst\Stripe\Exception\BadRequestException $e) {
          return $this->error_M2;          
        }
        catch (\Cartalyst\Stripe\Exception\InvalidRequestException $e) {
          return $this->error_M2;          
        }
        catch (\Cartalyst\Stripe\Exception\CardErrorException $e) {
          return $this->error_M3;          
        }
        catch (\Cartalyst\Stripe\Exception\NotFoundException $e) {
         return $this->error_M1;          
        }      
   }

   public function getCreditCards($account_id,$card_id = false){

      try{

          $customer_id = $this->getCostumerId($account_id);

          if(!$card_id){
            $cards = $stripe->cards()->all($customer_id);
          }
          else{
            $cards = $stripe->cards()->find($customer_id,$card_id);
          }
          return $cards;
          
       } catch (\Cartalyst\Stripe\Exception\NotFoundException $e) {
         return $this->error_M1;          
        }
        catch (\Cartalyst\Stripe\Exception\BadRequestException $e) {
          return $this->error_M2;          
        }
        catch (\Cartalyst\Stripe\Exception\InvalidRequestException $e) {
          return $this->error_M2;          
        }
        catch (\Cartalyst\Stripe\Exception\CardErrorException $e) {
          return $this->error_M3;          
        }
        catch (\Cartalyst\Stripe\Exception\NotFoundException $e) {
         return $this->error_M1;          
        } 
   }

   public function deleteCreditCard($account_id,$card_id){

      try{

        $customer_id = $this->getCostumerId($account_id);

        $card = $stripe->cards()->delete($customer_id,$card_id);

        return true;
          
       } catch (\Cartalyst\Stripe\Exception\NotFoundException $e) {
         return $this->error_M1;          
        }
        catch (\Cartalyst\Stripe\Exception\BadRequestException $e) {
          return $this->error_M2;          
        }
        catch (\Cartalyst\Stripe\Exception\InvalidRequestException $e) {
          return $this->error_M2;          
        }
        catch (\Cartalyst\Stripe\Exception\CardErrorException $e) {
          return $this->error_M3;          
        }
        catch (\Cartalyst\Stripe\Exception\NotFoundException $e) {
         return $this->error_M1;          
        } 
   }

   public function updateCreditCard($account_id,$card_id,array $data){

        try{

          $customer_id = $this->getCostumerId($account_id);

          $card = $stripe->cards()->update($customer_id, $card_id,$data);

          return $card;
          
       } catch (\Cartalyst\Stripe\Exception\NotFoundException $e) {
         return $this->error_M1;          
        }
        catch (\Cartalyst\Stripe\Exception\BadRequestException $e) {
          return $this->error_M2;          
        }
        catch (\Cartalyst\Stripe\Exception\InvalidRequestException $e) {
          return $this->error_M2;          
        }
        catch (\Cartalyst\Stripe\Exception\CardErrorException $e) {
          return $this->error_M3;          
        }
        catch (\Cartalyst\Stripe\Exception\NotFoundException $e) {
         return $this->error_M1;          
        } 
   }


   public function generateTokenCreditCard($account_id, $data = false){
     try{

          $customer_id = $this->getCostumerId($account_id);

          if(!$data){
            $datCC =  [
                  'number'    => '4242424242424242',
                  'exp_month' => 10,
                  'cvc'       => 314,
                  'exp_year'  => 2020,
              ];
          }
          else{
            $datCC = $data;
          }

          $token = $stripe->tokens()->create([
              'card' => $datCC
          ]);

          return $token;
          
       } catch (\Cartalyst\Stripe\Exception\NotFoundException $e) {
         return $this->error_M1;          
        }
        catch (\Cartalyst\Stripe\Exception\BadRequestException $e) {
          return $this->error_M2;          
        }
        catch (\Cartalyst\Stripe\Exception\InvalidRequestException $e) {
          return $this->error_M2;          
        }
        catch (\Cartalyst\Stripe\Exception\CardErrorException $e) {
          return $this->error_M3;          
        }
        catch (\Cartalyst\Stripe\Exception\NotFoundException $e) {
         return $this->error_M1;          
        } 
   }

   /** Charges */

   public function loadCharge($account_id,$amount,$description,array $metadata,$currency = 'USD'){

      try{

          $customer_id = $this->getCostumerId($account_id);

          $charge = $this->stripe->charges()->create([
                'customer' => $customer_id,
                'currency' => $currency,
                'amount'   => $amount,
                'description' => $description,
                'metadata' => $metadata
          ]);
          return $charge;
          
       } catch (\Cartalyst\Stripe\Exception\NotFoundException $e) {
         return $this->error_M1;          
        }
        catch (\Cartalyst\Stripe\Exception\BadRequestException $e) {
          return $this->error_M2;          
        }
        catch (\Cartalyst\Stripe\Exception\InvalidRequestException $e) {
          return $this->error_M2;          
        }
        catch (\Cartalyst\Stripe\Exception\CardErrorException $e) {
          return $this->error_M3;          
        }
        catch (\Cartalyst\Stripe\Exception\NotFoundException $e) {
         return $this->error_M1;          
        } 
   }

   public function getCharge($customer_id,$charge_id = false){
     try{

          $customer_id = $this->getCostumerId($account_id);

          if(!$charge_id){
            $charges = $stripe->charges()->all(['customer'=>$customer_id]);
          }
          else{
            $charges = $stripe->charges()->find($charge_id);
          }
          return $charges;
          
       } catch (\Cartalyst\Stripe\Exception\NotFoundException $e) {
         return $this->error_M1;          
        }
        catch (\Cartalyst\Stripe\Exception\BadRequestException $e) {
          return $this->error_M2;          
        }
        catch (\Cartalyst\Stripe\Exception\InvalidRequestException $e) {
          return $this->error_M2;          
        }
        catch (\Cartalyst\Stripe\Exception\CardErrorException $e) {
          return $this->error_M3;          
        }
        catch (\Cartalyst\Stripe\Exception\NotFoundException $e) {
         return $this->error_M1;          
        } 
   }



   public function refundCharge($charge_id){

      try{

          $customer_id = $this->getCostumerId($account_id);

          $refund = $stripe->refunds()->create($charge_id);

          return $charge;
          
       } catch (\Cartalyst\Stripe\Exception\NotFoundException $e) {
         return $this->error_M1;          
        }
        catch (\Cartalyst\Stripe\Exception\BadRequestException $e) {
          return $this->error_M2;          
        }
        catch (\Cartalyst\Stripe\Exception\InvalidRequestException $e) {
          return $this->error_M2;          
        }
        catch (\Cartalyst\Stripe\Exception\CardErrorException $e) {
          return $this->error_M3;          
        }
        catch (\Cartalyst\Stripe\Exception\NotFoundException $e) {
         return $this->error_M1;          
        } 
   }
}
