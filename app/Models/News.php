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
       	$news = Http::get('https://content.guardianapis.com/search?api-key='.env('NEWS_API').'&show-tags=keyword&show-section=true&page-size=10');      	
       	if($news->successful()){
       		$final_news = News::FilterNews($news['response']['results']);
       		return $final_news;
       	}else{
       		return null;
       	}  
    }
    public static function GetNewsSpecific($req){
       	$news = Http::get('https://content.guardianapis.com/search?q='.$req->search.'&api-key='.env('NEWS_API').'&show-tags=keyword&show-section=true&page-size=10');
       	if($news->successful()){
       		$final_news = News::FilterNews($news['response']['results']);
       		return $final_news;
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
    public static function FilterNews($results){
    	$saved_news = News::where('deleted_at',NULL)->pluck('news_id');
    	$filtered_news = array();
   		$saved_news_array = array();
   		foreach($results as $result){
   			if($saved_news){
   				if(!in_array($result['id'], $saved_news->toArray()) ) {
   					array_push($filtered_news,$result);
   				}
   			}	
   		}
   		foreach($saved_news as $saved){
			$news = Http::get('https://content.guardianapis.com/'.$saved.'?api-key='.env('NEWS_API').'&show-tags=keyword&show-section=true&page-size=10');
			if($news->successful()){
				array_push($saved_news_array,$news['response']['content']);
			}
   		}
   		return [collect($filtered_news)->sortBy('section')->toArray(),collect($saved_news_array)->sortBy('section')->toArray()];
    } 
}
