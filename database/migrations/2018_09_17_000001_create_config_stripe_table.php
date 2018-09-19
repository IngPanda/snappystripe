<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateConfigStripeTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if (!Schema::hasTable('stripe_config_data'))
		{
			Schema::create('stripe_config_data', function(Blueprint $table)
			{
				$table->increments('id');
				$table->integer('customer_id')->index();
				$table->integer('account_id')->nullable();
				$table->timestamps();
			});
		}
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('stripe_config_data');
	}

}
