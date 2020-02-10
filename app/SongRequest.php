<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SongRequest extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'requests';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'youtube_link', 'order'
    ];
}
