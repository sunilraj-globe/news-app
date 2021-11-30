$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
function save_news(elem){
	$('.loader').removeClass('d-none');
	 $.ajax({
        url:'news/store',
        type:"POST",
        data: {  search:$(elem).data('id'), active:$(elem).data('active') },
        success: function (data,status,xhr) { 
 			location.reload();
        },
        error: function (request, error) {
            console.log(arguments);
            alert(" Can't do because: " + error);
        },
        complete:function(data){
	    	$('.loader').addClass('d-none');
	    }
    }); 
}
function filter_search(elem){
	$('.loader').removeClass('d-none');
    $.ajax({
        url:'news',
        type:"POST",
        data: {  search:$('#search').val()},
        success: function (data,status,xhr) {
 			$('.append_articles').empty(); 
 			$.each(data[0], function(index, value) {
			  	var append ='<div class = "row articles pt-4 pb-4">';
				append +='	<div class = "col-12 col-md-10 pt-4">';
				append +='		<a href="'+value['webUrl']+'" class ="article-link" target="_blank">';
				append +='			<p class = "h5">'+value['webTitle']+'</p>';
				append +='			<p>'+value['section']['webTitle']+'</p>';
				append +='			<p>'+moment(value['webPublicationDate']).format('DD/MM/YYYY')+'</p>';
				append +='			<p>	<span class = "h6">Tags: </span>';
				$.each(value['tags'], function(index, value) {
					if(index == 0){
						append += value['webTitle'];
					}else{
						append += ", "+value['webTitle'];
					}	
				});					
				append +='			</p>';
				append +='		</a>';
				append +='	</div>';
				append +='	<div class = "col-12 col-md-1 pt-5 text-right">';
				append +='		<button class = "btn" onclick="save_news(this)" data-active="false" data-id = "'+value['id']+'"> <i class="fas fa-thumbtack"></i></button>';
				append +='	</div>';
				append +='</div>';
				$(".append_articles").append(append);
			}); 

 		},
        error: function (request, error) {
            console.log(arguments);
            alert(" Can't do because: " + error);
        },
        complete:function(data){
	    	$('.loader').addClass('d-none');
	    }
    }); 
}