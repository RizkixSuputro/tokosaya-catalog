 <!-- Header -->
 <header class="bg-gray-dark sticky top-0 z-50">
     <div class="container mx-auto flex justify-between items-center py-4">
         <!-- Left section: Logo -->
         <a href="index.html" class="flex items-center">
             <div>
                 <img src="{{ asset('assets/user_front/images/porterfootwearlogo.png') }}" alt="Logo"
                     class="h-14 w-auto mr-4">
             </div>
         </a>

         <!-- Hamburger menu (for mobile) -->
         <div class="flex lg:hidden">
             <button id="hamburger" class="text-white focus:outline-none">
                 <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7">
                     </path>
                 </svg>
             </button>
         </div>

         <!-- Center section: Menu -->
         <nav class="hidden lg:flex md:flex-grow justify-center">
             <ul class="flex justify-center space-x-4 text-white">
                 <li><a href="{{ route('home') }}" class="hover:text-secondary font-semibold">
                         {{ __('web.beranda') }}</a></li>



                 <li><a href="{{ route('daftar-produk') }}"
                         class="hover:text-secondary font-semibold">{{ __('web.produk') }}</a></li>
                 <li><a href="{{ route('kontak') }}"
                         class="hover:text-secondary font-semibold">{{ __('web.kontak_kami') }}</a></li>
                 <li><a href="checkout.html"
                         class="hover:text-secondary font-semibold">{{ __('web.lihat_keranjang') }}</a>
                 </li>
             </ul>
         </nav>

         <!-- Right section: Buttons (for desktop) -->
         <div class="hidden lg:flex items-center space-x-4 relative">
             @include('user-front.partials.pengalih-bahasa')
             <a href="register.html"
                 class="bg-primary border border-primary hover:bg-transparent text-white hover:text-primary font-semibold px-4 py-2 rounded-full inline-block">{{ __('web.daftar') }}</a>
             <a href="register.html"
                 class="bg-primary border border-primary hover:bg-transparent text-white hover:text-primary font-semibold px-4 py-2 rounded-full inline-block">{{ __('web.masuk') }}</a>
             <div class="relative group cart-wrapper">
                 @if ($jumlahKeranjang > 0)
                     <span class="bg-primary text-white text-xs font-bold rounded-full px-2 py-1 ml-1">
                         {{ $jumlahKeranjang }}
                     </span>
                 @endif
                 <a href="{{ route('keranjang.index') }}">
                     <img src="{{ asset('assets/user_front/images/cart-shopping.svg') }}" alt="Cart"
                         class="h-6 w-6 group-hover:scale-120">
                 </a>
                 <!-- Cart dropdown -->

             </div>
             <a id="search-icon" href="javascript:void(0);" class="text-white hover:text-secondary group">
                 <img src="{{ asset('assets/user_front/images/search-icon.svg') }}" alt="Search"
                     class="h-6 w-6 transition-transform transform group-hover:scale-120">
             </a>
             <!-- Search field -->
             <div id="search-field" class="hidden absolute top-full right-0 mt-2 w-full bg-white shadow-lg p-2 rounded">
                 <input type="text" class="w-full p-2 border border-gray-300 rounded"
                     placeholder="Search for products...">
             </div>
         </div>
     </div>
 </header>

 <!-- Mobile menu -->
 <nav id="mobile-menu-placeholder" class="mobile-menu hidden flex-col items-center space-y-8 lg:hidden">

     <ul class="w-full">
         <li><a href="{{ route('home') }}" class="hover:text-secondary font-semibold">
                 {{ __('web.beranda') }}</a></li>
         <li><a href="{{ route('daftar-produk') }}"
                 class="hover:text-secondary font-semibold">{{ __('web.produk') }}</a></li>
         <li><a href="{{ route('kontak') }}"
                 class="hover:text-secondary font-semibold">{{ __('web.kontak_kami') }}</a></li>
         <li><a href="checkout.html" class="hover:text-secondary font-semibold">{{ __('web.lihat_keranjang') }}</a>
         </li>
     </ul>
     <div class="flex flex-col mt-6 space-y-2 items-center">
         <a href="register.html"
             class="bg-primary hover:bg-transparent text-white hover:text-primary border border-primary font-semibold px-4 py-2 rounded-full flex items-center justify-center min-w-[110px]">Register</a>
         <a href="register.html"
             class="bg-primary hover:bg-transparent text-white hover:text-primary border border-primary font-semibold px-4 py-2 rounded-full flex items-center justify-center min-w-[110px]">Login</a>
         @include('user-front.partials.pengalih-bahasa')

     </div>
     <!-- Search field -->
     <div class="  top-full right-0 mt-2 w-full bg-white shadow-lg p-2 rounded">
         <input type="text" class="w-full p-2 border border-gray-300 rounded" placeholder="Search for products...">
     </div>
 </nav>
