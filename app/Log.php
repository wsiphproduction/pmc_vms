<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use danielme85\LaravelLogToDB\Models\LogToDbCreateObject;

class Log extends Model
{

    use LogToDbCreateObject;
    protected $table = 'log';
    protected $connection = 'sqlsrv';
    protected $fillable = [
        'id',
        'message',
        'channel',
        'level',
        'level_name',
        'unix_time',
        'datetime',
        'context',
        'extra',
        'userid',
        'username'
    ];
}
