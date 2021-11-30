$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
function save_news(elem){
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
        }
    }); 
}