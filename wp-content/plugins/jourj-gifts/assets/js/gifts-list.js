document.addEventListener('DOMContentLoaded', () => {
	if (!document.querySelector('.jo-block-gifts-list')) return;

	const gifts = document.querySelectorAll('.jo-block-gifts-list__item');

	gifts.forEach((gift) => {
		const giftId = gift.dataset.giftId;

		const buttons = gift.querySelectorAll('.jo-block-gifts-list__item--buttons button');

		if (!buttons.length) return;

		const participateButton = buttons[0];
		const reserveButton = buttons[1];

		participateButton.addEventListener('click', (event) => {
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
					openGiftModal(json.data);
				} else {
					console.error(json.data || 'Gift not found');
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
		const allButtons = modal.querySelectorAll('.jo-block-gift-modal__details--amounts button');
		const amountButtons = modal.querySelectorAll('.jo-block-gift-modal__details--amounts button.defined-amount');

		const giftPrice = gift.price;
		const amounts = giftPrice > 1000 ? [100, 200, 500, 750] : [0.25, 0.5, 0.75, 1].map((percent) => Math.round(giftPrice * percent));

		amountButtons.forEach((button, index) => {
			// == Fill button elements depending on the gift price
			let amount = amounts[index];

			if (giftPrice <= 1000) {
				amount = Math.round(amount / 5) * 5;
			}

			button.textContent = `${amount}€`;
			button.dataset.amount = amount;

			// == Add event listener to each button
			button.addEventListener('click', () => {
				// == Remove active class from all buttons
				allButtons.forEach((btn) => {
					btn.classList.remove('active');
				});

				// == Add active class to the clicked button
				button.classList.add('active');

				// == Set the selected amount in the hidden input field
				const selectedAmountInput = modal.querySelector('.jo-block-gift-modal__form input[name="user-funding"]');
				selectedAmountInput.value = button.dataset.amount;

				// == Hide the custom amount input field if defined-amount button is clicked
				const customAmountInput = modal.querySelector('.jo-block-gift-modal__details--custom-amount');

				if (customAmountInput.classList.contains('active')) {
					customAmountInput.classList.remove('active');
					customAmountInput.style.height = '0px';
					customAmountButton.classList.remove('active');
				}
				customAmountInput.value = '';
				customAmountInput.style.height = '0px';
			});
		});

		/**
		 * If custom amount button is clicked, show a custom input field, else hide it
		 */
		const customAmountButton = document.querySelector('.jo-block-gift-modal__details--amounts button.custom-amount');
		const customAmount = document.querySelector('.jo-block-gift-modal__details--custom-amount');
		const customAmountInput = document.querySelector('.jo-block-gift-modal__details--custom-amount input[name="custom-amount"]');

		customAmountButton.addEventListener('click', () => {
			// == Toggle active class on the custom amount button and input field
			customAmountButton.classList.toggle('active');

			if (customAmountButton.classList.contains('active')) {
				customAmount.classList.add('active');
				const customAmountHeight = customAmount.scrollHeight;
				customAmount.style.height = `${customAmountHeight}px`;

				// == Remove active class from all other buttons
				amountButtons.forEach((btn) => {
					btn.classList.remove('active');
				});
			} else {
				customAmount.classList.remove('active');
				customAmount.style.height = '0px';
				customAmountButton.classList.remove('active');
			}

			// == Get the existing value of the custom amount input field and set it to the hidden input field
			const hiddenFieldAmount = modal.querySelector('.jo-block-gift-modal__form input[name="user-funding"]');
			const customAmountValue = parseFloat(customAmountInput.value);

			if (!isNaN(customAmountValue)) {
				hiddenFieldAmount.value = customAmountValue;
			} else {
				hiddenFieldAmount.value = 0;
			}
		});

		/**
		 * Open the modal and its overlay
		 */
		modal.classList.add('active');

		/**
		 * Update the hidden input field when the custom amount input field changes
		 */

		customAmountInput.addEventListener('input', () => {
			const numericValue = parseFloat(customAmountInput.value);

			const hiddenFieldAmount = modal.querySelector('.jo-block-gift-modal__form input[name="user-funding"]');
			hiddenFieldAmount.value = numericValue;
		});

		/**
		 * Close the modal when clicking on close button or on overlay
		 */
		const closeButton = modal.querySelector('.jo-block-gift-modal__close');
		closeButton.addEventListener('click', closeGiftModal);
	}

	/**
	 * Close the modal
	 */
	function closeGiftModal() {
		const modal = document.querySelector('.jo-block-gift-modal');
		if (!modal) return;

		modal.classList.remove('active');
	}
});
