@extends('layouts.base')

@section('title', 'Thank you from A2 Helps')

@section('body')

<br>
<h3><strong id="docs-internal-guid-3b3e7376-7fff-7c1d-6c68-7cd70630b86a">Thank you from A2 Helps! </strong></h3>

<p dir="ltr"><strong id="docs-internal-guid-3b3e7376-7fff-7c1d-6c68-7cd70630b86a">
	Welcome to the A2 Helps family! You are a hero in our community and this is a small token of our appreciation for the work you do on the front lines of this crisis every day.
</strong></p>

<p dir="ltr"><strong id="docs-internal-guid-3b3e7376-7fff-7c1d-6c68-7cd70630b86a">
	You can claim your $100 in gift cards to be used at one or more of our participating local restaurants and retail stores.
</strong></p>

<p dir="ltr"><strong id="docs-internal-guid-3b3e7376-7fff-7c1d-6c68-7cd70630b86a">
	This is a one-time redeemable code. If there is someone in your organization you’d like to recognize with this gift, you may choose to forward this email to them rather than redeeming the code yourself.
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
