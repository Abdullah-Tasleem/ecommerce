@extends('frontend.layout.main')
@section('section')
   <!-- Body main wrapper start -->
   <main>

      <!-- Breadcrumb area start  -->
      <div class="breadcrumb__area theme-bg-1 p-relative z-index-11 pt-95 pb-95">
         <div class="breadcrumb__thumb" data-background="assets/imgs/bg/breadcrumb-bg.jpg"></div>
         <div class="container">
            <div class="row justify-content-center">
               <div class="col-xxl-12">
                  <div class="breadcrumb__wrapper text-center">
                     <h2 class="breadcrumb__title">About us</h2>
                     <div class="breadcrumb__menu">
                        <nav>
                           <ul>
                              <li><span><a href="{{ route('home') }}">Home</a></span></li>
                              <li><span>About Us</span></li>
                           </ul>
                        </nav>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- Breadcrumb area start  -->

      <!-- About area start -->
      <section class="about-area pt-120 pb-120">
         <div class="container">
            <div class="row g-4">
               <div class="col-xxl-6 col-xl-6 col-lg-6">
                  <div class="wow  fadeInRight animated" data-wow-delay="0.3s">
                     <div class="mb-20">
                        <span class="mb-15" style="color: #B18B5E;">WE DESIGN FURNITURE</span>
                        <h3>Our Core Divisions</h3>
                     </div>
                     <p>Ut leo. Vivamus aliquet elit ac nisl. Aenean leo ligula, porttitor eu, consequat vitae, eleifend
                        ac enim. Sed cursus
                        turpis vitae tortor. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere
                        cubilia Curae; Fusce id</p>
                     <div class="bd-skill__progress mt-40 mb-60">
                        <div class="bd-progress__skill-item fix">
                           <h5>Furniture</h5>
                           <div class="progress">
                              <div class="progress-bar wow slideInLeft" data-wow-duration="1s" data-wow-delay=".3s"
                                 role="progressbar" data-width="70%" aria-valuenow="25" aria-valuemin="0"
                                 aria-valuemax="100"
                                 style="width: 70%; visibility: visible; animation-duration: 1s; animation-delay: 0.3s; animation-name: slideInLeft;">
                              </div>
                           </div>
                           <span class="progress-count">70%</span>
                        </div>
                        <div class="bd-progress__skill-item fix">
                           <h5>Handmade</h5>
                           <div class="progress">
                              <div class="progress-bar wow slideInLeft" data-wow-duration="1s" data-wow-delay=".3s"
                                 role="progressbar" data-width="52%" aria-valuenow="25" aria-valuemin="0"
                                 aria-valuemax="100"
                                 style="width: 52%; visibility: visible; animation-duration: 1s; animation-delay: 0.3s; animation-name: slideInLeft;">
                              </div>
                           </div>
                           <span class="progress-count">52%</span>
                        </div>
                        <div class="bd-progress__skill-item fix">
                           <h5>Crafts</h5>
                           <div class="progress">
                              <div class="progress-bar wow slideInLeft" data-wow-duration="1.5s" data-wow-delay=".3s"
                                 role="progressbar" data-width="80%" aria-valuenow="25" aria-valuemin="0"
                                 aria-valuemax="100"
                                 style="width: 80%; visibility: visible; animation-duration: 1s; animation-delay: 0.3s; animation-name: slideInLeft;">
                              </div>
                           </div>
                           <span class="progress-count">80%</span>
                        </div>
                     </div>
                     <img class="w-100" src="assets/imgs/furniture/about/about-image2.jpg" alt="">
                  </div>
               </div>
               <div class="col-xxl-6 col-xl-6 col-lg-6">
                  <img class="w-100 pl-50" src="assets/imgs/furniture/about/about-image1.jpg" alt="">
               </div>
            </div>
         </div>
      </section>
      <!-- About area end -->

      <!-- About video area start -->
      <div class="postbox__thumb postbox__video w-img p-relative">
         <a href="blog-details.html">
            <img src="assets/imgs/furniture/about/about-video-image.jpg" alt="image">
         </a>
         <a href="https://www.youtube.com/watch?v=YkfPITD2C8Y" class="play-btn pulse-btn popup-video"><i
               class="fas fa-play"></i></a>
      </div>
      <!-- About video area end -->

      <!-- Support area start -->
         @guest
        <section class="support-area section-space pb-3">
            <div class="container text-center">
                <div class="row g-5 justify-content-center">
                    <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6">
                        <div class="support-item">
                            <div class="support-content">
                                <h3>Exclusive offers for you</h3>
                                <p>Get weekly deals, valuable health information and more.</p>
                                <a class="join-btn furniture-btn" href="{{ route('login') }}">
                                    Sign up <span><i class="fa-regular fa-angle-right"></i></span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6">
                        <div class="support-item is-light-yellow">
                            <div class="support-content">
                                <h3>Join Our Community</h3>
                                <p>Get weekly deals, valuable health information and more.</p>
                                <a class="join-btn furniture-btn" href="{{ route('register') }}">
                                    Join FREE now <span><i class="fa-regular fa-angle-right"></i></span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endguest
      <!-- Support area end -->

   </main>
   <!-- Body main wrapper end -->
@endsection
