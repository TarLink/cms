//click insert image button
function select_image_clicked(){
	to_click = $(".mce-i-image").parent();
	to_click.on('click',select_image);
	to_click.on('touchstart',select_image);
	
} 

//select the image option from menu, using mutation observers

function select_image_menu(){
	
	// select the target node
	var target = document.body;
	var flag2 = true;
	 
	// create an observer instance
	var observer = new MutationObserver(function(mutations) {
		
		 mutations.forEach(function(mutation) {
		   if (mutation.type === 'childList') {
				
				oParent = mutation.target;
				
				//click in menu; here because it's dynamically generated by TinyMCE's JavaScript
				to_click2 = oParent.getElementsByClassName("mce-i-image");
				if (to_click2.length == 2 && flag2 == true){
					par_2=to_click2[1].parentNode;
					$(par_2).on('click',select_image);
					flag2 = false;
				}
			};
		});
		
	});
	
	 
	// configuration of the observer:
	var config = { attributes: true, childList: true, characterData: true };
	 
	// pass in the target node, as well as the observer options
	observer.observe(target, config);

		
}

//redirect to gallery page, retaining referrer and cursor position
function select_image(){
	var bm = tinyMCE.get('content').selection.getBookmark(2,true);
	$('.panel-body').html('<form action="/photoshow/index_new.php" name="select_image" method="post" style="display:none;"><input type="hidden" name="referrer" value="' + window.location.href + '" /><input type="hidden" name="cursor_position" value="' + JSON.stringify(bm.start) +'" /></form>');
	document.forms['select_image'].submit();
}

//after the image is selected in photo album,  populate tinyMCE form
function populate_panel(){
	
		to_click = $(".mce-i-image").parent();
		to_click.click(); 
		
		floatpanel=document.getElementsByClassName("mce-floatpanel mce-window");
		if (floatpanel.length != 0){
					panel = floatpanel[0];
		var source=panel.getElementsByTagName("input");
		var cursor_position =JSON.parse( $('input[name="cursor_position"]').val());
		var bookmark_obj = {'start':cursor_position};
		tinymce.activeEditor.selection.moveToBookmark(bookmark_obj);
		source[0].value = $('input[name="image_name"]').val();
		source[1].value="thebest";
		source[2].value =parseInt( $('input[name="image_width"]').val());
		source[3].value = parseInt( $('input[name="image_height"]').val());
		
		
		}

}

$(window).on('load',function(){
	if(document.getElementById('populate_form_values')){
		populate_panel();
	}else{
		select_image_clicked();
	};
	select_image_menu();
})