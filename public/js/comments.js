

function get_comments(id){
	clear_comments();
	$.ajax({
		method: "POST",
		url: "/vehicle/request/comment/all",
		data: { id: id}
	})
	.done(function( html ) {
		$('#quick_sidebar_tab_1').html(html);
	});
}

function get_chat_area(id){
	$.ajax({
		method: "POST",
		url: "/vehicle/request/comment/area",
		data: { id: id}
	})
	.done(function( html ) {
		$('#msg_chatarea').html(html);
	});
}

function clear_comments(){
	$('#msg_contents').html('');
}

function send_comment(txt,id){
	clear_comments();
	if(!$.trim(txt)){
		$('#msg_error').html('Please Enter a message!');
		return false;
	}
	$.ajax({
		method: "POST",
		url: "/vehicle/request/comment/",
		data: { id: id, txt: txt}
	})
	.done(function( html ) {
		get_chat_area(id);
		get_comments(id);
		get_last_comment(id);
	});
	
}

function get_last_comment(id){
	$.ajax({
		method: "POST",
		url: "/vehicle/request/comment/last",
		data: { id: id}
	})
	.done(function( html ) {
		$('#msg_status'+id).html(html);
	});
}

function refresh_comments(id){

}

