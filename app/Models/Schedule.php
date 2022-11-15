<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    const STATUS_SCHEDULED = 1;
    const STATUS_CLOSED = 2;
    const STATUS_CANCELED = 3;

    protected $fillable = [
        'client_id',
        'dentist_id',
        'date',
        'hour',
        'service_name',
        'status_id',
    ];


}
