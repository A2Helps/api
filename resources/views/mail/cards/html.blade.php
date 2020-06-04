@extends('layouts.base')

@section('title', 'Your cards have arrived! | A2 Helps')

@section('body')
<h3><strong id="docs-internal-guid-3b3e7376-7fff-7c1d-6c68-7cd70630b86a">Your cards have arrived! </strong></h3>

<p dir="ltr"><strong id="docs-internal-guid-3b3e7376-7fff-7c1d-6c68-7cd70630b86a">
Hello
</strong><br>
<p dir="ltr"><strong id="docs-internal-guid-3b3e7376-7fff-7c1d-6c68-7cd70630b86a">
Below you will find the codes for the gift cards
you selected on a2helps.com.<br>
<br>
We thank you for the
incredible service you’ve given to our community
and hope you will enjoy our token of appreciation.<br>
<br>
We hope you will also find enjoyment in knowing that
when you use your gift cards you’ll be helping to support
local businesses that have been impacted by COVID19.<br>
</strong><br>
</p>

@foreach ($data as $m)

	<p dir="ltr" style="font-size: 18px; text-align: center;">
		<strong id="docs-internal-guid-3b3e7376-7fff-7c1d-6c68-7cd70630b86a">
			${{ $m['amount'] }} | {{ $m['merchant'] }}
		</strong><br>
		<span class="white-space: nowrap;">{{ $m['number'] }}</span><br>
		<br>
	</p>

@endforeach

<p dir="ltr">
<strong id="docs-internal-guid-0f64de91-7fff-e94e-2869-aa477fbe02ec">
We’ll be putting together some videos of our recipients
to show the reach of our efforts. If you’d like to be
included, send us a photo or video with an item you
purchased with your gift card or with a simple thank you.
This is not required but we hope to use these videos to
raise more money, amplify A2 Helps, and ultimately serve
more healthcare workers and local businesses.<br>
<br>
Thank you again for your service.<br>
</strong>
</p>

<p dir="ltr"><strong id="docs-internal-guid-0f64de91-7fff-e94e-2869-aa477fbe02ec">- The A2 Helps Team&nbsp;</strong></p>

@endsection
