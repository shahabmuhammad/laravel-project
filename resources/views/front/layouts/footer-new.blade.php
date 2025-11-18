  <!-- ===== FOOTER ===== -->
  <footer class="footer bg-primary-custom text-light pt-5 pb-3">
      <div class="container">
          <div class="row ">
              <!-- Quick Links -->
              <div class="col-6 col-md-3">
                  <h6 class="fw-bold text-white mb-3">Quick Links</h6>
                  <ul class="list-unstyled small">
                      <li class="mb-2"><a href="{{ url('/') }}" class="footer-link">Home</a></li>
                      <li class="mb-2"><a href="{{ route('front.browse') }}" class="footer-link">Browse</a></li>
                      <li class="mb-2"><a href="{{ route('front.publications') }}"
                              class="footer-link">Publications</a></li>
                      <li class="mb-2"><a href="{{ route('front.about') }}" class="footer-link">About Us</a></li>
                  </ul>
              </div>

              <!-- Resources -->
              <div class="col-6 col-md-3">
                  <h6 class="fw-bold text-white mb-3">Resources</h6>
                  <ul class="list-unstyled small">
                      <li class="mb-2"><a href="#" class="footer-link">Help Center</a></li>
                      <li class="mb-2"><a href="#" class="footer-link">FAQs</a></li>
                      <li class="mb-2"><a href="#" class="footer-link">Privacy Policy</a></li>
                      <li class="mb-2"><a href="#" class="footer-link">Terms of Service</a></li>
                  </ul>
              </div>

              <!-- Contact -->
              <div class="col-6 col-md-3">
                  <h6 class="fw-bold text-white mb-3">Contact</h6>
                  <p class="small mb-2">
                      <i class="bi bi-envelope me-2"></i>
                      <a href="mailto:info@repository.org" class="footer-link">info@repository.org</a>
                  </p>
                  <p class="small mb-0">
                      <i class="bi bi-telephone me-2"></i>
                      <a href="tel:+123456789" class="footer-link">+123 456 789</a>
                  </p>
              </div>

              <!-- Follow Us -->
              <div class="col-6 col-md-3">
                  <h6 class="fw-bold text-white mb-3">Follow Us</h6>
                  <div class="d-flex gap-2">
                      <a href="#" class="footer-social" aria-label="Facebook" title="Follow us on Facebook">
                          <i class="bi bi-facebook"></i>
                      </a>
                      <a href="#" class="footer-social" aria-label="Twitter" title="Follow us on Twitter">
                          <i class="bi bi-twitter"></i>
                      </a>
                      <a href="#" class="footer-social" aria-label="LinkedIn" title="Follow us on LinkedIn">
                          <i class="bi bi-linkedin"></i>
                      </a>
                      <a href="#" class="footer-social" aria-label="GitHub" title="Follow us on GitHub">
                          <i class="bi bi-github"></i>
                      </a>
                  </div>
              </div>
          </div>

          <hr class="mt-4 mb-3 text-light opacity-25">
          <div class="text-center small">
              <p class="mb-0">&copy; {{ date('Y') }} Research Repository | All Rights Reserved</p>
          </div>
      </div>
  </footer>
