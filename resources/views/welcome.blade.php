<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Multi-Tenant Flat & Billing Management — Landing</title>

  <!-- Tailwind CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    // Tailwind config for gradient and fonts
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            navy: '#071021',
            accentFrom: '#0ea5b7',
            accentTo: '#2563eb'
          },
          backgroundImage: {
            'blue-teal': 'linear-gradient(90deg, rgba(37,99,235,1) 0%, rgba(14,165,183,1) 100%)'
          }
        }
      }
    }
  </script>

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;800&family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <style>
    :root { --glass: rgba(255,255,255,0.06); }
    html,body { font-family: 'Inter', system-ui, -apple-system, 'Segoe UI', Roboto, 'Poppins', sans-serif; }
    .gradient-accent { background: linear-gradient(90deg, rgba(37,99,235,1) 0%, rgba(14,165,183,1) 100%); }
    .glass { background: linear-gradient(180deg, rgba(255,255,255,0.04), rgba(255,255,255,0.02)); backdrop-filter: blur(8px); border: 1px solid rgba(255,255,255,0.06); }
    .glow-btn { box-shadow: 0 8px 30px rgba(14,165,183,0.12); }
    .floating-mock { transform: translateY(0); transition: transform .9s cubic-bezier(.2,.9,.2,1); }
    .floating-mock.up { transform: translateY(-10px); }
    /* subtle fade-in utility */
    .reveal { opacity: 0; transform: translateY(10px); transition: opacity .7s ease, transform .7s ease; }
    .reveal.visible { opacity: 1; transform: translateY(0); }
    /* testimonials carousel */
    .carousel-item { display: none; }
    .carousel-item.active { display: block; }

    /* small tweaks */
    @media (max-width: 640px) {
      .desktop-only { display: none; }
    }
  </style>

</head>
<body class="bg-gradient-to-br from-navy via-[#071730] to-[#08122a] text-slate-100 leading-relaxed">

  <!-- NAV -->
  <header class="max-w-7xl mx-auto px-6 py-6 flex items-center justify-between">
    <a href="#" class="flex items-center gap-3">
      <div class="w-10 h-10 gradient-accent rounded-lg flex items-center justify-center shadow-lg">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none"><path d="M3 11.5L12 4l9 7.5V20a1 1 0 0 1-1 1h-5v-6H9v6H4a1 1 0 0 1-1-1v-8.5z" fill="white" opacity=".95"/></svg>
      </div>
      <div>
        <div class="text-white font-semibold">FlatFlow</div>
        <div class="text-slate-400 text-xs">Multi‑Tenant Billing</div>
      </div>
    </a>
    <nav class="hidden md:flex items-center gap-6 text-slate-300">
      <a href="#features" class="hover:text-white transition">Features</a>
      <a href="#pricing" class="hover:text-white transition">Pricing</a>
      <a href="#testimonials" class="hover:text-white transition">Testimonials</a>
      <a href="#demo" class="hover:text-white transition">Demo</a>


    @if (Route::has('login'))
      @auth
        <a href="{{ url('/home') }}" class="ml-4 px-4 py-2 rounded-md gradient-accent glow-btn text-sm font-semibold">Dashboard</a>
      @else
        <a href="{{ route('login') }}" class="ml-4 px-4 py-2 rounded-md bg-white/10 hover:bg-white/20 text-sm font-semibold transition">Sign In</a>
        @if (Route::has('register'))
        <a href="{{ route('register') }}" class="ml-2 px-4 py-2 rounded-md border border-white/10 text-sm font-semibold hover:bg-white/5 transition">Register</a>
        @endif
      @endauth
    @endif
    
    </nav>
    <div class="md:hidden">
      <!-- mobile menu button (non-functional in this mock) -->
      <button class="p-2 rounded-md bg-white/5">☰</button>
    </div>
  </header>

  <!-- HERO -->
  <section class="max-w-7xl mx-auto px-6 py-20 lg:py-28 flex flex-col lg:flex-row items-center gap-12">
    <div class="lg:w-6/12">
      <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold leading-tight mb-4">Manage Flats & Billing <span class="text-transparent bg-clip-text gradient-accent">Effortlessly</span></h1>
      <p class="text-slate-300 text-lg md:text-xl mb-8">A unified, modern SaaS platform to manage tenants, automate bills, collect rent & track expenses — all in one secure dashboard.</p>

      <div class="flex gap-4 flex-wrap">
        <a href="#demo" class="inline-flex items-center gap-3 px-6 py-3 rounded-full bg-gradient-to-r from-[#06b6d4] to-[#2563eb] text-white font-semibold shadow-lg glow-btn hover:scale-105 transition-transform">Get Started</a>
        <a href="#features" class="inline-flex items-center gap-2 px-5 py-3 rounded-full border border-white/10 text-slate-200 hover:bg-white/5 transition">Explore Features</a>
      </div>

      <div class="mt-8 grid grid-cols-2 md:grid-cols-3 gap-3">
        <div class="text-center">
          <div class="text-2xl font-bold">1.2k</div>
          <div class="text-sm text-slate-400">Active Tenants</div>
        </div>
        <div class="text-center">
          <div class="text-2xl font-bold">$48k</div>
          <div class="text-sm text-slate-400">Rent Collected</div>
        </div>
        <div class="text-center">
          <div class="text-2xl font-bold">99.9%</div>
          <div class="text-sm text-slate-400">Uptime</div>
        </div>
      </div>
    </div>

    <!-- Dashboard Preview Mockup -->
    <div class="lg:w-6/12 flex justify-center lg:justify-end">
      <div class="relative w-96 md:w-[520px] h-[360px] rounded-2xl glass p-5 shadow-2xl reveal" id="dashboardMock">
        <div class="absolute -right-12 -top-10 w-56 h-56 bg-gradient-to-tr from-[#0ea5b7]/80 to-[#2563eb]/60 rounded-full blur-3xl opacity-60 animate-pulse"></div>
        <div class="flex items-start gap-4">
          <div class="w-2/3">
            <div class="h-4 bg-white/10 rounded-full w-3/4 mb-4"></div>
            <div class="h-1.5 bg-white/6 rounded-full w-full mb-3"></div>
            <div class="h-1.5 bg-white/6 rounded-full w-5/6 mb-6"></div>

            <!-- mini charts -->
            <div class="grid grid-cols-3 gap-3">
              <div class="h-14 bg-white/6 rounded-lg flex items-center justify-center">📈</div>
              <div class="h-14 bg-white/6 rounded-lg flex items-center justify-center">💳</div>
              <div class="h-14 bg-white/6 rounded-lg flex items-center justify-center">👥</div>
            </div>

            <div class="mt-4 h-28 bg-gradient-to-r from-[#0ea5b7]/8 to-[#2563eb]/6 rounded-lg"></div>
          </div>
          <div class="w-1/3 flex flex-col gap-3">
            <div class="h-10 bg-white/6 rounded-md"></div>
            <div class="h-10 bg-white/6 rounded-md"></div>
            <div class="h-10 bg-white/6 rounded-md"></div>
          </div>
        </div>

        <!-- floating miniature mock (for animation) -->
        <div class="absolute -left-10 -bottom-12 w-40 h-20 rounded-xl glass flex items-center justify-center text-xs">Live Preview</div>
      </div>
    </div>

  </section>

  <!-- FEATURES -->
  <section id="features" class="max-w-7xl mx-auto px-6 py-14">
    <h3 class="text-sm text-slate-400 uppercase tracking-wider">Features</h3>
    <h2 class="text-3xl md:text-4xl font-bold mt-2 mb-8">Everything you need to manage properties at scale</h2>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      <!-- cards -->
      <div class="p-6 glass rounded-xl reveal">
        <div class="flex items-center gap-4 mb-4">
          <div class="w-12 h-12 rounded-lg gradient-accent flex items-center justify-center">🏘️</div>
          <div>
            <h4 class="font-semibold">Tenant Management</h4>
            <p class="text-slate-400 text-sm">Profiles, lease terms, contact & communication history in one place.</p>
          </div>
        </div>
      </div>

      <div class="p-6 glass rounded-xl reveal">
        <div class="flex items-center gap-4 mb-4">
          <div class="w-12 h-12 rounded-lg gradient-accent flex items-center justify-center">💸</div>
          <div>
            <h4 class="font-semibold">Rent Tracking</h4>
            <p class="text-slate-400 text-sm">Track due dates, partial payments & overdue alerts with ease.</p>
          </div>
        </div>
      </div>

      <div class="p-6 glass rounded-xl reveal">
        <div class="flex items-center gap-4 mb-4">
          <div class="w-12 h-12 rounded-lg gradient-accent flex items-center justify-center">⚙️</div>
          <div>
            <h4 class="font-semibold">Bill Automation</h4>
            <p class="text-slate-400 text-sm">Auto-generate invoices, schedule recurring charges & email reminders.</p>
          </div>
        </div>
      </div>

      <div class="p-6 glass rounded-xl reveal">
        <div class="flex items-center gap-4 mb-4">
          <div class="w-12 h-12 rounded-lg gradient-accent flex items-center justify-center">📊</div>
          <div>
            <h4 class="font-semibold">Expense Reports</h4>
            <p class="text-slate-400 text-sm">Categorize expenses, attach receipts & produce monthly P&L reports.</p>
          </div>
        </div>
      </div>

      <div class="p-6 glass rounded-xl reveal">
        <div class="flex items-center gap-4 mb-4">
          <div class="w-12 h-12 rounded-lg gradient-accent flex items-center justify-center">⚡</div>
          <div>
            <h4 class="font-semibold">Real-Time Dashboard</h4>
            <p class="text-slate-400 text-sm">Live updates on collections, occupancy and payment trends.</p>
          </div>
        </div>
      </div>

      <div class="p-6 glass rounded-xl reveal">
        <div class="flex items-center gap-4 mb-4">
          <div class="w-12 h-12 rounded-lg gradient-accent flex items-center justify-center">🔒</div>
          <div>
            <h4 class="font-semibold">Secure & Compliant</h4>
            <p class="text-slate-400 text-sm">Role-based access, encrypted storage and GDPR-ready tooling.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- PRICING -->
  <section id="pricing" class="max-w-7xl mx-auto px-6 py-14">
    <div class="flex flex-col md:flex-row items-center justify-between mb-8">
      <div>
        <h2 class="text-3xl font-bold">Pricing plans — simple & transparent</h2>
        <p class="text-slate-400">Choose a plan that scales with your portfolio. No hidden fees.</p>
      </div>
      <div class="mt-6 md:mt-0 text-sm text-slate-400">Billed monthly • Cancel anytime</div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      <!-- Basic -->
      <div class="p-6 rounded-2xl glass transform transition hover:-translate-y-3 reveal">
        <div class="text-slate-400 uppercase text-xs mb-2">Basic</div>
        <div class="flex items-baseline gap-2">
          <div class="text-3xl font-bold">$9</div>
          <div class="text-slate-400">/ month</div>
        </div>
        <p class="mt-3 text-sm text-slate-300">For small landlords managing a few units.</p>
        <ul class="mt-4 space-y-2 text-slate-400 text-sm">
          <li>Up to 10 units</li>
          <li>Tenant profiles</li>
          <li>Email invoices</li>
        </ul>
        <a href="#demo" class="mt-6 inline-block px-5 py-2 rounded-full bg-white/6 hover:bg-white/10 transition">Start Free</a>
      </div>

      <!-- Standard -->
      <div class="p-6 rounded-2xl glass border-2 border-white/6 transform transition hover:-translate-y-4 reveal">
        <div class="text-slate-400 uppercase text-xs mb-2">Standard</div>
        <div class="flex items-baseline gap-2">
          <div class="text-3xl font-bold">$29</div>
          <div class="text-slate-400">/ month</div>
        </div>
        <p class="mt-3 text-sm text-slate-300">Popular — for growing landlords and small property managers.</p>
        <ul class="mt-4 space-y-2 text-slate-400 text-sm">
          <li>Up to 100 units</li>
          <li>Automated billing</li>
          <li>Reporting & exports</li>
        </ul>
        <a href="#demo" class="mt-6 inline-block px-5 py-2 rounded-full bg-gradient-to-r from-[#06b6d4] to-[#2563eb] text-white font-semibold hover:scale-105 transition">Start Free</a>
      </div>

      <!-- Premium -->
      <div class="p-6 rounded-2xl glass transform transition hover:-translate-y-3 reveal">
        <div class="text-slate-400 uppercase text-xs mb-2">Premium</div>
        <div class="flex items-baseline gap-2">
          <div class="text-3xl font-bold">Custom</div>
          <div class="text-slate-400">/ month</div>
        </div>
        <p class="mt-3 text-sm text-slate-300">For enterprise portfolios — dedicated support & SSO.</p>
        <ul class="mt-4 space-y-2 text-slate-400 text-sm">
          <li>Unlimited units</li>
          <li>Priority support</li>
          <li>Custom integrations</li>
        </ul>
        <a href="#demo" class="mt-6 inline-block px-5 py-2 rounded-full border border-white/10 text-white hover:bg-white/5 transition">Talk to Sales</a>
      </div>
    </div>
  </section>

  <!-- TESTIMONIALS -->
  <section id="testimonials" class="max-w-7xl mx-auto px-6 py-14">
    <h3 class="text-sm text-slate-400 uppercase tracking-wider">What customers say</h3>
    <h2 class="text-3xl font-bold mt-2 mb-6">Trusted by property managers worldwide</h2>

    <div class="relative bg-white/3 p-6 rounded-2xl glass">
      <div class="carousel">
        <div class="carousel-item active p-4">
          <div class="flex flex-col md:flex-row gap-4 md:gap-8 items-center">
            <img class="w-16 h-16 rounded-full" src="https://via.placeholder.com/64" alt="client">
            <div>
              <p class="text-slate-200">"FlatFlow reduced our rent collection time by 60% and gave us crystal-clear reports for every building."</p>
              <div class="text-slate-400 mt-2 text-sm">— Sarah P., Property Manager</div>
            </div>
          </div>
        </div>

        <div class="carousel-item p-4">
          <div class="flex flex-col md:flex-row gap-4 md:gap-8 items-center">
            <img class="w-16 h-16 rounded-full" src="https://via.placeholder.com/64" alt="client">
            <div>
              <p class="text-slate-200">"Automated billing and reminders saved us countless hours. Highly recommend."</p>
              <div class="text-slate-400 mt-2 text-sm">— Amir K., Landlord</div>
            </div>
          </div>
        </div>

        <div class="carousel-item p-4">
          <div class="flex flex-col md:flex-row gap-4 md:gap-8 items-center">
            <img class="w-16 h-16 rounded-full" src="https://via.placeholder.com/64" alt="client">
            <div>
              <p class="text-slate-200">"The dashboard is intuitive and our accountants love the exports."</p>
              <div class="text-slate-400 mt-2 text-sm">— Priya R., Accountant</div>
            </div>
          </div>
        </div>
      </div>

      <!-- controls -->
      <div class="flex gap-2 mt-4 justify-center">
        <button class="testimonial-dot w-3 h-3 rounded-full bg-white/40" data-index="0"></button>
        <button class="testimonial-dot w-3 h-3 rounded-full bg-white/20" data-index="1"></button>
        <button class="testimonial-dot w-3 h-3 rounded-full bg-white/20" data-index="2"></button>
      </div>
    </div>
  </section>

  <!-- CTA -->
  <section id="demo" class="py-14">
    <div class="max-w-7xl mx-auto px-6 rounded-2xl p-10 bg-gradient-to-r from-[#0ea5b7] to-[#2563eb] text-white shadow-2xl">
      <div class="flex flex-col md:flex-row items-center justify-between gap-6">
        <div>
          <h3 class="text-2xl font-bold">Try Free Demo</h3>
          <p class="text-white/90 mt-1">Experience the live dashboard with sample data—no credit card required.</p>
        </div>
        <div>
          <a href="#" class="px-6 py-3 rounded-full bg-white text-navy font-semibold hover:scale-105 transition">Start Demo</a>
        </div>
      </div>
    </div>
  </section>

  <!-- FOOTER -->
  <footer class="max-w-7xl mx-auto px-6 py-8 text-slate-400">
    <div class="flex flex-col md:flex-row items-center justify-between gap-4">
      <div>© <span id="year"></span> FlatFlow — All rights reserved.</div>
      <div class="flex gap-4">
        <a href="#features" class="hover:text-white">Features</a>
        <a href="#pricing" class="hover:text-white">Pricing</a>
        <a href="#demo" class="hover:text-white">Demo</a>
        <a href="#" class="hover:text-white">Privacy</a>
      </div>
    </div>
  </footer>


  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
  <script>
    $(function(){
      // Reveal on scroll (simple jQuery)
      function revealOnScroll(){
        $('.reveal').each(function(){
          var top = $(this).offset().top;
          var winTop = $(window).scrollTop();
          var winH = $(window).height();
          if(winTop + winH - 80 > top){
            $(this).addClass('visible');
          }
        });
      }
      revealOnScroll();
      $(window).on('scroll', revealOnScroll);

      // Floating mock animation toggle
      setInterval(function(){
        $('#dashboardMock').toggleClass('up');
      }, 2500);

      // Simple testimonial carousel
      let tIndex = 0;
      const items = $('.carousel-item');
      function showTestimonial(i){
        items.removeClass('active');
        $(items[i]).addClass('active');
        $('.testimonial-dot').removeClass('bg-white/40').addClass('bg-white/20');
        $('.testimonial-dot[data-index="'+i+'"]').removeClass('bg-white/20').addClass('bg-white/40');
      }
      showTestimonial(0);
      setInterval(function(){
        tIndex = (tIndex + 1) % items.length;
        showTestimonial(tIndex);
      }, 4500);

      $('.testimonial-dot').on('click', function(){
        tIndex = Number($(this).data('index'));
        showTestimonial(tIndex);
      });

      // Pricing hover lift subtle (already via tailwind classes)

      // Set year
      $('#year').text(new Date().getFullYear());

      // Smooth anchor scroll
      $('a[href^="#"]').on('click', function(e){
        var target = $(this).attr('href');
        if(target.length > 1){
          e.preventDefault();
          $('html,body').animate({ scrollTop: $(target).offset().top - 40 }, 600);
        }
      });

    });
  </script>

</body>
</html>
