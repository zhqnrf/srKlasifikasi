# SR Klasifikasi

## About the Project
SR Klasifikasi is a web-based application designed to classify the achievement levels of students (santri) at **Pondok Pesantren Mahasiswa Syafiurohman Jember**. The classification is based on **batch (angkatan), the number of memorized Quran verses (Al-Quran), and the number of memorized Hadiths (Al-Hadis).**

## Built With
- **Laravel** - PHP Framework
- **Bootstrap** - Frontend Framework

## Features
- **Student Classification**: Categorizes students based on their achievements.
- **Batch-Based Filtering**: Allows classification based on student batches.
- **Memorization Tracking**: Records and evaluates Quran and Hadith memorization levels.
- **Responsive UI**: Designed with Bootstrap for a seamless experience on all devices.

## Installation

### Prerequisites
Make sure you have the following installed on your system:
- PHP (>= 8.0)
- Composer
- Laravel
- MySQL
- Node.js & npm (for frontend assets)

### Steps
1. **Clone the repository**
   ```sh
   https://github.com/zhqnrf/srKlasifikasi
   cd srKlasifikasi
   ```

2. **Install dependencies**
   ```sh
   composer install
   npm install && npm run dev
   ```

3. **Set up environment variables**
   ```sh
   cp .env.example .env
   ```
   - Update database credentials in `.env`

4. **Generate application key**
   ```sh
   php artisan key:generate
   ```

5. **Run database migrations**
   ```sh
   php artisan migrate --seed
   ```

6. **Start the application**
   ```sh
   php artisan serve
   ```

## Usage
Once the application is running, open your browser and visit:
```
http://127.0.0.1:8000
```
Login with the default admin credentials (if provided in the seed data) or create a new account.

## Contribution
Feel free to fork this repository and submit pull requests for improvements or new features.

## License
This project is licensed under the MIT License.

---


