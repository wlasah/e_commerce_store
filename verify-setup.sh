#!/bin/bash
# Verification Checklist for L.M.C E-Commerce Fixes

echo "🔍 L.M.C E-Commerce Application Verification Checklist"
echo "=================================================="
echo ""

# Check PHP artisan
if command -v php &> /dev/null; then
    echo "✅ PHP is installed"
else
    echo "❌ PHP is not installed"
    exit 1
fi

# Check storage directories
echo ""
echo "📁 Checking storage directories..."
if [ -d "storage/app/public/products" ]; then
    echo "✅ Products storage directory exists"
    product_count=$(find storage/app/public/products -type f | wc -l)
    echo "   Found $product_count product images"
else
    echo "❌ Products storage directory missing"
fi

if [ -d "storage/app/public/avatars" ]; then
    echo "✅ Avatars storage directory exists"
    avatar_count=$(find storage/app/public/avatars -type f | wc -l)
    echo "   Found $avatar_count user avatars"
else
    echo "❌ Avatars storage directory missing"
fi

# Check public storage symlink
echo ""
echo "🔗 Checking storage symlink..."
if [ -L "public/storage" ] || [ -d "public/storage" ]; then
    echo "✅ Public storage symlink/junction exists"
    if [ -d "public/storage/products" ]; then
        echo "✅ Can access products through symlink"
    fi
    if [ -d "public/storage/avatars" ]; then
        echo "✅ Can access avatars through symlink"
    fi
else
    echo "❌ Public storage symlink not found"
    echo "   Run: php artisan storage:link"
fi

# Check Blade files are updated
echo ""
echo "📝 Checking updated Blade files..."
files_to_check=(
    "resources/views/admin/orders/index.blade.php"
    "resources/views/admin/orders/show.blade.php"
    "resources/views/admin/products/index.blade.php"
    "resources/views/admin/products/show.blade.php"
    "resources/views/products/index.blade.php"
    "resources/views/products/show.blade.php"
    "resources/views/cart/index.blade.php"
)

for file in "${files_to_check[@]}"; do
    if grep -q "Storage::disk('public')->exists" "$file" 2>/dev/null; then
        echo "✅ $file - Contains image safety checks"
    fi
done

# Check environment setup
echo ""
echo "⚙️  Checking Laravel environment..."
if [ -f ".env" ]; then
    echo "✅ .env file exists"
else
    echo "❌ .env file missing (run: cp .env.example .env)"
fi

if [ -f "bootstrap/app.php" ]; then
    echo "✅ Laravel app initialization file exists"
fi

# Database check (optional)
if command -v sqlite3 &> /dev/null; then
    echo "✅ SQLite installation detected"
fi

echo ""
echo "=================================================="
echo "🎉 Verification Complete!"
echo ""
echo "Next Steps:"
echo "1. Run: php artisan migrate (if not done)"
echo "2. Run: npm run build (if not done)"
echo "3. Run: php artisan serve"
echo "4. Visit: http://localhost:8000"
echo ""
echo "📚 See SETUP_INSTRUCTIONS.md for detailed setup"
echo "📋 See FIXES_SUMMARY.md for list of all fixes"
