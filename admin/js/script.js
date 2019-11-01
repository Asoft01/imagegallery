$(document).ready(function(){
	var user_href;
	var user_href_splitted;
	var user_id;

	var image_src;
	var image_href_splitted;
	var image_name;
	var photo_id;




$(".modal_thumbnails").click(function(){
	$("#set_user_image").prop('disabled', false);

	$(this).addClass("selected");

	// The user-href is coming from edit_user.php with the id on the delete.php
	user_href= $("#user-id").prop('href');
	user_href_splitted= user_href.split("=");
	user_id= user_href_splitted[user_href_splitted.length -1];
 
	//alert(user_id);
	image_src= $(this).prop("src");
	image_href_splitted= image_src.split("/");
	image_name= image_href_splitted[image_href_splitted.length-1];

	//alert(image_id);

	// Displaying the details of the pictures
	photo_id= $(this).attr("data");
	$.ajax({
		url: "includes/ajax_code.php",
		data: {photo_id:photo_id},
		type: "POST",
		success: function(data){
			if (!data.error) {
				$("#modal_sidebar").html(data);
			};
		}
	});
});



$("#set_user_image").click(function(){
	$.ajax({
		url:"includes/ajax_code.php",
		data: {image_name: image_name, user_id: user_id},
		type:"POST",
		success: function(data){
			if (!data.error) {
				//alert(data);
				//location.reload(true);
				$(".user_image_box a img").prop('src', data);
			};
		}
	});
});

/*******************************Edit Photo SideBar************************/

$(".info-box-header").click(function(){
$(".inside").slideToggle("fast");
$("#toggle").toggleClass("glyphicon-menu-down glyphicon, glyphicon-menu-up glyphicon ");
});

/*********************************Delete Function*********************************/
$(".delete_link").click(function(){
	return confirm("Are you sure you want to delete?");
})
tinymce.init({ selector:'textarea'});

});