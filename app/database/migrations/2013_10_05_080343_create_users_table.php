<?php

use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function($table) {
			$table->string('id', 20);
			$table->string('email', 100);
			$table->string('password', 64);
			$table->string('name', 100);
			$table->string('lastname', 100);
			$table->timestamps();

			// Indexes
			$table->primary('id');
			$table->index(array('email', 'password'));

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
		Schema::drop('users');
	}

}