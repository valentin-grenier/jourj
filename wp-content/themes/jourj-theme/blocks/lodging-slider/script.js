// simple swiper script
document.addEventListener('DOMContentLoaded', () => {
	const swiper = new Swiper('.jo-block-lodging-slider', {
		slidesPerView: 1,
		spaceBetween: 32,
		centeredSlides: false,
		loop: false,
		speed: 500,
		navigation: {
			nextEl: '.swiper-button-next',
			prevEl: '.swiper-button-prev',
		},
		pagination: {
			el: '.swiper-pagination',
			clickable: true,
		},
		breakpoints: {
			768: {
				slidesPerView: 2,
				spaceBetween: 32,
			},
		},
	});
});
