function get_notifications(){
	$.ajax({
		method: "POST",
		url: window.location.origin + "/ajax?act=notifications_show",
	}).done(function( d ) {

		console.log(d);
		// n = jQuery.parseJSON(d); //if error abort all commands below
		// console.log("n: "+ n);
		
		// //console.log(n.qqq);
		// $('#header_notification_bar').html(n.notification);
		// //alert(n.qqq);
		// if(n.has_noti == 1){
		// 	toastr.info('<div><a href="#" onclick="toggle_comments('+n.id+')">'+n.noti_msg+' from '+n.noti_from+'</a></div>');
		// }		
	});
}

function toggle_comments(id){	
	$('body').toggleClass('page-quick-sidebar-open');
	$('#msg_contents').html('');
	get_chat_area(id);
	get_comments(id);
}

window.onload = function(e){    
	$('.dropdown-quick-sidebar-toggler').click(function (e) {	
		$('body').toggleClass('page-quick-sidebar-open');	
		$('#msg_contents').html('');
		get_chat_area(this.id);
		get_comments(this.id);
	}); 
	setInterval(get_notifications, 8000);

	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
}


