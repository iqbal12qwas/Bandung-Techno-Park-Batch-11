<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ActivityModel extends Model
{
    use softDeletes;
    protected $table = 'tb_activities';
    protected $fillable = [
        'id_methods',
        'id_months',
        'activity',
        'date_start',
        'date_end',
        'is_deleted',
        'deleted_at',
        'created_at',
        'updated_at'
    ];
    protected $hidden;
}
