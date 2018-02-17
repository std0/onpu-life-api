<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ExamForm
 */
class ExamForm extends Model
{
    protected $table = 'exam_forms';

    public $timestamps = false;

    protected $fillable = [
        'form'
    ];

    protected $guarded = [];

    public function subjects()
    {
    	return $this->hasMany('App\Subject');
    }
}