<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class File
 */
class File extends Model
{
    protected $table = 'files';

    public $timestamps = false;

    protected $fillable = [
        'subject_id',
        'name',
        'file'
    ];

    protected $guarded = [];

    protected $hidden = [
        'subject_id',
        'file'
    ];

    public function subject()
    {
         return $this->belongsTo('App\Subject');
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this->save();
    }
}