<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeysToLessonsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('lessons', function(Blueprint $table)
		{
			$table->foreign('subject_id', 'lessons_ibfk_1')->references('id')->on('subjects')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('type_id', 'lessons_ibfk_2')->references('id')->on('types')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('lessons', function(Blueprint $table)
		{
			$table->dropForeign('lessons_ibfk_1');
			$table->dropForeign('lessons_ibfk_2');
		});
	}

}
