@echo off
REM Script untuk download sample product images
REM Menggunakan placeholder images dengan kualitas lebih baik

echo ========================================
echo DOWNLOAD SAMPLE PRODUCT IMAGES
echo ========================================
echo.
echo Script ini akan download sample images untuk beberapa produk
echo Images akan disimpan di: public\images\products\
echo.
pause

cd /d "%~dp0"

REM Create directory if not exists
if not exist "public\images\products" mkdir "public\images\products"

echo.
echo Downloading sample images...
echo.

REM Download using PowerShell (built-in Windows)
powershell -Command "& {
    $products = @(
        @{slug='intel-core-i5-12400f'; url='https://placehold.co/800x800/4F46E5/white/png?text=Intel+i5-12400F&font=roboto'},
        @{slug='amd-ryzen-5-3600'; url='https://placehold.co/800x800/4F46E5/white/png?text=AMD+Ryzen+5+3600&font=roboto'},
        @{slug='nvidia-gtx-1650-4gb'; url='https://placehold.co/800x800/DC2626/white/png?text=GTX+1650&font=roboto'},
        @{slug='amd-rx6600-8gb'; url='https://placehold.co/800x800/DC2626/white/png?text=RX+6600&font=roboto'},
        @{slug='corsair-cv550-550w-bronze'; url='https://placehold.co/800x800/CA8A04/white/png?text=Corsair+CV550&font=roboto'},
        @{slug='armageddon-mx5-matx'; url='https://placehold.co/800x800/0891B2/white/png?text=Armageddon+MX5&font=roboto'}
    )
    
    foreach($product in $products) {
        $path = 'public\images\products\' + $product.slug + '.png'
        Write-Host 'Downloading:' $product.slug
        try {
            Invoke-WebRequest -Uri $product.url -OutFile $path -UseBasicParsing
            Write-Host '  Success!' -ForegroundColor Green
        } catch {
            Write-Host '  Failed!' -ForegroundColor Red
        }
    }
    
    Write-Host ''
    Write-Host 'Download completed!' -ForegroundColor Green
}"

echo.
echo ========================================
echo DONE!
echo ========================================
echo.
echo Sample images telah di-download ke folder public\images\products\
echo.
echo Untuk menggunakan gambar real:
echo 1. Replace file PNG dengan gambar produk asli (JPG/PNG)
echo 2. Atau gunakan script PHP untuk update path di database
echo.
pause
