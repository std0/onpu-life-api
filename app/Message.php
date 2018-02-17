<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Message
 */
class Message extends Model
{
    protected $table = 'messages';

    public $timestamps = false;

    protected $fillable = [
        'message',
        'created_at',
        'subject_id'
    ];

    protected $guarded = [];

    protected $hidden = [
        'id',
        'subject_id'
    ];

    public function subject()
    {
         return $this->belongsTo('App\Subject');
    }
}