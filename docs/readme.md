### Перед composer install

#### Доустановить php-ext

    sudo apt-get install php7.1-iconv
    sudo apt-get install php7.1-gmp
    sudo apt-get install php7.1-bcmath


### После разворачивания yii

go to /etc/mysql/my.cnf add
    
    ...
    #
    # * IMPORTANT: Additional settings that can override those from this file!
    #   The files must end with '.cnf', otherwise they'll be ignored.
    #
    
    !includedir /etc/mysql/conf.d/
    !includedir /etc/mysql/mysql.conf.d/
    [mysqld]
    sql_mode=ONLY_FULL_GROUP_BY,NO_ZERO_IN_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION
    bind-address = ::ffff:127.0.0.1
    local-infile=0
    
    # Important: remove limitation of group by with the following line
    sql_mode = ""
    ...    

restart the mysql service
 
    sudo systemctl restart mysql




### cron

    crontab -e

Каждые 10

    */10 * * * * php /var/www/crypto/yii hello/index
    
    
Варианты параметра interval 1m, 3m, 5m, 15m, 30m, 1h, 2h, 4h, 6h,8h, 12h, 1d, 3d, 1w, 1M   
    
    
каждые 20 минут
    
    */20 * * * * php /var/www/crypto/yii hello/states 1m
    
каждые 30 минут    
        
    */30 * * * * php /var/www/crypto/yii hello/states 1h
 
каждые 12 часов   
    
    0 */12 * * * php /var/www/crypto/yii hello/states 1d
    
   

