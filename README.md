# IMGML

![Screenshot](screenshot_1.png)

Convert images into pure HTML. Each pixel becomes a 1x1 `<hr>` element with a matching background color, creating a faithful reproduction of your image using nothing but HTML elements.

## How It Works

1. Upload any image
2. The application reads each pixel and extracts its color
3. Generates HTML where every pixel is represented by a tiny `<hr>` element
4. Download the resulting HTML file

The output is a fully self-contained HTML document that displays your image without any actual image files.

## Tech Stack

- Laravel 12
- Livewire

## Setup

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
npm run dev
php artisan serve
```

## License

MIT
