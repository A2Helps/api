@extends('layouts.base')

@section('title', 'Thank you from A2 Helps')

@section('body')

<br>
<h3><strong id="docs-internal-guid-3b3e7376-7fff-7c1d-6c68-7cd70630b86a">Your Gift Cards Await!</strong></h3>

<p dir="ltr"><strong id="docs-internal-guid-3b3e7376-7fff-7c1d-6c68-7cd70630b86a">
We're happy to share that you were selected to receive a gift card from A2 Helps. We sent you
an email with instruction to redeem your gift card to one (or several) of over 20
participating local business in Ann Arbor
</strong></p>

<p dir="ltr"><strong id="docs-internal-guid-3b3e7376-7fff-7c1d-6c68-7cd70630b86a">
This is a reminder that you have yet to redeem your code.
If you do not redeem your code within 30 days, we will be giving the gift card to another
healthcare worker on the front lines of COVID19.
</strong></p>

<p dir="ltr"><strong id="docs-internal-guid-3b3e7376-7fff-7c1d-6c68-7cd70630b86a">
To receive your gift card, please click the button below or naviate here: <a href="{{ sprintf('%s/v/%s', config('app.web.url'), $code) }}">{{ sprintf('%s/v/%s', config('app.web.url'), $code) }}</a>.
</strong></p>

<p dir="ltr"><strong id="docs-internal-guid-3b3e7376-7fff-7c1d-6c68-7cd70630b86a">
Thank you for your service, and we hope you enjoy your gift!
</strong></p>

<p dir="ltr"><strong id="docs-internal-guid-0f64de91-7fff-e94e-2869-aa477fbe02ec">- The A2 Helps Team&nbsp;</strong></p>

<br>
&nbsp;
@endsection

@section('button')
<table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnButtonBlock" style="min-width:100%;">
    <tbody class="mcnButtonBlockOuter">
        <tr>
            <td style="padding-top:0; padding-right:18px; padding-bottom:18px; padding-left:18px;" valign="top" align="center" class="mcnButtonBlockInner">
                <table border="0" cellpadding="0" cellspacing="0" class="mcnButtonContentContainer" style="border-collapse: separate !important;border-radius: 3px;background-color: #F1A207;">
                    <tbody>
                        <tr>
                            <td align="center" valign="middle" class="mcnButtonContent" style="font-family: Helvetica; font-size: 18px; padding: 18px;">
							<a class="mcnButton " title="Share Now" href="{{ sprintf('%s/v/%s', config('app.web.url'), $code) }}" target="_blank" style="font-weight: bold;letter-spacing: -0.5px;line-height: 100%;text-align: center;text-decoration: none;color: #FFFFFF;">Claim Now</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>
@endsection
