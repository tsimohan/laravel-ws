<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'dept_id'];

    public function department() {
        return $this->hasOne(Department::class, 'id', 'dept_id');
    }

    public function marks() {
        return $this->hasMany(Mark::class, 'stu_id', 'id');
    }
}
