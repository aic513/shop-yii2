#!/usr/bin/env bash

source /app/vagrant/provision/common.sh

#== Import script args ==

timezone=$(echo "$1")
readonly IP=$2

#== Provision script ==

info "Provision-script user: $(whoami)"

export DEBIAN_FRONTEND=noninteractive

info "Configure timezone"
timedatectl set-timezone ${timezone} --no-ask-password

info "AWK initial replacement work"
awk -v ip=$IP -f /app/vagrant/provision/provision.awk /app/environments/dev/*end/config/main-local.php

info "Prepare root password for MySQL"
debconf-set-selections <<<"mysql-community-server mysql-community-server/root-pass password \"''\""
debconf-set-selections <<<"mysql-community-server mysql-community-server/re-root-pass password \"''\""
echo "Done!"

info "Add ppa:ondrej/php"
add-apt-repository -y ppa:ondrej/php

info "Add Oracle JDK repository"
sudo apt-get update
sudo apt-get install openjdk-8-jdk-headless -y

info "Add ElasticSearch sources"
wget -qO - https://artifacts.elastic.co/GPG-KEY-elasticsearch | sudo apt-key add -
sudo apt-get install apt-transport-https
echo "deb https://artifacts.elastic.co/packages/6.x/apt stable main" | sudo tee -a /etc/apt/sources.list.d/elastic-6.x.list

sudo apt-get update && sudo apt-get install -y elasticsearch

sudo sed -i 's/-Xms2g/-Xms64m/' /etc/elasticsearch/jvm.options
sudo sed -i 's/-Xmx2g/-Xmx64m/' /etc/elasticsearch/jvm.options

sudo systemctl daemon-reload
sudo systemctl enable elasticsearch.service
sudo systemctl start elasticsearch.service

info "Install Redis"
apt-get install -y redis-server

info "Install additional software"
apt-get install -y php7.4-curl php7.4-cli php7.4-intl php7.4-mysqlnd php7.4-gd php7.4-fpm php7.4-mbstring php7.4-xml php7.4-zip unzip nginx mysql-server-5.7 php7.4-xdebug

info "Update OS software"
apt-get update
apt-get upgrade -y

info "Configure MySQL"
sed -i "s/.*bind-address.*/bind-address = 0.0.0.0/" /etc/mysql/mysql.conf.d/mysqld.cnf
mysql -uroot <<<"CREATE USER 'root'@'%' IDENTIFIED BY ''"
mysql -uroot <<<"GRANT ALL PRIVILEGES ON *.* TO 'root'@'%'"
mysql -uroot <<<"DROP USER 'root'@'localhost'"
mysql -uroot <<<"FLUSH PRIVILEGES"
echo "Done!"

info "Configure PHP-FPM"
sed -i 's/user = www-data/user = vagrant/g' /etc/php/7.4/fpm/pool.d/www.conf
sed -i 's/group = www-data/group = vagrant/g' /etc/php/7.4/fpm/pool.d/www.conf
sed -i 's/owner = www-data/owner = vagrant/g' /etc/php/7.4/fpm/pool.d/www.conf
cat <<EOF >/etc/php/7.4/mods-available/xdebug.ini
zend_extension=xdebug.so
xdebug.remote_enable=1
xdebug.remote_connect_back=1
xdebug.remote_port=9000
xdebug.remote_autostart=1
EOF
echo "Done!"

info "Configure NGINX"
sed -i 's/user www-data/user vagrant/g' /etc/nginx/nginx.conf
echo "Done!"

info "Enabling site configuration"
ln -s /app/vagrant/nginx/app.conf /etc/nginx/sites-enabled/app.conf
echo "Done!"

info "Initailize databases for MySQL"
mysql -uroot <<<"CREATE DATABASE shop"
mysql -uroot <<<"CREATE DATABASE shop_test"
echo "Done!"

info "Install composer"
curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
