jQuery(document).ready(function() {
	jQuery('.mlp-post-slider').slick({
	  dots: true,
	  arrows: false,
	  infinite: true,
	  slidesToShow: 4,
	  slidesToScroll: 4,
	  responsive: [
		{
		  breakpoint: 320,
		  settings: {
			arrows: false,
			centerMode: true,
			slidesToShow: 1
		  }
		},
		{
		  breakpoint: 768,
		  settings: {
			arrows: false,
			centerMode: true,
			slidesToShow: 2
		  }
		}
	  ]
	});
});