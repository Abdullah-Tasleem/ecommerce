     <!-- Brand area end -->
     </main>
     <!-- Body main wrapper end -->

     <!-- Footer area start -->
     <footer class="footer-bg">
         <div class="footer-area pt-100 pb-20">
             <div class="footer-style-4">
                 <div class="container">
                     <div class="footer-grid-3">
                         <div class="footer-widget-4">
                             <div class="footer-logo mb-35">
                                 <a href="index.html"><img src="{{ asset('assets/imgs/furniture/logo/logo-light.svg') }}"
                                         alt="image bnot found"></a>
                             </div>
                             <p>It helps designers plan out where the content will sit, the content to be written and
                                 approved.
                             </p>
                             <div class="theme-social">
                                 <a class="furniture-bg-hover" href="#"><i
                                         class="fa-brands fa-facebook-f"></i></a>
                                 <a class="furniture-bg-hover" href="#"><i class="fa-brands fa-twitter"></i></a>
                                 <a class="furniture-bg-hover" href="#"><i
                                         class="fa-brands fa-linkedin-in"></i></a>
                                 <a class="furniture-bg-hover" href="#"><i class="fa-brands fa-instagram"></i></a>
                             </div>
                         </div>
                         <div class="footer-widget-4">
                             <div class="footer-widget-title">
                                 <h4>Services</h4>
                             </div>
                             <div class="footer-link">
                                 <ul>
                                     @guest
                                         <li><a href="{{ route('login') }}">Log In</a></li>
                                     @endguest
                                     <li><a href="error.html">Return Policy</a></li>
                                     <li><a href="error.html">Privacy policy</a></li>
                                     <li><a href="faq.html">Shopping FAQs</a></li>
                                 </ul>
                             </div>
                         </div>
                         <div class="footer-widget-4">
                             <div class="footer-widget-title">
                                 <h4>Company</h4>
                             </div>
                             <div class="footer-link">
                                 <ul>
                                     <li><a href="{{ route('home') }}">Home</a></li>
                                     <li><a href="{{ route('about') }}">About us </a></li>
                                     <li><a href="{{ route('blogs.index') }}">Blog</a></li>
                                     <li><a href="{{ route('contact') }}">Contact us</a></li>
                                 </ul>
                             </div>
                         </div>
                         <div class="footer-widget footer-col-4">
                             <div class="footer-widget-title">
                                 <h4>Contact</h4>
                             </div>
                             <div class="footer-info mb-35">
                                 <p class="w-75">4517 Washington Ave. Manchester, Kentucky 39495</p>
                                 <div class="footer-info-item d-flex align-items-start pb-15 pt-15">
                                     <div class="footer-info-icon mr-20">
                                         <span> <i class="fa-solid fa-location-dot furniture-icon"></i></span>
                                     </div>
                                     <div class="footer-info-text">
                                         <a class="furniture-clr-hover" target="_blank"
                                             href="https://www.google.com/maps/place/Orville+St,+La+Presa,+CA+91977,+USA/@32.7092048,-117.0082772,17z/data=!3m1!4b1!4m5!3m4!1s0x80d9508a9aec8cd1:0x72d1ac1c9527b705!8m2!3d32.7092003!4d-117.0060885">711-2880
                                             Nulla St.</a>
                                     </div>
                                 </div>
                                 <div class="footer-info-item d-flex align-items-start">
                                     <div class="footer-info-icon mr-20">
                                         <span><i class="fa-solid fa-phone furniture-icon"></i></span>
                                     </div>
                                     <div class="footer-info-text">
                                         <a class="furniture-clr-hover" href="tel:012-345-6789">+964 742 44 763</a>
                                         <p>Mon - Sat: 9 AM - 5 PM</p>
                                     </div>
                                 </div>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
         <div class="container">
             <div class="footer-copyright-area b-t">
                 <div class="footer-copyright-wrapper">
                     <div class="footer-copyright-text">
                         <p class="mb-0">© All Copyright 2024 by <a target="_blank" class="furniture-clr-hover"
                                 href="#">Addina</a></p>
                     </div>
                     <div class="footer-payment d-flex align-items-center gap-2">
                         <div class="footer-payment-item mb-0">
                             <div class="footer-payment-thumb">
                                 <img src="assets/imgs/icons/payoneer.png" alt="">
                             </div>
                         </div>
                         <div class="footer-payment-item mb-0">
                             <div class="footer-payment-thumb">
                                 <img src="assets/imgs/icons/maser.png" alt="">
                             </div>
                         </div>
                         <div class="footer-payment-item">
                             <div class="footer-payment-thumb">
                                 <img src="assets/imgs/icons/paypal.png" alt="">
                             </div>
                         </div>
                     </div>
                     <div class="footer-conditions">
                         <ul>
                             <li><a class="furniture-clr-hover" href="#">Terms & Condition</a></li>
                             <li><a class="furniture-clr-hover" href="#">Privacy Policy</a></li>
                         </ul>
                     </div>
                 </div>
             </div>
         </div>
     </footer>
     <!-- Footer area end -->

     <!-- JS here -->
     <script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>
     <script src="{{ asset('assets/js/waypoints.min.js') }}"></script>
     <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
     <script src="{{ asset('assets/js/meanmenu.min.js') }}"></script>
     <script src="{{ asset('assets/js/swiper.min.js') }}"></script>
     <script src="{{ asset('assets/js/slick.min.js') }}"></script>
     <script src="{{ asset('assets/js/magnific-popup.min.js') }}"></script>
     <script src="{{ asset('assets/js/counterup.js') }}"></script>
     <script src="{{ asset('assets/js/wow.js') }}"></script>
     <script src="{{ asset('assets/js/ajax-form.js') }}"></script>
     <script src="{{ asset('assets/js/beforeafter.jquery-1.0.0.min.js') }}"></script>
     <script src="{{ asset('assets/js/main.js') }}"></script>
     <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
     @stack('scripts')
     <script>
         document.addEventListener('DOMContentLoaded', function() {
             const input = document.getElementById('header-search');
             const box = document.getElementById('search-dropdown');

             let controller;

             input.addEventListener('input', async function(e) {
                 const q = e.target.value.trim();

                 if (q.length < 2) {
                     hideDropdown();
                     return;
                 }

                 if (controller) controller.abort();
                 controller = new AbortController();

                 try {
                     // ✅ Check current URL
                     const currentPath = window.location.pathname;
                     let searchUrl = "";

                     // Match /blogs or /blogs/slug
                     if (currentPath.startsWith("/blogs")) {
                         searchUrl = "{{ route('blogs.search') }}";
                     } else {
                         searchUrl = "{{ route('search.suggest') }}"; // Default (product search)
                     }

                     const res = await fetch(searchUrl + "?q=" + encodeURIComponent(q), {
                         signal: controller.signal
                     });

                     const data = await res.json();

                     if (!data.length) {
                         showDropdown('<div class="dropdown-item text-muted">No results</div>');
                         return;
                     }

                     const html = data.map(item => `
                <a href="${item.url}" class="dropdown-item d-flex align-items-center">
                    ${item.thumb ? `<img src="${item.thumb}" width="32" height="32" class="me-2 rounded">` : ''}
                    <span>${highlight(item.name, q)}</span>
                </a>
            `).join('');

                     showDropdown(html);
                 } catch (err) {
                     if (err.name !== 'AbortError') {
                         console.error(err);
                     }
                 }
             });

             document.addEventListener('click', function(e) {
                 if (!e.target.closest('.header-search')) hideDropdown();
             });

             function showDropdown(html) {
                 box.innerHTML = html;
                 box.classList.remove('d-none');
                 box.classList.add('show');
                 box.style.display = 'block';
             }

             function hideDropdown() {
                 box.innerHTML = '';
                 box.classList.add('d-none');
                 box.classList.remove('show');
                 box.style.display = 'none';
             }

             function highlight(text, q) {
                 const re = new RegExp('(' + escapeRegExp(q) + ')', 'ig');
                 return text.replace(re, '<strong>$1</strong>');
             }

             function escapeRegExp(str) {
                 return str.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
             }
         });
     </script>
     <script>
         document.addEventListener('DOMContentLoaded', function() {
             const quickViewButtons = document.querySelectorAll('.quick-view-btn');

             quickViewButtons.forEach(button => {
                 button.addEventListener('click', function() {
                     const productId = this.getAttribute('data-id');

                     // Modal element
                     const modalEl = document.getElementById('productQuickViewModal');

                     // Close modal if already open
                     const existingModal = bootstrap.Modal.getInstance(modalEl);
                     if (existingModal) {
                         existingModal.hide();
                     }

                     // Clear previous content
                     document.getElementById('quickViewContent').innerHTML = '';

                     fetch(`/product/quick-view/${productId}`)
                         .then(response => response.text())
                         .then(data => {
                             document.getElementById('quickViewContent').innerHTML = data;

                             const modal = new bootstrap.Modal(modalEl);
                             modal.show();
                         })
                         .catch(error => {
                             console.error('Error loading quick view:', error);
                         });
                 });
             });
         });

         document.addEventListener('hidden.bs.modal', function() {
             // Remove modal-open class and backdrop manually
             document.body.classList.remove('modal-open');

             // Reset overflow style to allow scrolling
             document.body.style.overflow = '';

             const backdrop = document.querySelector('.modal-backdrop');
             if (backdrop) {
                 backdrop.remove();
             }
         });

         // 🛒 AJAX Add to Cart in Modal
         document.addEventListener('submit', function(e) {
             if (e.target.classList.contains('quickview-cart-form')) {
                 e.preventDefault();

                 const form = e.target;
                 const formData = new FormData(form);
                 const actionUrl = form.getAttribute('action');

                 fetch(actionUrl, {
                         method: 'POST',
                         headers: {
                             'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                         },
                         body: formData
                     })
                     .then(response => {
                         if (response.ok) {
                             // Modal close
                             const modalEl = document.getElementById('productQuickViewModal');
                             const modalInstance = bootstrap.Modal.getInstance(modalEl);
                             if (modalInstance) modalInstance.hide();

                             // Show a success message (optional)
                             alert('Product added to cart!');
                         } else {
                             alert('Failed to add to cart');
                         }
                     })
                     .catch(error => {
                         console.error('Error adding to cart:', error);
                     });
             }
         });

         document.addEventListener('hidden.bs.modal', function() {
             document.body.classList.remove('modal-open');
             document.body.style.overflow = '';
             const backdrop = document.querySelector('.modal-backdrop');
             if (backdrop) backdrop.remove();
         });
     </script>
     </body>

     </html>
