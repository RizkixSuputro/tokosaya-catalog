@extends('user-front.layouts.app')

@section('judul', 'Kontak Saya')

@section('content')
    <section class="bg-gray-50 py-12 sm:py-16 lg:py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <!-- Header -->
            <div class="relative mx-auto mb-12 w-fit sm:mb-16">
                <h2 class="text-3xl font-bold text-gray-900 md:text-4xl">
                    Contact Us
                </h2>

                <span
                    class="absolute left-0 top-full mt-2 h-1 w-full rounded-full bg-gradient-to-r from-primary/40 to-primary/5">
                </span>
            </div>

            <!-- Main Content -->
            <div class="grid items-center gap-12 lg:grid-cols-2 lg:gap-16">

                <!-- Image Section -->
                <div class="flex justify-center mb-5">
                    <img src="{{ asset('assets/images/hero/hero2.png') }}" alt="Contact illustration"
                        class="h-auto w-full max-w-lg object-contain" />
                </div>

                <!-- Contact Info Section -->
                <div>
                    <h3 class="mb-5 text-2xl font-semibold text-gray-900 sm:text-3xl">
                        Senang Bisa Membantu Anda!
                    </h3>

                    <p class="mb-10 text-base leading-7 text-gray-600 sm:text-lg">
                        Punya pertanyaan mengenai produk PORTER FOOTWEAR? Jangan ragu untuk
                        menghubungi kami. Tim kami siap membantu memberikan informasi
                        mengenai produk dan layanan yang tersedia.
                    </p>

                    <!-- Contact Info Grid -->
                    <div class="grid gap-5 sm:grid-cols-2">

                        <!-- Office Hours -->
                        <div class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-200">
                            <div class="flex flex-col items-center text-center">

                                <div
                                    class="mb-4 flex h-12 w-12 items-center justify-center rounded-full border border-primary/20 text-primary">
                                    <i class="fa-solid fa-clock text-xl"></i>
                                </div>

                                <h4 class="mb-3 text-lg font-semibold text-gray-900">
                                    Jam Buka
                                </h4>

                                <div class="text-sm leading-6 text-gray-600">
                                    <p>Senin - Jumat</p>
                                    <p>08:00 - 17:00 WITA</p>
                                </div>

                            </div>
                        </div>

                        <!-- Alamat -->
                        <div class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-200">
                            <div class="flex flex-col items-center text-center">

                                <div
                                    class="mb-4 flex h-12 w-12 items-center justify-center rounded-full border border-primary/20 text-primary">
                                    <i class="fa-solid fa-location-dot text-xl"></i>
                                </div>

                                <h4 class="mb-3 text-lg font-semibold text-gray-900">
                                    Alamat
                                </h4>

                                <address class="text-sm leading-6 text-gray-600 not-italic">
                                    Denpasar, Bali
                                    <br>
                                    Indonesia
                                </address>

                            </div>
                        </div>

                        <!-- Store -->
                        <div class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-200">
                            <div class="flex flex-col items-center text-center">

                                <div
                                    class="mb-4 flex h-12 w-12 items-center justify-center rounded-full border border-primary/20 text-primary">
                                    <i class="fa-solid fa-store text-xl"></i>
                                </div>

                                <h4 class="mb-3 text-lg font-semibold text-gray-900">
                                    PORTER FOOTWEAR
                                </h4>

                                <address class="text-sm leading-6 text-gray-600 not-italic">
                                    PORTER FOOTWEAR
                                    <br>
                                    Toko Sepatu Idaman Anda
                                </address>

                            </div>
                        </div>

                        <!-- Get in Touch -->
                        <div class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-200">
                            <div class="flex flex-col items-center text-center">

                                <div
                                    class="mb-4 flex h-12 w-12 items-center justify-center rounded-full border border-primary/20 text-primary">
                                    <i class="fa-solid fa-phone text-xl"></i>
                                </div>

                                <h4 class="mb-3 text-lg font-semibold text-gray-900">
                                    Hubungi Kami
                                </h4>

                                <div class="text-sm leading-6 text-gray-600">
                                    <p>+62 XXX-XXXX-XXXX</p>
                                    <p>+62 XXX-XXXX-XXXX</p>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection
