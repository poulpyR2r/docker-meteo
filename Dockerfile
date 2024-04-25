FROM php:apache-bullseye

# Install the dependecies
RUN apt-get update && apt-get install -y \
    git \
    zip \
    unzip

RUN docker-php-ext-install pdo_mysql mysqli && docker-php-ext-enable mysqli pdo_mysql

# Define the working directory
WORKDIR /var/www/html

RUN sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf

# Copy the app
COPY . .

# Run the app
CMD ["apache2-foreground"]