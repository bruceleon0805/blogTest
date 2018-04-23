<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    //
    protected $fillable = ['name','questions_count'];  //填充数据

    /**
     * 多对多关系
     */
    public function questions()
    {
        $this->belongsToMany(Question::class)->withTimestamps();
    }
}
