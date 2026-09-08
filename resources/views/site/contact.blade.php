@extends('layouts.site')

@section('title')
    {{ __('contact_us') }}
@endsection

@section('content')

<!-- 🔸 مسار التنقل (breadcrumb) -->
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="breadcrumb__text">
                    <h2>{{ __('contact_us') }}</h2>
                    <div class="breadcrumb__option">
                        <a href="{{ route('site.home') }}">{{ __('home') }}</a>
                        <span>{{ __('contact_us') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 🔸 معلومات الاتصال -->
<section class="contact spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-6 text-center">
                <div class="contact__widget">
                    <span class="icon_phone"></span>
                    <h4>{{ __('phone') }}</h4>
                    <p>034492258</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 text-center">
                <div class="contact__widget">
                    <span class="icon_pin_alt"></span>
                    <h4>{{ __('address') }}</h4>
                    <p>60-49 Alex 11378 Alex</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 text-center">
                <div class="contact__widget">
                    <span class="icon_clock_alt"></span>
                    <h4>{{ __('open_time') }}</h4>
                    <p>10:00 AM - 11:00 PM</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 text-center">
                <div class="contact__widget">
                    <span class="icon_mail_alt"></span>
                    <h4>{{ __('email') }}</h4>
                    <p>diaa@gmail.com</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 🔸 خريطة الموقع -->
<div class="map">
    <iframe 
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d110496.27419538998!2d29.8943783!3d31.2005538!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x14f5c5d9a92b60d3%3A0x2d8b5717d27d3b6!2z2KfZhNiz2YrYp9mK2YbYqSDZhdmE2YXZhtmH2Kc!5e0!3m2!1sar!2seg!4v1711123456789" 
        height="500" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0">
    </iframe>
    <div class="map-inside">
        <i class="icon_pin"></i>
        <div class="inside-widget">
            <h4>{{ __('mahatet_elraml') }}</h4>
            <ul>
                <li>{{ __('phone') }}: 034492258</li>
                <li>{{ __('address') }}: {{ __('station_address') }}</li>
            </ul>
        </div>
    </div>
</div>

@endsection
