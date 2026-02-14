# Отчёт по аудиту безопасности системных контроллеров

**Дата:** 11 февраля 2025  
**Область:** `core/controllers/web/*`, `core/controllers/dashboard/*`  
**Примечание:** Папка `core/controllers/api/*` отсутствует в проекте.

---

## Топ-20 наиболее критичных проблем безопасности

### 1. SQL Injection в goCheckout (КРИТИЧНО)

**Файл:** `core/controllers/web/CartController/goCheckout.php`  
**Строка:** 11

```php
$getItems = $this->model->cart->getAll("id IN(".implode(",", $_POST['item_id']).")");
```

**Проблема:** Массив `$_POST['item_id']` вставляется в SQL без валидации и экранирования. Злоумышленник может передать `["1); DROP TABLE cart;--"]` или подобные значения.

**Рекомендация:** Привести все элементы к целым числам: `array_map('intval', $_POST['item_id'])` и проверять диапазон перед использованием.

---

### 2. Path Traversal в uploadAttachFiles (КРИТИЧНО)

**Файл:** `app/Systems/Storage.php` (используется из `disputeAdd.php`, `send.php` (Chat), `reviewCreate.php` и др.)  
**Строка:** 402

```php
if(copy($app->config->storage->temp.'/'.$value, $path.'/'.$generatedName)){
```

**Проблема:** Параметр `$value` (имя файла из `$_POST['attach_files']`) подставляется в путь без проверки. Путь вида `../../../etc/passwd` позволяет читать произвольные файлы с сервера и сохранять их в доступную директорию.

**Рекомендация:** Проверять, что `$value` — простое имя файла без `/`, `\`, `..` и других спецсимволов. Использовать `basename()` и whitelist допустимых символов.

---

### 3. Недостаточная защита от Path Traversal в deleteFile (ВЫСОКИЙ)

**Файл:** `core/controllers/dashboard/FilemanagerController/deleteFile.php`  
**Строка:** 7–11

```php
if(strpos($_POST['name'], "./") !== false || strpos($_POST['name'], "../") !== false){
    return json_answer(['status'=>false]);
}
$this->storage->path('images')->name($_POST['name'])->delete();
```

**Проблема:** Проверка обходится строками вроде `....//`, `..\\`, `%2e%2e%2f` (при декодировании), Unicode-обходами и т.п.

**Рекомендация:** Использовать `realpath()` и проверять, что итоговый путь находится внутри допустимой директории. Либо жёстко ограничить формат имён (например, только alphanumeric + точка).

---

### 4. Отсутствие проверки владельца в changeStatusDeal (ВЫСОКИЙ)

**Файл:** `core/controllers/web/TransactionsController/changeStatusDeal.php`  
**Строка:** 4

```php
$result = $this->component->transaction->changeStatusDeal($_POST["id"], $this->user->data->id, $_POST["status"]);
```

**Проблема:** Нет проверки существования сделки и прав. `$_POST["id"]`, `$_POST["status"]` не валидируются. Возможна подмена статуса чужой сделки и манипуляция бизнес-логикой.

**Рекомендация:** Добавить валидацию `id` и `status`, проверку прав на сделку внутри `changeStatusDeal`.

---

### 5. Отсутствие валидации в disputeClose (ВЫСОКИЙ)

**Файл:** `core/controllers/web/TransactionsController/disputeClose.php`  
**Строка:** 4

```php
$result = $this->component->transaction->changeStatusDeal($_POST["id"], $this->user->data->id, "completed_order");
```

**Проблема:** Любой авторизованный пользователь может передать произвольный `$_POST["id"]` и попытаться завершить чужую сделку.

**Рекомендация:** Валидировать `id` и проверять права на сделку/диспут.

---

### 6. IDOR в searchUserItems (ВЫСОКИЙ)

**Файл:** `core/controllers/web/ReviewsController/searchUserItems.php`  
**Строка:** 10

```php
$getAds = $this->model->ads_data->sort("id desc")->search($_POST['query'])->getAll("user_id=? and status IN(1,3,7)", [$_POST['user_id']]);
```

**Проблема:** `$_POST['user_id']` берётся из запроса без проверки. Пользователь может подобрать чужой `user_id` и получить список объявлений другого пользователя.

**Рекомендация:** Проверять, что поиск идёт только по текущему пользователю или по пользователю, с которым у текущего есть право просмотра (например, есть общая сделка).

---

### 7. Null Pointer в UsersController::delete (ВЫСОКИЙ)

**Файл:** `core/controllers/dashboard/UsersController/delete.php`  
**Строка:** 11–13

```php
$user = $this->model->users->find('id=?', [$_POST['user_id']]);
if($this->user->getRole($user->role_id)->chief){
```

**Проблема:** При несуществующем `$_POST['user_id']` переменная `$user` будет `null`, доступ к `$user->role_id` вызовет фатальную ошибку и возможный DoS.

**Рекомендация:** Добавить проверку `if (!$user) return json_answer([...]);` перед использованием `$user`.

---

### 8. Отсутствие валидации в payment (ВЫСОКИЙ)

**Файл:** `core/controllers/web/CartController/payment.php`  
**Строка:** 9

```php
$items_id = $this->session->get($_POST['session']);
```

**Проблема:** `$_POST['session']` не проверяется. При пустом или некорректном значении `$items_id` может быть null, что приведёт к ошибкам в `initPaymentCart`. Риск подбора session ID.

**Рекомендация:** Проверять наличие и формат `$_POST['session']`, использовать session_id только из controlled context (например, после goCheckout).

---

### 9. Недостаточная валидация в addPaymentScoreUser (ВЫСОКИЙ)

**Файл:** `core/controllers/web/TransactionsController/addPaymentScoreUser.php`  
**Строка:** 7

```php
$result = $this->component->transaction->addPaymentScoreUser($_POST['order_id'], $this->user->data->id, $_POST["score"]);
```

**Проблема:** `$_POST['order_id']` не валидируется. Возможна привязка платёжного счёта к чужому заказу (IDOR).

**Рекомендация:** Проверять, что заказ принадлежит текущему пользователю, и валидировать `order_id` как целое число.

---

### 10. Недостаточная валидация в cancelDeal (ВЫСОКИЙ)

**Файл:** `core/controllers/web/TransactionsController/cancelDeal.php`  
**Строка:** 7

```php
$this->component->transaction->cancelDeal($_POST['order_id'], $this->user->data->id, $_POST["reason"]);
```

**Проблема:** `$_POST['order_id']` и `$_POST['reason']` не валидируются. Внутри `cancelDeal` должна быть проверка владельца, но отсутствие валидации на уровне контроллера создаёт риск.

**Рекомендация:** Валидировать `order_id` (int) и ограничить длину/формат `reason` перед передачей.

---

### 11. Потенциальный SQL Injection в bookingCreateOrder (ВЫСОКИЙ)

**Файл:** `core/controllers/web/AdCardController/bookingCreateOrder.php`  
**Строка:** 76, 79

```php
foreach ($listDates as $key => $value) {
    $dates[] = "'$value'";
}
if($this->model->booking_dates->count("ad_id=? and date IN(".implode(",", $dates).")", [$ad->id])){
```

**Проблема:** `$value` — даты из `getDaysBetweenDates($_POST['date_start'], $_POST['date_end'])`. Если компонент не валидирует формат, возможна SQL-инъекция.

**Рекомендация:** Проверять, что даты в формате `Y-m-d`, и использовать подготовленные выражения или явное приведение к безопасному формату.

---

### 12. Возможная манипуляция ценой в bookingCreateOrder (СРЕДНИЙ)

**Файл:** `core/controllers/web/AdCardController/bookingCreateOrder.php`  
**Строка:** 83–86

```php
if($_POST['order_additional_services']){
    foreach ($_POST['order_additional_services'] as $key => $value) {
        $price += $ad->booking->additional_services[$key]["price"];
    }
}
```

**Проблема:** Ключи `$key` берутся из пользовательского ввода без проверки. Невалидный ключ может вызвать ошибку; несоответствие ключей whitelist — манипуляцию ценой.

**Рекомендация:** Проверять, что `$key` входит в список разрешённых `additional_services` у объявления.

---

### 13. Отсутствие валидации user_id в editBalance (СРЕДНИЙ)

**Файл:** `core/controllers/dashboard/UsersController/editBalance.php`  
**Строка:** 19

```php
$this->component->transaction->manageUserBalance(["user_id"=>$_POST['user_id'], "amount"=>$_POST['amount'], "text"=>$_POST['text']], $_POST['action']);
```

**Проблема:** `$_POST['user_id']` и `$_POST['amount']` могут быть произвольными. Несмотря на контроль доступа, отсутствие валидации повышает риск ошибок и злоупотреблений.

**Рекомендация:** Валидировать `user_id` (int, существующий пользователь), `amount` (число) и `action` (whitelist).

---

### 14. Path Traversal в deliveryAddPoint (СРЕДНИЙ)

**Файл:** `core/controllers/web/ProfileController/deliveryAddPoint.php`  
**Строка:** 6

```php
$point = $this->model->delivery_points->find("id=? and code=? and send=?", [intval($_POST["id"]),$_POST["point_code"], 1]);
```

**Проблема:** `$_POST["point_code"]` передаётся в запрос. Если модель использует его в сыром виде в других местах, возможны инъекции. Стоит проверить использование `point_code` в целом.

**Рекомендация:** Ограничить формат `point_code` (whitelist символов, длина), использовать prepared statements везде.

---

### 15. XSS в searchUser (Dashboard) (СРЕДНИЙ)

**Файл:** `core/controllers/dashboard/ImportExportController/searchUser.php`  
**Строка:** 15

```php
$results .= '<span class="..." data-id="'.$value["id"].'" data-user-name="'.$value["name"].'" ><strong>'.$this->user->name($value).'</strong> ('.$value["email"].')</span>';
```

**Проблема:** `$value["name"]` и `$value["email"]` выводятся в HTML без экранирования. Злонамеренное имя/email может внедрить JavaScript.

**Рекомендация:** Использовать `htmlspecialchars()` для всех пользовательских данных, выводимых в HTML/атрибуты.

---

### 16. XSS в searchUserItems (СРЕДНИЙ)

**Файл:** `core/controllers/web/ReviewsController/searchUserItems.php`  
**Строка:** 16, 23

```php
$result .= '... data-id="'.$value["id"].'" ... <span>'.$value["title"].'</span> ...';
```

**Проблема:** `$value["title"]` выводится без экранирования. При наличии XSS в title объявления может выполниться скрипт.

**Рекомендация:** Экранировать все выводимые поля через `htmlspecialchars()`.

---

### 17. Отсутствие CSRF при profileDelete (СРЕДНИЙ)

**Файл:** `core/controllers/web/ProfileController/profileDelete.php`  
**Строка:** 3–5

```php
$this->user->delete($this->user->data->id);
return json_answer(["status"=>true]);
```

**Проблема:** Нет явной проверки CSRF-токена. При перехвате запроса можно инициировать удаление аккаунта от имени пользователя.

**Рекомендация:** Добавить проверку CSRF-токена для всех деструктивных операций.

---

### 18. Неограниченная загрузка в ckfinder (СРЕДНИЙ)

**Файл:** `core/controllers/web/SystemController/ckfinder.php`  
**Строка:** 4

```php
$resultUpload = $this->storage->files($_FILES['upload'])->path('temp')->extList('images')->deleteOriginal(true)->use("resize")->upload();
```

**Проблема:** Неясно, требуется ли авторизация. При публичном доступе возможна загрузка большого объёма файлов и DoS.

**Рекомендация:** Ограничить доступ только для авторизованных пользователей, добавить rate limiting и проверку размера.

---

### 19. Отсутствие проверки владельца в buyItemCard (СРЕДНИЙ)

**Файл:** `core/controllers/web/TransactionsController/buyItemCard.php`  
**Строка:** 9

```php
$data["ad"] = $this->component->ads->getAd($id);
```

**Проблема:** Параметр `$id` приходит из маршрута. Нужно убедиться, что `getAd` корректно обрабатывает несуществующие ID и не даёт доступ к удалённым/заблокированным объявлениям.

**Рекомендация:** Явно валидировать `$id` (int) и проверять статус объявления в `getAd`.

---

### 20. Невалидируемые параметры в blacklistAdd (СРЕДНИЙ)

**Файл:** `core/controllers/web/ProfileController/blacklistAdd.php`  
**Строка:** 5

```php
$result = $this->component->profile->addToBlacklist($this->user->data->id, $_POST['id'], $_POST['channel_id']);
```

**Проблема:** `$_POST['id']` и `$_POST['channel_id']` не проверяются. Возможны логические ошибки и потенциальные уязвимости внутри `addToBlacklist`.

**Рекомендация:** Валидировать `id` и `channel_id` (тип, диапазон, существование в системе).

---

## Сводная таблица

| № | Критичность | Тип уязвимости | Файл |
|---|-------------|----------------|------|
| 1 | КРИТИЧНО | SQL Injection | CartController/goCheckout.php |
| 2 | КРИТИЧНО | Path Traversal | Storage.php (uploadAttachFiles) |
| 3 | ВЫСОКИЙ | Path Traversal | FilemanagerController/deleteFile.php |
| 4 | ВЫСОКИЙ | IDOR / Business Logic | TransactionsController/changeStatusDeal.php |
| 5 | ВЫСОКИЙ | IDOR | TransactionsController/disputeClose.php |
| 6 | ВЫСОКИЙ | IDOR | ReviewsController/searchUserItems.php |
| 7 | ВЫСОКИЙ | Null Pointer | UsersController/delete.php |
| 8 | ВЫСОКИЙ | Валидация сессии | CartController/payment.php |
| 9 | ВЫСОКИЙ | IDOR | TransactionsController/addPaymentScoreUser.php |
| 10 | ВЫСОКИЙ | Валидация | TransactionsController/cancelDeal.php |
| 11 | ВЫСОКИЙ | SQL Injection | AdCardController/bookingCreateOrder.php |
| 12 | СРЕДНИЙ | Business Logic | AdCardController/bookingCreateOrder.php |
| 13 | СРЕДНИЙ | Валидация | UsersController/editBalance.php |
| 14 | СРЕДНИЙ | Path Traversal | ProfileController/deliveryAddPoint.php |
| 15 | СРЕДНИЙ | XSS | ImportExportController/searchUser.php |
| 16 | СРЕДНИЙ | XSS | ReviewsController/searchUserItems.php |
| 17 | СРЕДНИЙ | CSRF | ProfileController/profileDelete.php |
| 18 | СРЕДНИЙ | Доступ/DoS | SystemController/ckfinder.php |
| 19 | СРЕДНИЙ | Валидация | TransactionsController/buyItemCard.php |
| 20 | СРЕДНИЙ | Валидация | ProfileController/blacklistAdd.php |

---

## Общие рекомендации

1. **Валидация входа:** Все параметры из `$_GET`, `$_POST` и маршрутов проверять на тип, формат и принадлежность (владелец, права).
2. **SQL:** Везде использовать prepared statements; избегать `implode()` с пользовательскими данными в SQL.
3. **Path Traversal:** Строго ограничивать имена файлов (например, `basename()`, whitelist расширений) и проверять итоговый путь через `realpath()`.
4. **XSS:** Выводить пользовательские данные только через `htmlspecialchars()` с кодировкой UTF-8.
5. **CSRF:** Включать CSRF-токены для всех критичных POST-запросов.
6. **Null/ошибки:** Проверять результаты `find()` и `getAd()` перед обращением к свойствам объектов.

---

---

## Дополнительная находка

**Отладочный код в production:** В `core/controllers/web/CartController/goCheckout.php` (строка 15) оставлен вызов `debug($value["id"])`, который может раскрывать внутренние данные в окружении разработки. Рекомендуется удалить перед деплоем.

---

*Отчёт подготовлен в рамках аудита безопасности системных контроллеров проекта.*
