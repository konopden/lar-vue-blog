@extends('app')
@section('scripts')
    <script src="https://maps.googleapis.com/maps/api/js?key={{ config('api_keys.google_api_key')}}&sensor=false"></script>
    <script src="{{ mix("js/google-map.js") }}"></script>
@endsection
@section('content')
    <section class="ftco-section contact-section px-md-4">
        <div class="container">
            <div class="row d-flex mb-5 contact-info">
                <div class="col-md-12 mb-4">
                    <h2 class="h3">Contact Information</h2>
                </div>
                <div class="w-100"></div>
                <div class="col-lg-6 col-xl-3 d-flex mb-4">
                    <div class="info bg-light p-4">
                        <p><span>Address:</span> 198 West 21th Street, Suite 721 New York NY 10016</p>
                    </div>
                </div>
                <div class="col-lg-6 col-xl-3 d-flex mb-4">
                    <div class="info bg-light p-4">
                        <p><span>Phone:</span> <a href="tel://1234567920">+ 1235 2355 98</a></p>
                    </div>
                </div>
                <div class="col-lg-6 col-xl-3 d-flex mb-4">
                    <div class="info bg-light p-4">
                        <p><span>Email:</span> <a href="mailto:info@yoursite.com">info@yoursite.com</a></p>
                    </div>
                </div>
                <div class="col-lg-6 col-xl-3 d-flex mb-4">
                    <div class="info bg-light p-4">
                        <p><span>Website</span> <a href="#">yoursite.com</a></p>
                    </div>
                </div>
            </div>
            <div class="row block-9">
                <div class="col-lg-6 d-flex">
                    <feedback></feedback>
                </div>
                <div class="col-lg-6 d-flex">
                    <div id="map" class="bg-light"></div>
                </div>
            </div>
        </div>
    </section>
@endsection
