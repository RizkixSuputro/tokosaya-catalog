 <!-- Footer -->
 <footer class="border-t border-gray-line">
     <!-- Top part -->
     <div class="container mx-auto px-4 py-10">
         <div class="flex flex-wrap -mx-4">
             <!-- Menu 1 -->
             <div class="w-full sm:w-1/6 px-4 mb-8">
                 <h3 class="text-lg font-semibold mb-4">{{ __('web.toko') }}</h3>
                 <ul>
                     <li><a href="/shop.html" class="hover:text-primary">{{ __('web.toko') }}</a></li>
                     <li><a href="/single-product-page.html" class="hover:text-primary">{{ __('web.kategori_pria') }}</a>
                     </li>
                     <li><a href="/shop.html" class="hover:text-primary">{{ __('web.kategori_wanita') }}</a></li>
                     <li><a href="/single-product-page.html"
                             class="hover:text-primary">{{ __('web.kategori_unisex') }}</a></li>
                 </ul>
             </div>
             <!-- Menu 2 -->
             <div class="w-full sm:w-1/6 px-4 mb-8">
                 <h3 class="text-lg font-semibold mb-4">{{ __('web.halaman') }}</h3>
                 <ul>
                     <li><a href="/shop.html" class="hover:text-primary">{{ __('web.toko') }}</a></li>
                     <li><a href="/single-product-page.html" class="hover:text-primary">{{ __('web.produk') }}</a></li>
                     <li><a href="/checkout.html" class="hover:text-primary">{{ __('web.lihat_keranjang') }}</a></li>
                 </ul>
             </div>
             <!-- Menu 3 -->
             <div class="w-full sm:w-1/6 px-4 mb-8">
                 <h3 class="text-lg font-semibold mb-4">{{ __('web.akun') }}</h3>
                 <ul>
                     <li><a href="/register.html" class="hover:text-primary">{{ __('web.daftar') }}</a></li>
                     <li><a href="/register.html" class="hover:text-primary">{{ __('web.masuk') }}</a></li>
                 </ul>
             </div>
             <!-- Social Media -->
             <div class="w-full sm:w-1/6 px-4 mb-8">
                 <h3 class="text-lg font-semibold mb-4">{{ __('web.ikuti_kami') }}</h3>
                 <ul>
                     <li class="flex items-center mb-2">
                         <img src="{{ asset('assets/user_front/images/social_icons/facebook.svg') }}" alt="Facebook"
                             class="w-4 h-4 transition-transform transform hover:scale-110 mr-2">
                         <a href="#" class="hover:text-primary">Facebook</a>
                     </li>
                     <li class="flex items-center mb-2">
                         <img src="{{ asset('assets/user_front/images/social_icons/twitter.svg') }}" alt="Twitter"
                             class="w-4 h-4 transition-transform transform hover:scale-110 mr-2">
                         <a href="#" class="hover:text-primary">Twitter</a>
                     </li>
                     <li class="flex items-center mb-2">
                         <img src="{{ asset('assets/user_front/images/social_icons/instagram.svg') }}" alt="Instagram"
                             class="w-4 h-4 transition-transform transform hover:scale-110 mr-2">
                         <a href="#" class="hover:text-primary">Instagram</a>
                     </li>
                     <li class="flex items-center mb-2">
                         <img src="{{ asset('assets/user_front/images/social_icons/pinterest.svg') }}" alt="Instagram"
                             class="w-4 h-4 transition-transform transform hover:scale-110 mr-2">
                         <a href="#" class="hover:text-primary">Pinterest</a>
                     </li>
                     <li class="flex items-center mb-2">
                         <img src="{{ asset('assets/user_front/images/social_icons/youtube.svg') }}" alt="Instagram"
                             class="w-4 h-4 transition-transform transform hover:scale-110 mr-2">
                         <a href="#" class="hover:text-primary">YouTube</a>
                     </li>
                 </ul>
             </div>
             <!-- Contact Information -->
             <div class="w-full sm:w-2/6 px-4 mb-8">
                 <h3 class="text-lg font-semibold mb-4">{{ __('web.hubungi_kami') }}</h3>
                 <p><img src="{{ asset('assets/user_front/images/porterfootwearlogo.png') }}" alt="Logo"
                         class="h-[60px] mb-4"></p>
                 <p>Jl Wibisana Utara</p>
                 <p class="text-xl font-bold my-4">{{ __('web.no_telp') }} : (123) 456-7890</p>
                 <a href="mailto:info@company.com" class="underline">{{ __('web.email') }}: info@company.com</a>
             </div>
         </div>
     </div>


 </footer>
