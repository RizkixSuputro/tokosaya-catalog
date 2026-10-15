@extends('user-front.layouts.app')

@section('judul', 'Detail Produk')


@section('content')
    <!-- Breadcrumbs -->
    <section id="breadcrumbs" class="pt-6 bg-gray-50 mb-5">
        <div class="container mx-auto px-4">
            <ol class="list-reset flex">
                <li><a href="{{ route('home') }}" class="font-semibold hover:text-primary">{{ __('web.beranda') }}</a></li>
                <li><span class="mx-2">&gt;</span></li>
                <li><a href="{{ route('daftar-produk') }}" class="font-semibold hover:text-primary">{{ __('web.produk') }}</a>
                </li>
                <li><span class="mx-2">&gt;</span></li>
                <li>{{ $produk->nama_produk }}</li>
            </ol>
        </div>
    </section>

    <!-- Product info -->
    <section id="product-info">
        <div class="container mx-auto px-4">
            <div class="py-6">
                <div class="flex flex-col lg:flex-row gap-6">
                    <!-- Image Section -->

                    <div class="w-full lg:w-1/2">
                        <div class="grid gap-4">
                            <!-- Big Image -->
                            <div id="main-image-container">
                                <img id="main-image"
                                    class="h-auto w-full max-w-full rounded-lg object-cover object-center md:h-[480px]"
                                    src="{{ asset('storage/' . $produk->gambar) }}" alt="{{ $produk->nama_produk }}" />
                            </div>
                            <!-- Small Images -->
                            <div class="grid grid-cols-5 gap-4">
                                <div>
                                    <img onclick="changeImage(this)" data-full="{{ $produk['gambar'] }}"
                                        src="{{ asset('storage/' . $produk->gambar) }}"
                                        class="object-cover object-center max-h-30 max-w-full rounded-lg cursor-pointer"
                                        alt="Gallery Image 1" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Product Details Section -->
                    <div class="w-full lg:w-1/2 flex flex-col justify-between">
                        <div class="pb-8 border-b border-gray-line">
                            <h1 class="text-3xl font-bold mb-4"> {{ $produk->nama_produk }}</h1>
                            <div class="flex items-center mb-8">
                                <span>★★★★★</span>
                                <span class="ml-2">(0 {{ __('web.ulasan') }})</span>
                                <a href="#" class="ml-4 text-primary font-semibold">{{ __('web.tulis_ulasan') }}</a>
                            </div>
                            <div class="mb-4 pb-4 border-b border-gray-line">
                                <p class="mb-2">{{ __('web.kategori') }}:<strong><a href="#"
                                            class="hover:text-primary">
                                            {{ $produk->kategori->nama_kategori }}</a></strong>
                                </p>
                                <p class="mb-2">{{ __('web.kode_produk') }} : <strong>
                                        {{ $produk->kode_produk }}</strong>
                                </p>
                                <p class="mb-2">{{ __('web.kondisi') }} : <strong> {{ $produk->status }}</strong></p>
                                <p class="mb-2">{{ __('web.stok') }}<strong> {{ $produk->stok }}</strong></p>
                            </div>
                            <div class="text-2xl font-semibold mb-8">{{ $produk->hargaRupiah() }}</div>

                            @if ($produk->stok > 0)
                                <form action="{{ route('keranjang.tambah', $produk) }}" method="POST" class="mb-6">
                                    @csrf

                                    <div class="mb-6">
                                        <label for="jumlah" class="block font-medium mb-2">{{ __('web.jumlah') }}</label>

                                        <div class="flex items-center">
                                            <button type="button" onclick="ubahJumlah(-1)"
                                                class="w-10 h-10 rounded-full bg-gray-100 font-bold text-xl">
                                                &minus;
                                            </button>

                                            <input type="number" name="jumlah" id="jumlah" value="1"
                                                min="1" max="{{ $produk->stok }}"
                                                class="w-16 text-center border border-gray-300 rounded p-2 mx-2">

                                            <button type="button" onclick="ubahJumlah(1)"
                                                class="w-10 h-10 rounded-full bg-gray-100 font-bold text-xl">
                                                +
                                            </button>
                                        </div>
                                    </div>

                                    <button type="submit"
                                        class="bg-primary border border-transparent hover:bg-transparent hover:border-primary text-white hover:text-primary font-semibold py-2 px-4 rounded-full w-full">
                                        {{ __('web.masuk_keranjang') }}
                                    </button>
                                </form>
                            @else
                                <div class="bg-gray-100 rounded-lg p-4 mb-6 text-center">
                                    <p class="font-semibold mb-0">{{ __('web.stok_habis') }}</p>
                                </div>
                            @endif
                        </div>
                        <!-- Social sharing -->
                        <div class="flex space-x-4 my-6">
                            <a href="#" class="w-4 h-4 flex items-center justify-center">
                                <img src="{{ asset('assets/user_front/images/social_icons/facebook.svg') }}" alt="Facebook"
                                    class="w-4 h-4 transition-transform transform hover:scale-110">
                            </a>
                            <a href="#" class="w-4 h-4 flex items-center justify-center">
                                <img src="{{ asset('assets/user_front/images/social_icons/instagram.svg') }}"
                                    alt="Instagram" class="w-4 h-4 transition-transform transform hover:scale-110">
                            </a>

                            <a href="#" class="w-4 h-4 flex items-center justify-center">
                                <img src="{{ asset('assets/user_front/images/social_icons/twitter.svg') }}" alt="Twitter"
                                    class="w-4 h-4 transition-transform transform hover:scale-110">
                            </a>
                        </div>
                        <!-- Additional Information -->


                        <div>
                            <h3 class="text-lg font-semibold mb-2">{{ __('web.deskripsi_produk') }}</h3>
                            <p>{{ $produk->deskripsi }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>




@endsection

@push('scripts')
    <script>
        function ubahJumlah(langkah) {
            const kotak = document.getElementById('jumlah');
            const baru = parseInt(kotak.value) + langkah;
            const batas = parseInt(kotak.max);

            if (baru >= 1 && baru <= batas) {
                kotak.value = baru;
            }
        }
    </script>
@endpush
