(function(){
	var image = document.getElementById('img');
	var urlRedirect = image.data('url');
	var options = {
		aopacity:0.0001, 
		mixed:true,
		simple: true,
		aimage: true,
		polygon:true,
		aborder: true,
		callback: function() {
			window.location.href = urlRedirect;
		},
	};

	snapfit.add(image, options);

	$('#resolve').on('click', function(){
		snapfit.solve(document.getElementById($(this).data('img')));
		setInterval(function(){ window.location.href = urlRedirect; }, 1000);
	});
})();
