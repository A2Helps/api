<?php

namespace Api\Codes\Mailers;

use Api\Codes\Models\Code;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DistributeCode extends Mailable
{
	use SerializesModels;

	public $code;

	/**
	 * The urls.
	 *
	 * @var string
	 */
	public $urls;

	public $subject = 'Thank you from A2 Helps';

	/**
	 * Create a new message instance.
	 *
	 * @return void
	 */
	public function __construct(Code $code)
	{
		$this->code = $code->code;
	}

	/**
	 * Build the message.
	 *
	 * @return $this
	 */
	public function build()
	{
		return $this->view('mail.code-distribute.html')
			->text('mail.code-distribute.text')
			->from(
				'thankyou@e.a2helps.com',
				'A2 Helps'
			)
			->subject($this->subject);
	}
}
