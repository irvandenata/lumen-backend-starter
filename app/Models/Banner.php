<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $guarded = [''];
    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }
}
