@extends('master')

@section('title', 'Page Title')

@section('content')
	<div class = "row top-navigation">
	    <div class = "offset-xl-2 offset-3 offset-md-0 col-6 col-md-3 col-xl-2">
	    	<img src="{{ URL::to('/images/placeholder.svg') }}" alt="Logo" class="img-fluid">
	    </div>
	    <div class = "col-12 col-md-9 col-xl-4">
	    	<div class="form-group pt-md-5 mt-xl-1">
                <input placeholder="Search article name. ." type = "text" name = "search" id = "search" class="mt-2 form-control search-bar">
            </div>
	    </div>
	</div>
	<div class = 'article-container'>
	@foreach($news as $new)
		<a href="{{$new['webUrl']}}" class ="article-link">
			<div class = "row articles pt-4 pb-4">
				<div class = "col-12 pt-4">
					<p class = "h5">{{$new['webTitle']}}</p>
					<p>{{Carbon\Carbon::parse($new['webPublicationDate'])->format('d/m/Y')}}</p>	
				</div>
			</div>
		</a>
	@endforeach
	</div>
@stop