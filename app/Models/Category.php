<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // public function get______Attribute

    protected $appends = ['status'];

    public function getStatusAttribute () {
        return $this->active ? "Active" : "Disabled";
    }

    public function tasks () {
        return $this->hasMany(Task::class, 'category_id', 'id');
    }
}
