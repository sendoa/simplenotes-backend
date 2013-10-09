<?php

use Illuminate\Database\Migrations\Migration;

class CreateNotesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('notes', function($table) {
			$table->string('id', 20);
			$table->string('user_id', 150);
			$table->text('text_content');
			$table->string('image_name', 150)->nullable();

			// created_at | updated_at DATETIME
			$table->timestamps();

			// Indexes
			$table->primary('id');
			$table->index(array('user_id'));

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
		Schema::drop('notes');
	}

}