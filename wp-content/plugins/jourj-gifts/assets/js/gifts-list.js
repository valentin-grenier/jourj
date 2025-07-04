document.addEventListener('DOMContentLoaded', () => {
	if (!document.querySelector('.jo-block-gifts-list')) return;

	const giftHighlight = document.querySelector('.jo-block-gift-highlight');
	const gifts = document.querySelectorAll('.jo-block-gifts-list__item');

	/**
	 * Open modal for gift highlight
	 */
	if (giftHighlight) {
		const giftId = giftHighlight.dataset.giftId;
		const button = giftHighlight.querySelector('button');

		button.addEventListener('click', () => {
			fetchGiftData(giftId, 'payment');
		});
	}

	/**
	 * Open modal for each gift item
	 */
	gifts.forEach((gift) => {
		const giftId = gift.dataset.giftId;

		const buttons = gift.querySelectorAll('.jo-block-gifts-list__item--buttons button');
		if (!buttons.length) return;

		const participateButton = buttons[0];
		const reserveButton = buttons[1];

		participateButton.addEventListener('click', () => {
			fetchGiftData(giftId, 'payment');
		});

		reserveButton.addEventListener('click', () => {
			fetchGiftData(giftId, 'reservation');
		});
	});

	/**
	 * Fetch gift data from the server via AJAX
	 */
	function fetchGiftData(giftId, modalType = 'payment') {
		const formData = new FormData();
		formData.append('action', 'jourj_get_gift_data');
		formData.append('gift_id', giftId);
		formData.append('mode', modalType);
		formData.append('nonce', jourj_gift_ajax.nonce);

		fetch(jourj_gift_ajax.ajax_url, {
			method: 'POST',
			credentials: 'same-origin',
			body: formData,
		})
			.then((response) => response.json())
			.then((json) => {
				if (json.success) {
					openGiftModal(json.data, modalType);
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
	 */
	function openGiftModal(gift, modalType = 'payment') {
		const modal = document.querySelector(`.jo-block-gift-modal.${modalType}`);
		const overlay = document.querySelector('.jo-block-gift-modal__overlay');
		if (!modal && !gift) return;

		const titleEl = modal.querySelector('.gift-name');
		const priceEl = modal.querySelector('.gift-price');
		const imageEl = modal.querySelector('.gift-image');

		if (titleEl) titleEl.textContent = gift.title;
		if (priceEl) priceEl.textContent = `${gift.price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ' ')}€`;

		if (imageEl && gift.image) {
			imageEl.setAttribute('src', gift.image);
			imageEl.setAttribute('alt', gift.title);
		}

		// === Payment Modal Logic ===
		if (modalType === 'payment') {
			const allButtons = modal.querySelectorAll('.jo-block-gift-modal__details--amounts button');
			const amountButtons = modal.querySelectorAll('.jo-block-gift-modal__details--amounts button.defined-amount');

			const giftPrice = gift.price;
			const amounts = giftPrice > 1000 ? [100, 200, 500, 750] : [0.25, 0.5, 0.75, 1].map((percent) => Math.round(giftPrice * percent));

			// == Fill amount buttons with values depending on the price
			amountButtons.forEach((button, index) => {
				let amount = amounts[index];
				if (giftPrice <= 1000) amount = Math.round(amount / 5) * 5;
				button.textContent = `${amount}€`;
				button.dataset.amount = amount;

				button.addEventListener('click', () => {
					allButtons.forEach((btn) => btn.classList.remove('active'));
					button.classList.add('active');
					const selectedAmountInput = modal.querySelector('.jo-block-gift-modal__form input[name="user-funding"]');
					selectedAmountInput.value = button.dataset.amount;

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

			const customAmountButton = modal.querySelector('.jo-block-gift-modal__details--amounts button.custom-amount');
			const customAmount = modal.querySelector('.jo-block-gift-modal__details--custom-amount');
			const customAmountInput = modal.querySelector('.jo-block-gift-modal__details--custom-amount input[name="custom-amount"]');

			customAmountButton.addEventListener('click', () => {
				customAmountButton.classList.toggle('active');

				if (customAmountButton.classList.contains('active')) {
					customAmount.classList.add('active');
					const customAmountHeight = customAmount.scrollHeight;
					customAmount.style.height = `${customAmountHeight}px`;

					amountButtons.forEach((btn) => btn.classList.remove('active'));
				} else {
					customAmount.classList.remove('active');
					customAmount.style.height = '0px';
					customAmountButton.classList.remove('active');
				}

				const hiddenFieldAmount = modal.querySelector('.jo-block-gift-modal__form input[name="user-funding"]');
				const customAmountValue = parseFloat(customAmountInput.value);
				hiddenFieldAmount.value = !isNaN(customAmountValue) ? customAmountValue : 0;
			});

			customAmountInput.addEventListener('input', () => {
				const numericValue = parseFloat(customAmountInput.value);
				const hiddenFieldAmount = modal.querySelector('.jo-block-gift-modal__form input[name="user-funding"]');
				hiddenFieldAmount.value = numericValue;
			});

			// == Get guest name value and trim it
			const guestNameElement = modal.querySelector('.jo-block-gift-modal__form input[name="user-name"]');
			let guestName = guestNameElement.value;

			guestNameElement.addEventListener('input', () => {
				guestName = guestNameElement.value.trim();
			});

			// == Get guest message value and trim it
			const guestMessageElement = modal.querySelector('.jo-block-gift-modal__form textarea[name="guest_message"]');
			let guestMessage = guestMessageElement.value.trim();

			guestMessageElement.addEventListener('input', () => {
				guestMessage = guestMessageElement.value.trim();
			});

			// == Build PayPal URL redirect
			const form = modal.querySelector('.jo-block-gift-modal__form');
			form.addEventListener('submit', (event) => {
				event.preventDefault();
				const selectedAmount = form.querySelector('input[name="user-funding"]').value;
				if (!selectedAmount) return;

				redirectToPaypal({
					giftId: gift.id,
					giftTitle: gift.title,
					guest_name: guestName,
					guest_message: guestMessage,
					amount: selectedAmount,
				});
			});
		}

		// === Reservation Modal Logic ===
		if (modalType === 'reservation') {
			const reserveForm = modal.querySelector('.jo-block-gift-modal.reservation form');
			let reservedByEmail = modal.querySelector('.jo-block-gift-modal__form input[name="user-email"]');
			let reservedByName = modal.querySelector('.jo-block-gift-modal__form input[name="user-name"]');
			let guestMessage = modal.querySelector('.jo-block-gift-modal__form textarea[name="guest_message"]');

			reserveForm.addEventListener('submit', (event) => {
				event.preventDefault();

				// == Trim values
				reservedByEmail = reservedByEmail.value.trim();
				reservedByName = reservedByName.value.trim();
				guestMessage = guestMessage.value.trim();

				// == Build the form data
				const formData = new FormData();
				formData.append('action', 'jourj_reserve_gift');
				formData.append('gift_id', gift.id);
				formData.append('reserved_by_name', reservedByName);
				formData.append('reserved_by_email', reservedByEmail);
				formData.append('guest_message', guestMessage);
				formData.append('mode', modalType);
				formData.append('nonce', jourj_gift_ajax.nonce);

				console.log('Form Data:', Array.from(formData.entries()));

				// == Send the form data via AJAX
				fetch(jourj_gift_ajax.ajax_url, {
					method: 'POST',
					body: formData,
					credentials: 'same-origin',
				})
					.then((res) => res.json())
					.then((json) => {
						if (json.success) {
							alert('Réservation réussie !');
							window.location.reload();
						} else {
							console.error(json.data || 'Erreur lors de la réservation.');
						}
					})
					.catch(() => {
						alert('Une erreur est survenue.');
					});
			});
		}

		/**
		 * Show the modal
		 */
		modal.classList.add('active');
		overlay.classList.add('active');
		document.body.style.overflow = 'hidden';

		const closeButton = modal.querySelector('.jo-block-gift-modal__close');
		closeButton.addEventListener('click', closeGiftModal);
		overlay.addEventListener('click', closeGiftModal);

		document.addEventListener('keydown', (event) => {
			if (event.key === 'Escape') {
				closeGiftModal();
				document.removeEventListener('keydown', closeGiftModal);
			}
		});
	}

	/**
	 * Close the modal
	 */
	function closeGiftModal() {
		const modals = document.querySelectorAll('.jo-block-gift-modal');
		const overlay = document.querySelector('.jo-block-gift-modal__overlay');

		modals.forEach((modal) => modal.classList.remove('active'));
		overlay.classList.remove('active');
		document.body.style.overflow = 'auto';
	}

	/**
	 * Redirect to PayPal
	 */
	function redirectToPaypal({ giftId, giftTitle, amount, guest_name, guest_message }) {
		const customData = JSON.stringify({
			guest_name,
			guest_message,
		});

		const params = new URLSearchParams({
			cmd: '_xclick',
			business: jourj_gift_ajax.paypal_email,
			item_number: giftId,
			item_name: `Participation pour ${giftTitle}`,
			amount: amount,
			currency_code: 'EUR',
			custom: customData,
			return: `${window.location.origin}/merci?gift_id=${giftId}`,
			notify_url: `${window.location.origin}/wp-json/jourj-gifts/v1/paypal-ipn`,
		});

		const paypalUrl = `https://www.paypal.com/cgi-bin/webscr?${params.toString()}`;
		window.location.href = paypalUrl;
	}
});
