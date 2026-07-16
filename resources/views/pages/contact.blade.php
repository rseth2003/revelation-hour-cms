@extends('layouts.app')

@section('title', 'Contact and Prayer | Revelation Hour Ministries International')

@section('content')
<section class="page-hero">
<div class="container">
<p class="eyebrow">Connect With Us</p>
<h1>We would love to hear from you</h1>
<p>Contact the church or share a prayer request with our prayer team.</p>
</div>
</section>

<section class="section">
<div class="container contact-page-grid">
<div>
<p class="eyebrow">Church Contact</p>
<h2 class="section-title-left">Revelation Hour Ministries International</h2>
<div class="contact-card-list">
<article><strong>Location</strong><p>Valley Road, Canaansite Estate, Nakwero Gayaza</p></article>
<article><strong>Telephone</strong><p><a href="tel:+256774328127">+256 774 328 127</a><br><a href="tel:+256784537003">+256 784 537 003</a></p></article>
</div>
</div>

<form class="public-form" method="POST" action="{{ route('prayer-requests.store') }}">
@csrf
<h2>Send a prayer request</h2>
<p>Your request will be handled privately by the church prayer team.</p>

@if(session('prayer_success'))
<div class="prayer-success">{{ session('prayer_success') }}</div>
@endif

@if($errors->any())
<div class="prayer-errors"><strong>Please correct the form:</strong><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
@endif

<label>Full name<input type="text" name="name" value="{{ old('name') }}" placeholder="Optional when anonymous"></label>
<div class="public-form-two">
<label>Email<input type="email" name="email" value="{{ old('email') }}" placeholder="Optional"></label>
<label>Phone<input type="tel" name="phone" value="{{ old('phone') }}" placeholder="Optional"></label>
</div>

<label>Prayer category
<select name="category" required>
<option value="">Choose a category</option>
@foreach(\App\Models\PrayerRequest::CATEGORIES as $category)
<option value="{{ $category }}" @selected(old('category') === $category)>{{ $category }}</option>
@endforeach
</select>
</label>

<label>Prayer request<textarea name="request_text" rows="7" required>{{ old('request_text') }}</textarea></label>

<label class="public-checkbox"><input type="checkbox" name="is_anonymous" value="1" @checked(old('is_anonymous'))><span>Keep this prayer request anonymous</span></label>
<label class="public-checkbox"><input type="checkbox" name="allow_follow_up" value="1" @checked(old('allow_follow_up'))><span>The church may contact me for prayer follow up</span></label>

<button class="btn btn-primary" type="submit">Submit Prayer Request</button>
</form>
</div>
</section>
@endsection
