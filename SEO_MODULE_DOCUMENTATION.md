# Page SEO Module Documentation

## Overview

The Page SEO Module allows you to manage SEO settings for static pages (Homepage, About Us, Contact, etc.) through a dynamic admin interface in Filament. This is perfect for pages that are hosted separately or don't use the Page model in the CMS.

## Features

- ✅ Manage SEO for any page using unique identifiers
- ✅ Complete SEO fields: Title, Meta Description, Canonical URL
- ✅ Open Graph tags for Facebook, LinkedIn
- ✅ Twitter Card metadata
- ✅ Schema markup support
- ✅ Auto-fallback values (OG Title falls back to Title, etc.)
- ✅ Cached for performance
- ✅ Easy-to-use helper functions
- ✅ Dynamic - easily add new pages

## Installation & Setup

### 1. Run Migration

```bash
php artisan migrate
```

### 2. Seed Default Pages (Optional)

```bash
php artisan db:seed --class=PageSeoSeeder
```

This will create default SEO settings for:
- Homepage (`home`)
- About Us (`about-us`)
- Services (`services`)
- Contact (`contact`)
- Portfolio (`portfolio`)
- Blog (`blog`)

### 3. Update Composer Autoload

```bash
composer dump-autoload
```

## Usage in Blade Templates

### Method 1: Using Individual Sections (Recommended)

```blade
@extends('layouts.app')

{{-- SEO Sections --}}
@section('title', page_seo('home', 'title', 'Default Title'))
@section('meta_description', page_seo('home', 'meta_description'))
@section('canonical', page_seo('home', 'canonical', url('/')))
@section('og_title', page_seo('home', 'og_title'))
@section('og_description', page_seo('home', 'og_description'))
@section('twitter_title', page_seo('home', 'twitter_title'))
@section('twitter_description', page_seo('home', 'twitter_description'))

@section('content')
    {{-- Your page content --}}
@endsection
```

### Method 2: Get Full SEO Object

```blade
@php
    $seo = page_seo('home');
@endphp

@section('title', $seo?->getTitle() ?? 'Default Title')
@section('meta_description', $seo?->meta_description)
@section('canonical', $seo?->canonical ?? url('/'))
@section('og_title', $seo?->getOgTitle())
@section('og_description', $seo?->getOgDescription())
@section('twitter_title', $seo?->getTwitterTitle())
@section('twitter_description', $seo?->getTwitterDescription())
```

### Method 3: Direct Usage in HTML

```blade
<head>
    <title>{{ page_seo('home', 'title', 'Default Title') }}</title>
    <meta name="description" content="{{ page_seo('home', 'meta_description') }}">
    <link rel="canonical" href="{{ page_seo('home', 'canonical', url('/')) }}">
    
    {{-- Open Graph --}}
    <meta property="og:title" content="{{ page_seo('home', 'og_title') }}">
    <meta property="og:description" content="{{ page_seo('home', 'og_description') }}">
    
    {{-- Twitter Card --}}
    <meta name="twitter:title" content="{{ page_seo('home', 'twitter_title') }}">
    <meta name="twitter:description" content="{{ page_seo('home', 'twitter_description') }}">
</head>
```

## Available Helper Functions

### `page_seo($identifier, $key = null, $default = null)`

Main helper function for getting SEO data.

**Examples:**

```php
// Get the full SEO object
$seo = page_seo('home');

// Get a specific field
$title = page_seo('home', 'title');

// Get a field with fallback
$title = page_seo('home', 'title', 'My Default Title');
```

### Available Fields

- `title` - Meta title
- `meta_description` - Meta description
- `canonical` - Canonical URL
- `og_title` - Open Graph title (with auto-fallback to title)
- `og_description` - Open Graph description (with auto-fallback)
- `og_image` - Open Graph image URL
- `twitter_title` - Twitter Card title (with auto-fallback)
- `twitter_description` - Twitter Card description (with auto-fallback)
- `twitter_image` - Twitter Card image URL
- `meta_keywords` - Array of keywords
- `meta_robots` - Robots meta tag
- `schema_markup` - Structured data (JSON-LD)

## Managing SEO Settings in Admin Panel

1. Log into your Filament admin panel
2. Navigate to **Settings > Page SEO**
3. You'll see a list of all pages with their SEO settings
4. Click **Edit** to modify SEO settings
5. Click **New Page SEO** to add a new page

### Adding a New Page

1. Click **New Page SEO**
2. Fill in:
   - **Page Display Name**: E.g., "Pricing Page"
   - **Page Identifier**: E.g., "pricing" (use lowercase with hyphens)
   - **Page URL**: Optional reference URL
3. Fill in SEO fields:
   - **Meta Title**: 50-60 characters recommended
   - **Meta Description**: 150-160 characters recommended
   - **Canonical URL**: The preferred URL
4. The system will auto-fill OG and Twitter fields with your basic SEO data
5. Toggle **Active** to enable/disable

## Page Identifiers

Page identifiers are unique slugs used to fetch SEO settings. Use lowercase with hyphens:

- ✅ Good: `home`, `about-us`, `contact`, `pricing-page`
- ❌ Bad: `Home`, `About Us`, `contact_us`, `Pricing Page`

## Default Pages Included

| Identifier | Page Name | Description |
|------------|-----------|-------------|
| `home` | Homepage | Main landing page |
| `about-us` | About Us | Company information |
| `services` | Services | Services listing |
| `contact` | Contact Us | Contact page |
| `portfolio` | Portfolio | Portfolio/work showcase |
| `blog` | Blog | Blog listing page |

## Example: Complete Homepage

```blade
{{-- resources/views/home.blade.php --}}
@extends('layouts.app')

{{-- ===== SEO ===== --}}
@section('title', page_seo('home', 'title', 'My Company – AI & IT Solutions'))
@section('meta_description', page_seo('home', 'meta_description', 'Default description'))
@section('canonical', page_seo('home', 'canonical', url('/')))
@section('og_title', page_seo('home', 'og_title'))
@section('og_description', page_seo('home', 'og_description'))
@section('twitter_title', page_seo('home', 'twitter_title'))
@section('twitter_description', page_seo('home', 'twitter_description'))

@section('content')
    <h1>Welcome to Our Homepage</h1>
    <p>Your content here...</p>
@endsection
```

## Layout File Setup

Your `layouts/app.blade.php` should include these meta tags:

```blade
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    {{-- Basic SEO --}}
    <title>@yield('title', 'Default Site Title')</title>
    <meta name="description" content="@yield('meta_description', 'Default description')">
    <link rel="canonical" href="@yield('canonical', url()->current())">
    <meta name="robots" content="@yield('meta_robots', 'index, follow')">
    
    {{-- Open Graph --}}
    <meta property="og:title" content="@yield('og_title', config('app.name'))">
    <meta property="og:description" content="@yield('og_description', 'Default description')">
    <meta property="og:url" content="@yield('canonical', url()->current())">
    <meta property="og:type" content="website">
    @hasSection('og_image')
        <meta property="og:image" content="@yield('og_image')">
    @endif
    
    {{-- Twitter Card --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('twitter_title', config('app.name'))">
    <meta name="twitter:description" content="@yield('twitter_description', 'Default description')">
    @hasSection('twitter_image')
        <meta name="twitter:image" content="@yield('twitter_image')">
    @endif
</head>
<body>
    @yield('content')
</body>
</html>
```

## Caching

SEO settings are automatically cached for 24 hours for better performance. The cache is cleared when:
- SEO settings are created
- SEO settings are updated
- SEO settings are deleted

To manually clear the cache:

```bash
php artisan cache:clear
```

## Best Practices

1. **Title Length**: Keep titles between 50-60 characters
2. **Description Length**: Keep descriptions between 150-160 characters
3. **Unique Identifiers**: Use descriptive, unique page identifiers
4. **Canonical URLs**: Always set canonical URLs to avoid duplicate content
5. **Images**: Upload OG/Twitter images at 1200x630px for best results
6. **Testing**: Test your SEO using tools like:
   - Google Search Console
   - Facebook Sharing Debugger
   - Twitter Card Validator

## Programmatic Usage (PHP)

You can also use the SEO helper in your controllers:

```php
use App\Helpers\SeoHelper;

// Get SEO object
$seo = SeoHelper::get('home');

// Get specific values
$title = SeoHelper::getTitle('home', 'Default Title');
$description = SeoHelper::getMetaDescription('home');
$canonical = SeoHelper::getCanonical('home', url('/'));

// With fallbacks
$ogTitle = SeoHelper::getOgTitle('home', 'Fallback Title');
```

## Troubleshooting

### Helper function not found

Run: `composer dump-autoload`

### SEO not showing up

1. Check if the page identifier is correct
2. Verify the page is set to **Active** in admin
3. Clear cache: `php artisan cache:clear`

### Changes not reflecting

Clear the cache: `php artisan cache:clear`

## API Reference

### PageSeo Model Methods

```php
$seo->getTitle()              // Get title with fallback to page_name
$seo->getOgTitle()           // Get OG title with fallbacks
$seo->getOgDescription()     // Get OG description with fallback
$seo->getTwitterTitle()      // Get Twitter title with fallbacks
$seo->getTwitterDescription() // Get Twitter description with fallback
```

### Static Methods

```php
PageSeo::getByIdentifier('home')  // Get SEO by identifier (cached)
PageSeo::active()                  // Scope for active pages only
```

## Support

For issues or questions, please contact your development team or refer to the project documentation.
