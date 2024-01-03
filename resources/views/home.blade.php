@extends('layouts.main')

@section('container')

<main>
    <div class="position-relative overflow-hidden p-3 p-md-5 text-center bg-body-tertiary">
        <div class="row">
            <div class="col-lg-6 col-md-12 p-lg-5 mx-auto my-5">
                <h1 class="display-3 fw-bold">DALAPA Mobile Apps</h1>
                <h3 class="fw-normal text-muted mb-3">DALAPA streamlines material reporting for efficient IndiHome mass
                    disruption repairs.</h3>
            </div>
            <div class="col-lg-6 col-md-12 p-lg-5 mx-auto my-5">
              <div class="bg-body-tertiary me-md-3 px-3 px-md-5 text-center overflow-hidden">
                <img src="{{ asset('storage/images/mobile.png') }}" class="bg-body shadow-sm mx-auto" style="width:80%;border-radius: 30px;" alt="" srcset="">
                  {{-- <div class="bg-body shadow-sm mx-auto"
                      style="width: 80%; height: 300px; border-radius: 21px 21px 0 0;">
                  </div> --}}
              </div>
          </div>
        </div>
    </div>
</main>

<footer class="container py-5">
    <div class="row">
        <div class="col-12 col-md">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor"
                stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="d-block mb-2" role="img"
                viewBox="0 0 24 24">
                <title>Product</title>
                <circle cx="12" cy="12" r="10" />
                <path
                    d="M14.31 8l5.74 9.94M9.69 8h11.48M7.38 12l5.74-9.94M9.69 16L3.95 6.06M14.31 16H2.83m13.79-4l-5.74 9.94" />
            </svg>
            <small class="d-block mb-3 text-body-secondary">&copy; 2024</small>
        </div>
        <div class="col-6 col-md">
            <h5>Features</h5>
            <ul class="list-unstyled text-small">
                <li><a class="link-secondary text-decoration-none" href="#">Cool stuff</a></li>
                <li><a class="link-secondary text-decoration-none" href="#">Random feature</a></li>
                <li><a class="link-secondary text-decoration-none" href="#">Team feature</a></li>
                <li><a class="link-secondary text-decoration-none" href="#">Stuff for developers</a></li>
                <li><a class="link-secondary text-decoration-none" href="#">Another one</a></li>
                <li><a class="link-secondary text-decoration-none" href="#">Last time</a></li>
            </ul>
        </div>
        <div class="col-6 col-md">
            <h5>Resources</h5>
            <ul class="list-unstyled text-small">
                <li><a class="link-secondary text-decoration-none" href="#">Resource name</a></li>
                <li><a class="link-secondary text-decoration-none" href="#">Resource</a></li>
                <li><a class="link-secondary text-decoration-none" href="#">Another resource</a></li>
                <li><a class="link-secondary text-decoration-none" href="#">Final resource</a></li>
            </ul>
        </div>
        <div class="col-6 col-md">
            <h5>Resources</h5>
            <ul class="list-unstyled text-small">
                <li><a class="link-secondary text-decoration-none" href="#">Business</a></li>
                <li><a class="link-secondary text-decoration-none" href="#">Education</a></li>
                <li><a class="link-secondary text-decoration-none" href="#">Government</a></li>
                <li><a class="link-secondary text-decoration-none" href="#">Gaming</a></li>
            </ul>
        </div>
        <div class="col-6 col-md">
            <h5>About</h5>
            <ul class="list-unstyled text-small">
                <li><a class="link-secondary text-decoration-none" href="#">Team</a></li>
                <li><a class="link-secondary text-decoration-none" href="#">Locations</a></li>
                <li><a class="link-secondary text-decoration-none" href="#">Privacy</a></li>
                <li><a class="link-secondary text-decoration-none" href="#">Terms</a></li>
            </ul>
        </div>
    </div>
</footer>
<script src="/js/bootstrap.bundle.min.js"></script>

@endsection
