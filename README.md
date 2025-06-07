
# 🧭 VirexAPulse — микро php-framework 

![PHP](https://img.shields.io/badge/PHP-8.4-blue)
![License](https://img.shields.io/badge/license-MIT-green)
![Coverage](https://img.shields.io/badge/tests-40%25-brightgreen)
![Docker](https://img.shields.io/badge/docker-ready-blue)
![Tailwind](https://img.shields.io/badge/tailwind-ready-blue)



VirexAPulse - это расширенная версия [VirexA](https://github.com/gh122R/VirexA)

### Почему VirexA?
Потому что писать backend на PHP теперь станет быстро и удобно! VirexA предлагает Laravel-подобную маршрутизацию, но без тяжеловесных зависимостей.

### Вдохновлён

- [Laravel Router](https://laravel.com/docs/routing)

- [Slim](https://www.slimframework.com/)

## 🔥 Возможности
- Поддержка GET и POST маршрутов
- Гибкая система middleware (классы и замыкания)
- Готовые хелперы
- Обработка ошибок через кастомные гибкие шаблоны
- Готовый MVC-скелет для удобного старта
- Tailwind в качестве css-фреймворка
- Гибкая и удобная система обработки исключений
- Готовая система аутентификации из коробки 

![welcome page](https://github.com/user-attachments/assets/6fb8cdfe-287d-42e7-9063-230bb49cd2d7)


## ⚡ Быстрый старт
Вам понадобится docker.

1) Скачайте репозиторий
```
git clone https://github.com/gh122R/phpRouter.git  
```

2) Запустите терминал из под корня проекта и запустите docker-контейнеры
```
docker compose up --build -d
```

3) Запустите сборщик tailwind (только для локальной разработки)
```
docker compose exec node npm run dev
 ```  
  Важно! Если вы хотите собрать стили (например, чтобы выложить проект на хостинг), введите:
```
 docker compose exec node npm run build 
```

4) Сервер работает по адресу: ```localhost:8080```.


5) phpMyAdmin находится по адресу ``` localhost:8081 ```


6) MySQL можно найти по порту ``` 33061 ```, а логин и пароль в docker.yml.
## 👾 Жизненный цикл запроса

Принцип жизненного цикла запроса в этом роутере схож с Laravel, что облегчает его освоение, если у вас есть опыт работы с этим фреймворком.

Жизненный цикл запроса при позитивном сценарии:

1) Пользователь переходит по маршруту, например /home с заданным HTTP методом GET.
2) Роутер ищет сходство в массиве маршрутов.
3) Когда сходство найдено, он получает все параметры маршрута: заданный HTTP метод, контроллер, либо замыкание и middleware'ы (если они заданы).
4) Проверяется соответсвие между отправленным HTTP-методом и  методом,зарегистрированным в маршруте
5) Параметры маршрута вызываются в обратном порядке, то есть: сначало middleware2, затем middleware1 и в конце - сам контроллер.
6) Пользователь получает результат выполнения метода контроллера.


##  Архитектура проекта

Проект построен по паттерну MVC.

1) src\ - рабочая директория проекта, тут содержатся:
- Views\ - содержит представления (обычные html-ки, так и php).
- Controllers
- Models
- css (tailwind.css)
2) app\ включает в себя в себя конфигурацию и ядро проекта.


3) public\ - публичная директория проекта, доступная извне. В ней есть файлик index.php, который  объявляет заголовки для CORS, подлючает autloader и прочее. Его основная задача - отображение html.
   Он показывает нужную страничку с помощью обращения в методу handler фасада Route:

```php
<?php

declare(strict_types=1);
use App\Core\Facades\Route;

session_start();
require_once dirname(__DIR__) . '/vendor/autoload.php';
require_once dirname(__DIR__) . '/src/app/config.php';
require_once dirname(__DIR__) . '/src/web.php';

echo Route::handler($_SERVER['REQUEST_URI']);

```

4) tests\ - директория для тестов.
## Начало работы

Для того, чтобы задать маршрут нужно перейти в файл web.php.
Внутри него есть подробная инструкция как оформить маршрут.

Пример объявления маршрута:
```php 
Route::get('/home/{id}', [HomeController::class, 'index']);
```

Если вы хотите просто возвратить страничку, то можно воспользоваться методом view.
```php
Route::view('/', 'welcome');
```

Как видно из примера, мы просто обращаемся к методу get для регистрации маршрута который будет обрабатывать только HTTP-метод GET. Внутри метода в качестве параметров передаём:

1) Строку с маршрутом.

2) Контроллер, либо замыкание, которое будет вызвано, при переходе на маршрут. Контроллер передаём в массиве, первый элемент которого - класс контроллера, а второй - его метод, который нужно вызвать.

3) Можем указать middleware один или несколько. Указывать их необязательно. Они также могут быть замыканиями. Важно учесть, что middleware'ы вызываются в обратном порядке, т.е, если вы задали два middleware'а, то сначало будет вызван второй middleware, потом первый, а после - контроллер 🤠.
   Middleware'ы нужно указывать после контроллера в массиве, например:
```php
Route::get('/test', [HomeController::class, 'index'], [
    [TestMiddleware::class, 'index'],
    [TestMiddleware::class, 'empty']
]);
 ```
В массиве с middleware'ом можно указать 3 параметра:

1) Класс middleware'а.
2) Его метод.
3) Данные,которые хотите передать в конструктор middleware'а (необязательнно указывать).  
   Первый и второй пункт - обязательны.

Пример с замыканием, вместо middleware'а:

```php
Route::get('/test5', [HomeController::class, 'index'],fn () => 'Hello World';
//Hello World выведется на страничку, также, для вывода на страничку, вы можете использовать echo);
```

## Динамические маршруты

Пример:
```php
Route::get('/home/{id}', [HomeController::class, 'index']);
```

Значение, которое хотим получить указываем в фигурных скобках.
Перейдя по маршруту ``` /home/123 ```, в конструктор контроллера передастся массив:
```php
[
    'id' => 123
]

```

Пример с несколькими динамическими значениями:
```php
Route::get('/home/{id}/profile/{name}', [HomeController::class, 'index']);
```
Переходим по: ``` /home/123/profile/gh122 ```
и в конструктор контроллера передаётся:
```php
[
    'id' => 123,
    'name' => 'gh122'
]
```

## php Blaze

Blaze - это удобный генератор моделей и контроллеров.

1) Создать контроллер:
```
php blaze make:controller Home 
``` 
будет создан класс HomeController в директории src/Controllers
* Можно создать контроллер сразу со всеми crud методами внутри с помощью флага <b>--full</b>:  
```
php blaze make:controller Home --full
``` 

2) Создать модель:  
```
php blaze make:model Home 
``` 
будет создана модель Home в директории src/Models. Она будет включать в себя методы Eloquent ORM.

3) Запустить встроенный сервер php:
```
php blaze serve 
``` 

## Хелперы
Хелперы - это небольшие функции, доступные в любом месте проекта.  

1) <b> dd </b> - выполняет отформатированный var_dump переданных аргументов.

```php
dd(...$args) 
```

2) <b> pd </b> - выполняет отформатированный print_r переданных аргументов.

```php
pd (...$args)
 ```

3) <b> view </b> - позволяет отрендерить php/html страничку. Возвращает строку.

```php
view (string $view, array $data = [])
 ```

4) <b> error </b> - позволяет выводить исключения. Возвращает строку.

```php
error (string $message, string $view = '', string $dangerLevel = "Критическая ошибка", string $description = '')
```

5) <b> redirect </b> - выполняет перенаправление на маршрут и позволяет передать сообщение, которое будет доступно определённое время (по умолчанию 5 сек.).

```php
redirect (string $url, array $data = [], int $messageLifetime = 5)
```
6) <b> getMessage </b> - позволяет получить сообщение, при использовании redirect()

```php
getMessage(string $key = '')
```

#### Пример использования

Например, есть два маршрута
```php
Route::get('/test', fn() => view('test', ['Variable' => '123'])); // маршрут отрендерит test.html(php) 
Route::get('/redirect', fn() => redirect('/test', ['message' => 'Hi!'],1)); // создаём перенаправление на /test и передаём сообщение, которое будет доступно 1 секунду
```

- По маршруту /test мы возвращаем php/html страничку и передаём ей переменную $Variable со значением 123.
- А /redirect перенаправляет нас на /test и передаёт сообщение, доступное по ключу "message"

Вот, как должен выглядеть test.html (или test.php), чтобы вывести $Variable и message
```html
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Test</title>
</head>
<body>
<p><?= $Variable ?></p>
<p><?php echo getMessage('message'); ?></p>
</body>
</html>
```
Кстати, при использовании getMessage не нужно проверять сообщение на предмет существования, это сделает сама функция :) 


![Пример работы роутера](https://github.com/user-attachments/assets/44df1e03-1503-4bca-a651-4347e23cc403)


## 💡 TODO и планы

- Поддержка именованных маршрутов
- Генерация URL по имени маршрута
- Разделить ответственность в роутере
