<?php

use Illuminate\Database\Migrations\Migration;

class CreateApikeysTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('api_keys', function($table) {
			$table->string('id', 64);
			$table->string('email', 150);
			$table->string('name', 150);
			$table->boolean('active');

			// created_at | updated_at DATETIME
			$table->timestamps();

			// Indexes
			$table->primary('id');
			$table->index('active');

			// Engine
			$table->engine = 'InnoDB';
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('api_keys');
	}

}