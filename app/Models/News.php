<?php

namespace App\Models;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class News extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = "tb_news";
    protected $id = "id";

    public function category(){
        $data = $this->belongsTo(Category::class,'id_category');
        return $data;
    }
}
