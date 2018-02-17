<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeysToSubjectTeacherTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('subject_teacher', function(Blueprint $table)
		{
			$table->foreign('subject_id', 'subject_teacher_ibfk_1')->references('id')->on('subjects')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('teacher_id', 'subject_teacher_ibfk_2')->references('id')->on('teachers')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('subject_teacher', function(Blueprint $table)
		{
			$table->dropForeign('subject_teacher_ibfk_1');
			$table->dropForeign('subject_teacher_ibfk_2');
		});
	}

}
