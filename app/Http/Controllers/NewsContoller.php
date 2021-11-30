<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;


class NewsContoller extends Controller
{
    public function index()
    {
    	$news = News::GetNews();
        return view('news.index',compact('news'));
    }
    public function store(Request $req){
		$news = News::Store($req);
        return redirect()->route('news.index');
    }
}
