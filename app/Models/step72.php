<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class step72 extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'step72';
    protected $primaryKey = 'id';

    public function getData(){
        $data = step72::table($this->table)->get();
        return $data;
    }

    public function deleteStep72ById($id)
    {
        return $this->destroy($id);
    }
}
