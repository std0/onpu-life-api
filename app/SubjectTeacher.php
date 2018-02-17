<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class SubjectTeacher
 */
class SubjectTeacher extends Model
{
    protected $table = 'subject_teacher';

    public $timestamps = false;

    protected $fillable = [
        'subject_id',
        'teacher_id'
    ];

    protected $guarded = [];
}