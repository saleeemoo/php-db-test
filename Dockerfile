# ─── صورة PHP رسمية، نسخة 8.3 مع Apache ───
# النسخة مثبّتة صراحة — ما تتغير إلا بتعديل هذا السطر
FROM php:8.3-apache

# ─── تثبيت إضافة pdo_mysql للاتصال بـ MariaDB ───
# PHP ما يتصل بقاعدة بيانات بدون هذي الإضافة
RUN docker-php-ext-install pdo_mysql mysqli

# ─── تفعيل mod_rewrite (مفيد لأغلب تطبيقات PHP) ───
RUN a2enmod rewrite

# ─── نسخ كود التطبيق لمجلد Apache ───
# Apache يخدم الملفات من /var/www/html تلقائياً
COPY . /var/www/html/

# ─── صلاحيات صحيحة للملفات ───
RUN chown -R www-data:www-data /var/www/html

# ─── Apache يسمع على بورت 80 داخل الحاوية ───
EXPOSE 80
