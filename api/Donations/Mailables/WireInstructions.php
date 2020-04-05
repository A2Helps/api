<?php

namespace Api\Donations\Mailers;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

use Api\Donations\Models\Donation;
use Api\Users\Models\User;
use Illuminate\Support\Facades\Log;

class WireInstructions extends Mailable
{
	use SerializesModels;

	public $donation;

	/**
	 * The urls.
	 *
	 * @var string
	 */
	public $urls;

	public $subject = 'WIP | A2 Helps - Wire Instructions';

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
		Log::debug('built instructions');

		// return $this->view('mail.wire-instructions.html')
		return $this
			->text('mail.wire-instructions.text')
			->from(
				'thankyou@e.a2helps.com',
				'A2 Helps'
			)
			->to($this->donation->email)
			->subject($this->subject);
	}
}
