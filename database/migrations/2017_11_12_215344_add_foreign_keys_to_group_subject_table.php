<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeysToGroupSubjectTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('group_subject', function(Blueprint $table)
		{
			$table->foreign('group_id', 'group_subject_ibfk_1')->references('id')->on('groups')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('subject_id', 'group_subject_ibfk_2')->references('id')->on('subjects')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('group_subject', function(Blueprint $table)
		{
			$table->dropForeign('group_subject_ibfk_1');
			$table->dropForeign('group_subject_ibfk_2');
		});
	}

}
