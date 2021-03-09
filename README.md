# Laravel - Sales
Sistem Penjualan sederhana dengan menggunakan Laravel 6

## Instalasi
### Clone repo

```bash
# clone the repo
$ git clone https://github.com/andrewfeb/laravel_sales.git

# install app's dependencies
$ composer install
```

### Konfigurasi database MySQL
Copy file ".env.example", dan ubah namanya menjadi ".env". Kemudian di file ".env" ubah konfigurasi database seperti dibawah ini:
- DB_CONNECTION=mysql
- DB_HOST=127.0.0.1
- DB_PORT=3306
- DB_DATABASE=penjualan
- DB_USERNAME=root
- DB_PASSWORD=

Run Laravel migration

```bash
# run database migration and seed
$ php artisan migrate:refresh --seed
```

### Login
email   : admin@sales.dev
password: admin

**Note**
Untuk mengubah default user dapat dilakukan di file database/seeds/usersTableSeeder.php dan harus dilakukan sebelum melakukan migrate

### Konfigurasi Email
Copy file ".env.example", dan ubah namanya menjadi ".env". Kemudian di file ".env" ubah konfigurasi database seperti dibawah ini:
- MAIL_DRIVER=smtp
- MAIL_HOST=smtp.gmail.com
- MAIL_PORT=587
- MAIL_USERNAME=(isi dengan email yang akan digunakan)
- MAIL_PASSWORD=(isi dengan password email)
- MAIL_ENCRYPTION=tls
- MAIL_FROM_ADDRESS=(isi dengan email)

## Fitur
Berikut ini fitur yang ada di Sistem Penjualan:
- Dashboard
- Master User
- Master Kategori Produk
- Master Produk
- Master Customer
- Transaksi Penjualan