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


### cron crontab -e
    
каждые 10 минут
    
    */10 * * * * php /var/www/crypto/yii hello/states 1m
    
каждые 30 минут    
        
    */30 * * * * php /var/www/crypto/yii hello/states 1h
 
каждые 12 часов   
    
    4 */12 * * * php /var/www/crypto/yii hello/states 1d    
   
   
market-cap  Каждые 1 час

    8 */1 * * * php /var/www/crypto/yii hello/market-cap   
   
   
*/10 * * * * php /var/www/crypto/yii hello/states 1m
*/30 * * * * php /var/www/crypto/yii hello/states 1h
4 */12 * * * php /var/www/crypto/yii hello/states 1d
8 */1 * * * php /var/www/crypto/yii hello/market-cap