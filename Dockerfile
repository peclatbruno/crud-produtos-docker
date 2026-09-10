# Parte da imagem oficial do PHP com Apache, disponível no Docker Hub
FROM php:8.2-apache

# Instala a extensão pdo_mysql, necessária para o PDO conseguir se conectar ao MySQL
# (a imagem base não vem com essa extensão habilitada por padrão)
RUN docker-php-ext-install pdo pdo_mysql

# Configura o fuso horário do PHP para o horário de Brasília (evita datas erradas em funções como date())
RUN echo "date.timezone = America/Sao_Paulo" > /usr/local/etc/php/conf.d/timezone.ini
