<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mark extends Model
{
    use HasFactory;

    public function subject(){
        return $this->belongsTo(Subject::class, 'sub_id', 'id');
    }

    public function semester(){
        return $this->belongsTo(Semester::class, 'sem_id', 'id');
    }

    public function student(){
        return $this->belongsTo(Student::class, 'stu_id', 'id');
    }
}
