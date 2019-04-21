<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'text', 'read', 'from_id', 'to_id'
    ];

    public function from() {
        return $this->belongsTo(User::class, 'from_id', 'id');
    }


    public function to() {
        return $this->belongsTo(User::class, 'to_id', 'id');
    }
}
