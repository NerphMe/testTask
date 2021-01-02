1) http://127.0.0.1:8000/admin/transactionsDashboard --- Дашборд транзакий . Только с правами админа (L:'admin@admin.com', P: 'password').
2)  http://127.0.0.1:8000/admin/dashboard --- Дашбоард обменника . Только с правами админа (L:'admin@admin.com', P: 'password').
3) http://127.0.0.1:8000/exchangerView --- Сам обменник .
4) Вся логика обменника лежит в /app/Http/Controllers/CurrencyExchangeController.php. 
5) Вся логика дашборда лежит в /app/Http/Controllers/AdminController.php.
6) Все роуты в web.php.
7) Получение курсов /app/Http/Console/Commands.
8) Курсы валют лежат - /storage/app/courses.json  - для обычных валют . /storage/app/сritptoCourses.json.
