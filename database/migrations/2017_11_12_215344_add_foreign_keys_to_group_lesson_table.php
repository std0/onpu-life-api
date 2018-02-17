<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeysToGroupLessonTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('group_lesson', function(Blueprint $table)
		{
			$table->foreign('group_id', 'group_lesson_ibfk_1')->references('id')->on('groups')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('lesson_id', 'group_lesson_ibfk_2')->references('id')->on('lessons')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('group_lesson', function(Blueprint $table)
		{
			$table->dropForeign('group_lesson_ibfk_1');
			$table->dropForeign('group_lesson_ibfk_2');
		});
	}

}
