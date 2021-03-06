<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    /**
     * 多对多关系
     */
    public function topics()
    {
        $this->belongsToMany(Topic::class)->withTimestamps();
    }



}
