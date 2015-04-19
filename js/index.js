var metric_succes = function(json){
	$("#metric").text(json.metric);
}
var button_handler_generator = function(url){
	return function(){
		console.log(url);
		$.post(url, function(){
			alert("success");
			update_view();
		});
	};
};
var update_view = function(){
	$.get("pua_log/metric",metric_succes);
}
var main = function(){
	update_view();
	$("#approach_button").click(button_handler_generator("pua_log/approaches")());
	$("#kissclose_button").click(button_handler_generator("pua_log/kisscloses")());
	$("#date_button").click(button_handler_generator("pua_log/dates")());
	$("#fuckclose_button").click(button_handler_generator("pua_log/fuckcloses")());
}
main();
