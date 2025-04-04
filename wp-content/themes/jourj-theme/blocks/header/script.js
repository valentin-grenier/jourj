document.addEventListener('DOMContentLoaded', () => {
	if (!document.querySelector('.jo-block-header')) return;

	const burger = document.querySelector('.jo-block-header__burger');
	const header = document.querySelector('.jo-block-header');
	const menu = document.querySelector('.jo-block-header__innerblocks');

	// == Prevent duplicate listeners
	if (burger.dataset.clickBound === 'true') return;
	burger.dataset.clickBound = 'true';

	burger.addEventListener('click', () => {
		menu.classList.toggle('is-visible');

		document.documentElement.style.position = menu.classList.contains('is-visible') ? 'fixed' : 'static';

		// == For each link clicked, close the menu
		const links = menu.querySelectorAll('a');

		links.forEach((link) => {
			link.addEventListener('click', () => {
				document.documentElement.style.position = 'static';

				setTimeout(() => {
					menu.classList.remove('is-visible');
				}, 400);
			});
		});
	});
});
