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

		document.documentElement.style.overflowY = menu.classList.contains('is-visible') ? 'hidden' : 'auto';
	});
});
