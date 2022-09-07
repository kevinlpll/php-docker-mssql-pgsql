FROM php:8.1.0-apache

WORKDIR /var/www/html/

RUN apt-get update && apt-get upgrade -y

#SQL Server requirements
ENV ACCEPT_EULA=Y
RUN apt-get install -y --no-install-recommends curl gcc g++ gnupg unixodbc-dev

# Add SQL Server ODBC Driver 18 for Debian 11
RUN curl https://packages.microsoft.com/keys/microsoft.asc | apt-key add - \
  && curl https://packages.microsoft.com/config/debian/11/prod.list > /etc/apt/sources.list.d/mssql-release.list \
  && apt-get update \
  && apt-get install -y --no-install-recommends --allow-unauthenticated msodbcsql18 mssql-tools \
  && echo 'export PATH="$PATH:/opt/mssql-tools/bin"' >> ~/.bash_profile \
  && echo 'export PATH="$PATH:/opt/mssql-tools/bin"' >> ~/.bashrc


#Sql server driver on php
RUN apt-get -y install unixodbc-dev
RUN pecl install sqlsrv pdo_sqlsrv-5.10.0 \
    && docker-php-ext-enable pdo_sqlsrv sqlsrv

# Install Postgre PDO
RUN apt-get install -y libpq-dev \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo pdo_pgsql pgsql

#Apenas para testes
RUN apt-get install telnet -y 

EXPOSE 80