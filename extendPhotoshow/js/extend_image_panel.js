function extend_init_image_panel(){

	//toggle select class
	$(".panel, .linear_panel").attr('class','extend_linear_panel');
	// On clicking an item
	$(document).on('click','.extend_linear_panel .item a', function(){
		$(".extend_linear_panel .selected").removeClass("selected");
		$(this).parent().addClass("selected");
		update_url($(this).attr("href"),"Image");
		populate_form($(this).attr("href"));
		
		return false;
	});
	//redirect to initial page
	$('form input[type=cancel]').on('click',function(){
		window.location=$('form').attr('action');
	})

}
	
function populate_form(href){
	//construct name of thumnail
	br_regex = /(\?f=)(.+)(\.[jpg|jpeg|png|gif])/;
	//href=href.replace(br_regex,"$2_small$3");
	href=href.replace(br_regex,"$2$3");
	

	image_url="/thumbs/Thumbs/"+href;
	console.log(image_url);
	var img = new Image();
	img.onload=function(){
		var height = img.height;
		var width = img.width;
	var dimensions=image_crop(width,height);
	$('input[name=image_name]').val(image_url);
	$('input[name=image_width]').val(dimensions[0]);
	$('input[name=image_height]').val(dimensions[1]);
	}
	
	img.src= image_url;
	
	
	
	
}


function image_crop(width,height){
	var max=310;
	if(width>height)
		max_image=width;
	else
		max_image=height;
	if(max_image<max)
		return [width,height];
	else {
		var ratio = max/max_image;
		new_width =parseInt( width * ratio);
		new_height= parseInt(height * ratio);
		return [new_width, new_height];
	}
}


//not document ready because we wait for javascript to load
$(window).on('load',function(){
	extend_init_image_panel();
});