<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class News extends Model
{
    use HasFactory;
    protected $table = 'news'; 
    protected $primaryKey = 'id';
    protected $guarded = [];  


    public static function GetNews(){
    	$saved_news = News::where('deleted_at',NULL)->pluck('news_id');
    	
       	$news = Http::get('https://content.guardianapis.com/search?api-key='.env('NEWS_API').'&show-tags=keyword&show-section=true&page-size=20');
       	
       	if($news->successful()){
       		$filtered_news = array();
       		$saved_news_array = array();
       		foreach($news['response']['results'] as $result){
       			if($saved_news){
       				if(!in_array($result['id'], $saved_news->toArray()) ) {
       					array_push($filtered_news,$result);
       				}else{
       					array_push($saved_news_array,$result);
       				}
       			}	
       		}
       		//dd([$filtered_news,$saved_news_array]);
       		return [collect($filtered_news)->sortBy('section')->toArray(),collect($saved_news_array)->sortBy('section')->toArray()];
       	}else{
       		return null;
       	}  
    }
    public static function Store($req){
    	if($req->active == "true"){
    		$news = News::where('news_id',$req->search)->update(['deleted_at' => Carbon::now()]);
    	}else{
    		$news = new News;
    		$news->news_id = $req->search;
    		$news->save();
    	}
    	return 'success';
    }
}
