Это мини kino api сервис, написанный на Laravel. 

(Дамп бд, лежит в корне проекта)

1. Развертка проекта
    1. git clone https://github.com/Kirill-Ryzhkov/kino-api.git
    2. cd kino-api
    3. composer update
    4. composer require laravel/passport
    5. php artisan vendor:publish 
    6. 17
    7. Настройка .env файла, база данных
    8. php artisan migrate
    9. php artisan passport install
    10. Запоминаем Client ID и Client Secret
    11. php artisan serve
    12. localhost:8000/user
    13. В phpMyAdmin разварачиваем бд movies.sql

2. Аутентификация
Аутентификация происходит по уникальному Bearer токену. Для получения токена нужно:
    1. В Postman создаем POST запрос localhost:8000/oauth/token
    2. Во вкладке Body->form-data пишем пары Key - Value
        1. grant_type - password
        2. client_id - (Client ID из пункта 1.10)
        3. client_secret - (Client Secret из пункта 1.10)
        4. username - hey@gmail.com
        5. password - hello123
        6. scope - (ничего не пишем)
    3. Нажимаем Send
    4. В ответе копируем access_token 
    5. Создаем новый GET запрос к нашему api например localhost:8000/api/movies/all
    6. На вкладке Authorization->Type->Bearer Token, Token - access_token (пункт 2.4)
    7. Нажимаем Send

Остальные данные по доступным методам api можно получить по адресу localhost:8000/docs/api/index.html
    
