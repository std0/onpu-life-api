<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class GroupSubject
 */
class GroupSubject extends Model
{
    protected $table = 'group_subject';

    public $timestamps = false;

    protected $fillable = [
        'group_id',
        'subject_id',
        'form_id'
    ];

    protected $guarded = [];
}