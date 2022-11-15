1) POST /api/register - регистрация
```
Параметры:
 name - логин
 password - пароль
 phone - телефон
 email - почта
 type - тип пользователя(user, dentist)
```
2) POST /api/login - логин
```
Параметры:
 name - логин
 password - пароль
```
3) GET /api/users - список пользователей
```
Параметры:
 type - тип пользователя(user, dentist)
```
4) GET /api/services - список услуг
```
```
5) DELETE /api/users/{id} - удалить пользователя
```
Параметры:
 id - id пользователя
```
6) GET /api/schedules - получить список расписаний
```
Параметры:
 dentist_id - id дантиста
 date - дата
```
7) POST /api/schedules - создать запись расписания
```
Параметры:
 dentist_id - id дантиста
 service_id - id услуги
 date - дата
 hour - час
```

7) PUT /api/schedules - обновить запись расписания
```
Параметры:
 id - id расписания
 status_id - id статуса
```
