<?php

namespace App\Data;

/**
 * Sumber data sementara untuk Pertemuan 2.
 * Di Minggu 4 kelas ini akan diganti dengan Model Eloquent (Produk::all()).
 */
class ProdukDummy
{
    public static function semua(): array
    {
        return [
            [
                'id'        => 1,
                'nama'      => 'PORTER-A17',
                'kategori'  => 'Unisex',
                'harga'     => 59.99,
                'harga_coret' => 79.99,
                'gambar'    => 'assets/images/products/PORTER-A17.png',
                'deskripsi' => 'Sneakers dengan desain modern yang nyaman digunakan untuk aktivitas sehari-hari.',
            ],

            [
                'id'        => 2,
                'nama'      => 'PORTER-K76',
                'kategori'  => 'Unisex',
                'harga'     => 64.99,
                'harga_coret' => 84.99,
                'gambar'    => 'assets/images/products/PORTER-K76.png',
                'deskripsi' => 'Sepatu kasual dengan tampilan minimalis dan desain yang cocok untuk gaya sehari-hari.',
            ],

            [
                'id'        => 3,
                'nama'      => 'PORTER-M53',
                'kategori'  => 'Unisex',
                'harga'     => 74.99,
                'harga_coret' => 94.99,
                'gambar'    => 'assets/images/products/PORTER-M53.png',
                'deskripsi' => 'Sneakers chunky dengan sol tebal dan desain sporty untuk gaya urban.',
            ],

            [
                'id'        => 4,
                'nama'      => 'PORTER-N85',
                'kategori'  => 'Unisex',
                'harga'     => 69.99,
                'harga_coret' => 89.99,
                'gambar'    => 'assets/images/products/PORTER-N85.png',
                'deskripsi' => 'Sneakers bergaya modern dengan kombinasi warna netral dan detail yang menarik.',
            ],

            [
                'id'        => 5,
                'nama'      => 'PORTER-R31',
                'kategori'  => 'Unisex',
                'harga'     => 62.99,
                'harga_coret' => 82.99,
                'gambar'    => 'assets/images/products/PORTER-R31.png',
                'deskripsi' => 'Sepatu kasual dengan desain klasik yang mudah dipadukan dengan berbagai gaya.',
            ],

            [
                'id'        => 6,
                'nama'      => 'PORTER-S19',
                'kategori'  => 'Unisex',
                'harga'     => 79.99,
                'harga_coret' => 99.99,
                'gambar'    => 'assets/images/products/PORTER-S19.png',
                'deskripsi' => 'Sneakers dengan konstruksi kokoh dan sol bertekstur untuk aktivitas outdoor.',
            ],

            [
                'id'        => 7,
                'nama'      => 'PORTER-T64',
                'kategori'  => 'Unisex',
                'harga'     => 72.99,
                'harga_coret' => 92.99,
                'gambar'    => 'assets/images/products/PORTER-T64.png',
                'deskripsi' => 'Sneakers chunky dengan karakter kuat dan tampilan streetwear yang modern.',
            ],

            [
                'id'        => 8,
                'nama'      => 'PORTER-V08',
                'kategori'  => 'Unisex',
                'harga'     => 84.99,
                'harga_coret' => 109.99,
                'gambar'    => 'assets/images/products/PORTER-V08.png',
                'deskripsi' => 'Sepatu sporty dengan desain agresif yang cocok untuk aktivitas dinamis.',
            ],

            [
                'id'        => 9,
                'nama'      => 'PORTER-X42',
                'kategori'  => 'Unisex',
                'harga'     => 76.99,
                'harga_coret' => 96.99,
                'gambar'    => 'assets/images/products/PORTER-X42.png',
                'deskripsi' => 'Sneakers urban dengan desain gelap dan detail modern untuk tampilan kasual.',
            ],

            [
                'id'        => 10,
                'nama'      => 'PORTER-Z27',
                'kategori'  => 'Unisex',
                'harga'     => 81.99,
                'harga_coret' => 104.99,
                'gambar'    => 'assets/images/products/PORTER-Z27.png',
                'deskripsi' => 'Sepatu streetwear dengan desain sporty dan sol tebal untuk tampilan yang berani.',
            ],
        ];
    }

    public static function cari(int $id): ?array
    {
        foreach (self::semua() as $produk) {
            if ($produk['id'] === $id) {
                return $produk;
            }
        }

        return null;
    }
}
