document.addEventListener('DOMContentLoaded', () => {
	const customFunding = document.querySelector('.jo-block-gift-custom-funding');

	if (!customFunding) return;

	const formToggle = customFunding.querySelector('.jo-block-gift-custom-funding__button');
	const form = customFunding.querySelector('.jo-block-gift-custom-funding__form');
	const guestName = customFunding.querySelector('.jo-block-gift-custom-funding__form--input [name="guest-name"]');
	const amount = customFunding.querySelector('.jo-block-gift-custom-funding__form--input [name="funding-amount"]');
	const guestMessage = customFunding.querySelector('.jo-block-gift-custom-funding__form--input textarea[name="guest-message"]');
	const giftId = customFunding.querySelector('.jo-block-gift-custom-funding__form input[name="gift-id"]');

	/**
	 * Toggle the custom funding form on button click
	 */
	formToggle.addEventListener('click', (event) => {
		event.preventDefault();

		// == Toggle the form visibility
		form.classList.toggle('hidden');

		// == Compute the form height
		const formHeight = form.scrollHeight + 48; // 48px (1.5rem on vertical axis) for padding
		form.style.height = form.classList.contains('hidden') ? '0px' : `${formHeight}px`;

		// == Change the button text based on the form visibility
		if (form.classList.contains('hidden')) {
			formToggle.textContent = 'Faire un don';
		} else {
			formToggle.textContent = 'Annuler';
		}
	});

	/**
	 * Ensure the amount is a number (0 decimals)
	 */
	amount.addEventListener('input', (event) => {
		const value = event.target.value.replace(/[^0-9]/g, '');
		event.target.value = value;

		// == Update the hidden field with the numeric value
		const hiddenFieldAmount = form.querySelector('input[name="user-funding"]');
		const numericValue = parseFloat(value);
		hiddenFieldAmount.value = !isNaN(numericValue) ? numericValue : 0;
	});

	/**
	 * Handle the form submission
	 */
	form.addEventListener('submit', (event) => {
		event.preventDefault();

		// == Redirect to PayPal with the custom amount
		redirectToPaypal({
			giftId: giftId.value,
			amount: parseInt(amount.value, 10),
			guestName: guestName.value,
			guestMessage: guestMessage.value,
		});
	});

	/**
	 * Redirect to PayPal
	 */
	function redirectToPaypal({ giftId, amount, guestName, guestMessage }) {
		const customData = JSON.stringify({
			guestName,
			guestMessage,
		});

		const params = new URLSearchParams({
			cmd: '_xclick',
			business: jourj_gift_custom_funding_ajax.paypal_email,
			item_number: giftId,
			item_name: `Don de ${guestName}`,
			custom: customData,
			amount: amount,
			currency_code: 'EUR',
			return: `${window.location.origin}/merci?gift_id=${giftId}`,
			notify_url: `${window.location.origin}/wp-json/jourj-gifts/v1/paypal-ipn`,
		});

		const paypalUrl = `https://www.paypal.com/cgi-bin/webscr?${params.toString()}`;
		window.location.href = paypalUrl;
	}
});
