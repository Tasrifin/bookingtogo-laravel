<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function nationality(){
        return $this->belongsTo(Nationality::class, 'nationality_id', 'nationality_id');
    }

    public function families(){
        return $this->HasMany(FamilyList::class, 'cst_id', 'cst_id');
    }
}
