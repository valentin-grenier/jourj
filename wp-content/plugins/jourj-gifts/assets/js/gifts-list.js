document.addEventListener('DOMContentLoaded', () => {
	if (!document.querySelector('.jo-block-gifts-list')) return;

	console.log('Gifts list page loaded');

	const gifts = document.querySelectorAll('.jo-block-gifts-list__item');

	gifts.forEach((gift) => {
		const giftId = gift.dataset.giftId;

		const buttons = gift.querySelectorAll('.jo-block-gifts-list__item--buttons button');

		if (!buttons.length) return;

		const participateButton = buttons[0];
		const reserveButton = buttons[1];

		participateButton.addEventListener('click', (event) => {
			console.log('Participate clicked:', giftId);
			fetchGiftData(giftId);
		});
	});

	/**
	 * Fetch gift data from the server via AJAX
	 */
	function fetchGiftData(giftId) {
		const formData = new FormData();
		formData.append('action', 'jourj_get_gift_data');
		formData.append('gift_id', giftId);
		formData.append('nonce', jourj_gift_ajax.nonce);

		fetch(jourj_gift_ajax.ajax_url, {
			method: 'POST',
			credentials: 'same-origin',
			body: formData,
		})
			.then((response) => response.json())
			.then((json) => {
				if (json.success) {
					console.log('Gift data:', json.data);
					openGiftModal(json.data);
				} else {
					console.log(json.data || 'Gift not found');
				}
			})
			.catch((err) => {
				console.error('AJAX error:', err);
			});
	}

	/**
	 * Open the gift details modal
	 *
	 */
	function openGiftModal(gift) {
		const modal = document.querySelector('.jo-block-gift-modal');
		if (!modal) return;

		// == Fill modal elements
		const titleEl = modal.querySelector('.gift-name');
		const priceEl = modal.querySelector('.gift-price');
		const imageEl = modal.querySelector('.gift-image');

		if (titleEl) titleEl.textContent = gift.title;
		if (priceEl) priceEl.textContent = `${gift.price}€`;
		if (imageEl && gift.image) {
			imageEl.setAttribute('src', gift.image);
			imageEl.setAttribute('alt', gift.title);
		}

		/**
		 * Compute amount buttons
		 *
		 * If gift price is greater than 1 000€, set 100€, 200€, 500€ and 750€ amounts
		 * Else, set 25%, 50%, 75% and 100% of the gift price, rounded to 0 decimal
		 */
		const amountButtons = modal.querySelectorAll('.jo-block-gift-modal__details--amounts button.defined-amount');

		const giftPrice = gift.price;
		const amounts = giftPrice > 1000 ? [100, 200, 500, 750] : [0.25, 0.5, 0.75, 1].map((percent) => Math.round(giftPrice * percent));

		amountButtons.forEach((button, index) => {
			const amount = amounts[index];
			button.textContent = giftPrice > 1000 ? `${amount}€` : `${amount}€`;
			button.dataset.amount = amount;
		});

		/**
		 * If custom amount button is clicked, show a custom input field, else hide it
		 */
		const customAmountButton = modal.querySelector('.jo-block-gift-modal__details--amounts button.custom-amount');
		const customAmountInput = modal.querySelector('.jo-block-gift-modal__details--custom-amount');

		customAmountButton.addEventListener('click', () => {
			customAmountInput.classList.toggle('hidden');
			customAmountButton.classList.toggle('active');
		});

		/**
		 * Open the modal and its overlay
		 */
		const overlay = document.querySelector('.jo-block-gift-modal__overlay');

		modal.classList.add('active');
		overlay.classList.add('active');

		/**
		 * Close the modal when clicking outside of it or on the close button
		 */
		const closeButton = modal.querySelector('.jo-block-gift-modal__close');

		const closeModal = () => {
			modal.classList.remove('active');
			modal.removeEventListener('click', closeModal);
		};

		closeButton.addEventListener('click', () => {
			closeModal();
		});
	}
});
