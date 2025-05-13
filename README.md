
# 🧭 VirexAPulse — микро php-framework 

![PHP](https://img.shields.io/badge/PHP-8.4-blue)
![License](https://img.shields.io/badge/license-MIT-green)
![Coverage](https://img.shields.io/badge/tests-90%25-brightgreen)
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
- Обработка ошибок через кастомные гибкие шаблоны
- Готовый MVC-скелет для удобного старта
- Tailwind в качестве css-фреймворка
- Гибкая и удобная система обработки исключений
- Готовая система аутентификации из коробки 

![Снимок экрана от 2025-05-13 23-40-20](https://github.com/user-attachments/assets/6fb8cdfe-287d-42e7-9063-230bb49cd2d7)


## ⚡ Быстрый старт
Вам понадобится docker.

1) Скачайте репозиторий
- ```git clone https://github.com/gh122R/phpRouter.git  ```

2) Запустите терминал из под корня проекта и запустите docker-контейнеры
- ```docker compose up --build -d```

3) Запустите сборщик tailwind (только для локальной разработки)
- ``` docker compose exec node npm run dev ```  
  Важно! Если вы хотите собрать стили (например, чтобы выложить проект на хостинг), введите:
- ``` docker compose exec node npm run build ```

4) Сервер работает по адресу: ```localhost:8080```.
   Можете перейти по нему для проверки работоспособности.

5) phpMyAdmin находится по адресу ``` localhost:8081 ```

6) MySQL можно найти по порту ``` 33061 ```, а логин и пароль в docker.yml.
## 👾 Жизненный цикл запроса.

Знание жизненного цикла запроса поможет лучше понять, как работает роутер и как можно настраивать его под конкретные задачи. Принцип жизненного цикла запроса в этом роутере схож с Laravel, что облегчает его освоение, если у вас есть опыт работы с этим фреймворком.

Жизненный цикл запроса при позитивном сценарии:

1) Пользователь переходит по маршруту, например /home с заданным HTTP методом GET.
2) Роутер ищет сходство в массиве маршрутов.
3) Когда сходство найдено, он получает все параметры маршрута: заданный HTTP метод, контроллер, либо замыкание и middleware'ы (если они заданы).
4) Проверяется соответсвие между отправленным HTTP-методом и  методом,зарегистрированным в маршруте
5) Параметры маршрута вызываются в обратном порядке, то есть: сначало middleware2, затем middleware1 и в конце - сам контроллер.
6) Пользователь получает результат выполнения метода контроллера.


## 🤖 Архитектура проекта.

Проект построен по паттерну MVC.

1) src\ - основная директория проекта, тут содержатся:
- Views\ - содержит представления (обычные html-ки).
- app\  - директория, в которой хранится логика проекта.
2) app\ включает в себя:
- ErrorHandler.php - класс для удобной обработки ошибок.
- Router.php - класс, реализующий роутер.
- View.php - класс для рендера html'ек.
- web.php - файл, где задаются маршруты.
- Controllers\ - директория для контроллеров.
- Middleware\ - директория  для middleware'ов.
3) public\ - публичная директория проекта, доступная извне. В ней есть файлик index.php, который  объявляет заголовки для CORS, подлючает autloader и прочее. Его основная задача - отображение html.
   Он показывает нужную страничку с помощью обращения в методу handler класса Router:

```
declare(strict_types=1);

require_once dirname(__DIR__) . '/vendor/autoload.php';
require_once dirname(__DIR__) . '/src/app/web.php';

header("Cross-Origin-Opener-Policy: same-origin-allow-popups");
header("Cross-Origin-Embedder-Policy: credentialless");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
global $router;
echo $router->handler($_SERVER['REQUEST_URI']);
```

4) tests\ - директория для тестов.
## Начало работы.

Для того, чтобы задать маршрут нужно перейти в файл web.php.
Внутри него есть подробная инструкция как оформить маршрут.

Пример объявляения маршрута:
``` 
$router->get('/', [HomeController::class, 'index']);
```

Маршруты можно задавать цепочкой, например:
```
$router->get('/', [HomeController::class, 'index'])
       ->get('/test', [HomeController::class, 'index'], [
           [TestMiddleware::class, 'forTest']
       ])
       ->post('/test2', [HomeController::class, 'create'], [
           [TestMiddleware::class, 'index'],
           [TestMiddleware::class, 'empty']
       ]);
```

Как видно из примера, мы просто обращаемся к методу get для регистрации маршрута который будет обрабатывать только HTTP-метод GET. Внутри метода в качестве параметров передаём:

1) Строку с маршрутом.

2) Контроллер, либо замыкание, которое будет вызвано, при переходе на маршрут. Контроллер передаём в массиве, первый элемент которого - класс контроллера, а второй - его метод, который нужно вызвать.

3) Можем указать middleware один или несколько. Указывать их необязательнно. Они также могут быть замыканиями. Важно учесть, что middleware'ы вызываются в обратном порядке, т.е, если вы задали два middleware'а, то сначало будет вызван второй middleware, потом первый, а после - контроллер 🤠.
   Middleware'ы нужно указывать после контроллера в массиве, например:
```
$router->get('/test', [HomeController::class, 'index'], [
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

```
$router->get('/test5', [HomeController::class, 'index'],function (){
    return 'Hello World'; //Hello World выведется на страничку, также, для вывода на страничку, вы можете использовать echo
});
```

### Пример работы роутера :0

![Снимок экрана от 2025-05-02 17-21-03](https://github.com/user-attachments/assets/44df1e03-1503-4bca-a651-4347e23cc403)


## 💡 TODO и планы

- Поддержка именованных маршрутов
- Генерация URL по имени маршрута
