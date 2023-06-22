
# SIMASJID DARUL ULUM

Aplikasi ini merupakan sistem informasi pengelolaan segala informasi yang terdapat pada suatu mesjid, aplikasi ini dibuat spesifik sesuai dengan kebutuhan dari Masjid Darul Ulum UNPAM

## Instalasi Aplikasi
Untuk menginstal aplikasi ini di perlukan beberapa software pendukung, di antarnya ialah sebagai berikut:
- MYSQL 8.0.33 [Tutorial](https://www3.ntu.edu.sg/home/ehchua/programming/sql/MySQL_HowTo.html)
- PHP 7.3.33  [Tutorial](https://kinsta.com/blog/install-php/)
- Composer 2.6 [Tutorial](https://getcomposer.org/doc/00-intro.md)
- Node JS v12.22.10 [Tutorial](https://www.freecodecamp.org/news/how-to-install-node-in-your-machines-macos-linux-windows/)

Clone repository [Tutorial](https://pdsi.unisayogya.ac.id/cara-cloning-repository-gitlab-via-ssh-terminal-atau-https-netbeans/)

    https://gitlab.com/ahmadhdr/naruto

Masuk ke direktory project aplikasi 

     cd /lokasi_project_aplikasi

Install depedensi

    composer install
Copy file konfigurasi dengan menggunakan perintah

    cp .env.example .env

Buat key aplikasi yang baru

    php artisan key:generate

Rubah konfirugasi midtrans, midtrans digunakan untuk mendukung proses pembayaran infaq zakat dan sedekah secara otomatis

    MIDTRANS_IS_PRODUCTION=false
    MIDTRANS_MERCHAT_ID=midtrans_merchant_id
    MIDTRANS_CLIENT_KEY=midtrans_client_key
    MIDTRANS_SERVER_KEY=midrans_server_key

Buat database terlebih dahulu, pastikan terlebih dahulu telah menginstall ``mysql`` ikuti tutorial diatas jika belum menginstall

    mysql -u root -p passwod_kamu
    create database simasjid_unpam

Setelah berhasil membuat database, rubah konfigurasi database yang terdapat pada file ``.env``

    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=nama_database
    DB_USERNAME=database_username
    DB_PASSWORD=database_password

Membuat table sesuai kebutuhan

    php artisan migrate

Membuat data dummy untuk keperluan testing

    php artisan db:seed

Install depedency Node JS menggunakan

    npm install


## Menjalankan Aplikasi

Menjalankan php server menggunakan perintah (development only)

    php artisan serve

Menjalankan Node JS (development only)

    npm run watch

Akses aplikasi pada path ``http://127.0.0.1:8000``

    
Bila masih mendapat kebingunan silahkan bisa mengubungi saya via [Linkedin](https://www.linkedin.com/in/ahmadhaidaralbaqir/)