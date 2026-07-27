@extends('layouts.app')
@section('title', 'Cookie Notice | Revelation Hour Ministries International')
@section('content')
<section class="page-hero"><div class="container"><h1>Cookie Notice</h1><p>A clear explanation of the small files used by this website.</p></div></section>
<section class="section"><div class="container content-narrow">
    <h2>Essential cookies</h2>
    <p>The website uses essential cookies to protect forms, maintain secure administrator sessions and remember basic application state. The site cannot provide these functions reliably without them.</p>
    <h2>Analytics and third-party content</h2>
    <p>Embedded videos, maps or social platforms may set their own cookies when you use them. If optional analytics or advertising tools are added later, the church should add a consent banner before enabling non-essential tracking.</p>
    <h2>Managing cookies</h2>
    <p>You can remove or block cookies through your browser settings. Blocking essential cookies may prevent login, form submission or other parts of the website from working properly.</p>
    <p><small>Last reviewed: {{ date('F Y') }}.</small></p>
</div></section>
@endsection
