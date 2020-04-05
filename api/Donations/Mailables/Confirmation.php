<?php

namespace Api\Donations\Mailers;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

use Api\Donations\Models\Donation;
use Api\Users\Models\User;

class Confirmation extends Mailable
{
	use SerializesModels;

	public $donation;

	/**
	 * The urls.
	 *
	 * @var string
	 */
	public $urls;

	public $subject = 'Thank you for your donation to A2 Helps!';

	/**
	 * Create a new message instance.
	 *
	 * @return void
	 */
	public function __construct(Donation $donation)
	{
		$this->donation = $donation;
	}

	/**
	 * Build the message.
	 *
	 * @return $this
	 */
	public function build()
	{
		// return $this->view('mail.donation-confirmation.text')
		return $this
			->text('mail.donation-confirmation.text')
			->from(
				'thankyou@e.a2helps.com',
				'A2 Helps'
			)
			->subject($this->subject);
	}
}
