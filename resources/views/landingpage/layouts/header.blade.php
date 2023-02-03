<header>
    <div class="header-area header-transparent">
      <div class="main-header header-sticky">
        <div class="container">
          <div class="menu-wrapper d-flex align-items-center justify-content-between">
            <div class="left-content d-flex align-items-center">
              <div class="logo mr-45">
                <a href="index.html"><h1>Job Portal</h1></a>
              </div>

              <div class="main-menu d-none d-lg-block">
                <nav>
                  <ul id="navigation">
                    <li><a href="index.html">Home</a></li>
                    <li><a href="borwse_job.html">Candidates</a></li>
                    <li><a href="borwse_job.html">About Us</a></li>
                    <li><a href="contact.html">Contact Us</a></li>
                  </ul>
                </nav>
              </div>
            </div>

            <div class="buttons">
              <ul>
                <li class="button-header">
                  <a href="{{ route('signup') }}" class="header-btn mr-10"> <i class="fas fa-phone-alt"></i>Post A Job</a>
                  <a href="{{ route('login') }}" class="btn header-btn2">Log In</a>
                </li>
              </ul>
            </div>
          </div>

          <div class="col-12">
            <div class="mobile_menu d-block d-lg-none"></div>
          </div>
        </div>
      </div>
    </div>
  </header>
