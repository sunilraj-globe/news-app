@extends('master')

@section('title', 'Page Title')

@section('content')
	<div class = "row top-navigation">
	    <div class = "offset-3 offset-xl-2 offset-md-0 col-6 col-md-4 col-xl-2">
	    	<img src="{{ URL::to('/images/placeholder.svg') }}" alt="Logo" class="img-fluid">
	    </div>
	    <div class = "col-12 col-md-4 col-xl-4">
	    	<div class="form-group pt-md-5 mt-xl-1">
                <input placeholder="Search article name. ." type = "text" name = "search" id = "search" class="mt-2 form-control search-bar" onchange="filter_search(this);">
            </div>
	    </div>
	     <div class = "col-12 col-md-4 col-xl-4 pt-md-5 mt-md-4 pt-2 text-center">
	    	<a href="#pinned"><i class="fas fa-thumbtack"></i> Pinned Articles</a>
	    </div>
	</div>
	<!-- SEARCHED ARTICLES -->
	<div class = 'article-container'>
		<p class = "h1 pt-4">New Articles</p>
		<div class = "append_articles">
		@foreach($news[0] as $new)	
			<div class = "row articles pt-4 pb-4">
				<div class = "col-12 col-md-10 pt-4">
					<a href="{{$new['webUrl']}}" class ="article-link" target="_blank">
						<p class = "h5">{{$new['webTitle']}}</p>
						<p>{{$new['section']['webTitle']}}</p>
						<p>{{Carbon\Carbon::parse($new['webPublicationDate'])->format('d/m/Y')}}</p>
						<p>	<span class = "h6">Tags: </span>
							@foreach($new['tags'] as $tags)
							@if($loop->last)
								{{$tags['webTitle']}}
							@else
								{{$tags['webTitle']}},
							@endif
							@endforeach
						</p>
					</a>
				</div>
				<div class = "col-12 col-md-1 pt-5 text-right">
					<button class = "btn" onclick="save_news(this)" data-active="false" data-id = "{{$new['id']}}"> <i class="fas fa-thumbtack"></i></button>
				</div>
			</div>
		@endforeach
		</div>
	</div>
	<!-- PINNED ARTICLES -->
	<div class = 'saved-article-container' id="pinned">
		<p class = "h1 pt-4">Pinned Articles</p>
		@foreach($news[1] as $new)	
		<div class = "row articles pt-4 pb-4">
			<div class = "col-12 col-md-10 pt-4">
				<a href="{{$new['webUrl']}}" class ="article-link" target="_blank">
					<p class = "h5">{{$new['webTitle']}}</p>
					<p>{{$new['section']['webTitle']}}</p>
					<p>{{Carbon\Carbon::parse($new['webPublicationDate'])->format('d/m/Y')}}</p>
					<p>	<span class = "h6">Tags: </span>
						@foreach($new['tags'] as $tags)
						@if($loop->last)
							{{$tags['webTitle']}}
						@else
							{{$tags['webTitle']}},
						@endif
						@endforeach
					</p>
				</a>
			</div>
			<div class = "col-12 col-md-1 pt-5 text-right">
				<button class = "btn" onclick="save_news(this)" data-active="true" data-id = "{{$new['id']}}"> <i class="fas  fa-times"></i></button>
			</div>
		</div>
		@endforeach
	</div>
@stop