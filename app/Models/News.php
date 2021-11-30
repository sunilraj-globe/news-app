<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;

class News extends Model
{
    use HasFactory;
    public static function GetNews(){
       	$news = Http::get('https://content.guardianapis.com/search?api-key='.env('NEWS_API'));
       	if($news->successful()){
       		return $news['response']['results'];
       	}else{
       		return null;
       	}
        
    }
}
