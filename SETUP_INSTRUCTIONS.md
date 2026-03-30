# Setup Instructions for L.M.C E-Commerce Store

## Initial Setup

### 1. Install Dependencies
```bash
composer install
npm install
```

### 2. Environment Setup
```bash
# Copy example environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 3. Database Setup
```bash
# Run migrations
php artisan migrate

# Seed database with sample data (optional)
php artisan db:seed
```

### 4. Storage Link Setup (CRITICAL FOR IMAGES)
**If images are not displaying, run this command:**

```bash
php artisan storage:link
```

**For Windows PowerShell (if symlink fails):**
```powershell
# Run as Administrator
New-Item -ItemType Junction -Path "public\storage" -Target "storage\app\public" -Force
```

**For Windows Command Prompt (if symlink fails):**
```cmd
# Run as Administrator
mklink /J "public\storage" "storage\app\public"
```

### 5. Build Assets
```bash
npm run build
```

### 6. Run Development Server
```bash
php artisan serve
```

## Features

### Image Upload
- Product images are stored in `storage/app/public/products/`
- User avatars are stored in `storage/app/public/avatars/`
- Images are accessed via `asset('storage/path-to-image')`

### Admin Features
- **Dashboard**: View order statistics and recent orders
- **Products**: Manage product catalog with images
- **Categories**: Manage product categories with hierarchy
- **Orders**: Track and manage customer orders
- **Users**: Manage user accounts and permissions

### User Features
- **Products**: Browse and search products
- **Shopping Cart**: Add items to cart
- **Checkout**: Complete purchase
- **Orders**: View order history
- **Profile**: Update account information

## Troubleshooting

### Images Not Displaying
1. Ensure `php artisan storage:link` has been run
2. Check that images exist in `storage/app/public/`
3. Clear browser cache
4. Check file permissions: `storage/app/public/` should be writable

### Database Errors
1. Verify database credentials in `.env`
2. Ensure database exists
3. Run `php artisan migrate` to create tables
4. Run `php artisan migrate:refresh --seed` to reset (careful: deletes data)

### Permission Errors
1. Ensure `storage/` directory is writable:
   ```bash
   chmod -R 775 storage/
   ```

## Color Scheme

The application uses a modern gradient-based color scheme:
- **Primary**: Blue/Indigo (`#3B82F6` / `#6366F1`)
- **Success**: Green/Emerald (`#10B981` / `#059669`)
- **Warning**: Yellow/Amber (`#F59E0B` / `#D97706`)
- **Danger**: Red/Rose (`#EF4444` / `#DC2626`)
- **Info**: Cyan/Blue (`#06B6D4` / `#0EA5E9`)

## File Structure

```
app/
├── Http/Controllers/          # Request handlers
├── Models/                    # Database models
└── Providers/                 # Service providers

resources/
├── css/                       # Stylesheets
├── js/                        # JavaScript
└── views/                     # Blade templates
    ├── admin/                 # Admin interface
    ├── auth/                  # Authentication
    ├── layouts/               # Layout templates
    └── products/              # Product pages

storage/
├── app/
│   └── public/                # Public file storage
│       ├── products/          # Product images
│       └── avatars/           # User avatars
└── logs/                      # Application logs

public/
└── storage/ (symlink)         # Public access to storage files
```
