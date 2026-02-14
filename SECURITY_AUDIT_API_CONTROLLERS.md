# Отчёт по аудиту безопасности API-контроллеров UniSite CMS

**Дата:** 11 февраля 2025  
**Директория:** `app/Http/Controllers/Api/`  
**Проверенные контроллеры:** AdCardController, AdController, AdsController, AuthorizeController, BookingController, CartController, CatalogController, ChatController, DealController, DeliveryController, FiltersController, GeoController, ProfileController, ReferralController, ReviewsController, SettingsController, ShopController, ShopsController, StorageController, StoriesController, TransactionsController, UserController, VerifyController, BlogController

**Примечание:** API контроллеры более критичны для безопасности, так как часто используются мобильными приложениями, могут не иметь CSRF защиты и возвращают JSON с потенциально чувствительными данными.

---

## 1. SQL Injection

### 1.1 Критическая — CatalogController.php:31, 46, 530

**Файл:** `CatalogController.php`  
**Строки:** 31, 46, 530  
**Критичность:** Критическая

**Описание:** Массивы `$ids` из `ads_views`, `users_favorites` и `$_GET['ids']` из `_json_decode` передаются в SQL через `implode(",", $ids)` без приведения к целым числам. Пользовательский ввод может содержать произвольные строки.

**Уязвимый код:**
```php
$getAds = $this->model->ads_data->getAll("id IN(".implode(",", $ids).") and status=?", [1]);
$getAds = $this->model->ads_data->getAll("id IN(".implode(",", $ids).") and status=?", [1]);
$data = $this->model->ads_data->getAll("status=? and id IN(".implode(",", $ids).")", [1]);
```

**Рекомендация:** Использовать `array_map('intval', $ids)` для приведения к целым числам и проверки на пустоту перед запросом. Для `getAdsByIds` — `$ids = array_map('intval', (array)$_GET['ids'])` и `array_filter($ids)`.

---

### 1.2 Критическая — AdCardController.php:305

**Файл:** `AdCardController.php`  
**Строка:** 305  
**Критичность:** Критическая

**Описание:** Метод `joinId($ad->category_id)->getParentIds($ad->category_id)` возвращает строку для `IN()`. Хотя `$ad->category_id` из БД, в `getSimilars` используется `$ad` из `getAd($_GET['id'])` — `$_GET['id']` не валидируется. Кроме того, `getParentIds` в компоненте может формировать SQL небезопасно.

**Уязвимый код:**
```php
$data = $this->model->ads_data->sort("id desc")->getAll("category_id IN(".$this->component->ads_categories->joinId($ad->category_id)->getParentIds($ad->category_id).") and status=? and id!=?", [1,$ad->id]);
```

**Рекомендация:** Валидировать `$_GET['id']` через `intval($_GET['id'])` перед вызовом `getAd()`. Проверить реализацию `joinId` и `getParentIds` в компоненте — они должны возвращать только числовые ID.

---

### 1.3 Критическая — BlogController.php:29

**Файл:** `BlogController.php`  
**Строка:** 29  
**Критичность:** Критическая

**Описание:** `$_GET['cat_id']` передаётся напрямую в `joinId($_GET['cat_id'])->getParentIds($_GET['cat_id'])` без валидации. Возможна SQL Injection если метод формирует запрос небезопасно.

**Уязвимый код:**
```php
$data = $this->model->blog_posts->pagination(true)->page($page)->output(...)->getAll("status=? and category_id IN(".$this->component->blog_categories->joinId($_GET['cat_id'])->getParentIds($_GET['cat_id']).")", [1]);
```

**Рекомендация:** Использовать `$cat_id = intval($_GET['cat_id'])` и проверять существование категории в `$this->component->blog_categories->categories` перед использованием.

---

### 1.4 Высокая — BookingController.php:219

**Файл:** `BookingController.php`  
**Строка:** 219  
**Критичность:** Высокая

**Описание:** Массив `$dates` формируется из `$listDates` и подставляется в SQL: `date IN(".implode(",", $dates).")`. Хотя `$listDates` формируется методом `getDaysBetweenDates`, значения обёрнуты в кавычки `"'$value'"` — при некорректных данных возможна инъекция.

**Уязвимый код:**
```php
$dates[] = "'$value'";
if($this->model->booking_dates->count("ad_id=? and date IN(".implode(",", $dates).")", [$ad->id])){
```

**Рекомендация:** Использовать prepared statements с плейсхолдерами для каждого значения даты или валидировать формат даты (Y-m-d) перед использованием.

---

### 1.5 Высокая — DealController.php:118

**Файл:** `DealController.php`  
**Строка:** 118  
**Критичность:** Высокая

**Описание:** `$app->settings->integration_delivery_services_active` — массив из настроек — подставляется в `implode(",", ...)` без проверки. При компрометации настроек или некорректных данных возможна инъекция.

**Уязвимый код:**
```php
$data = $app->model->system_delivery_services->getAll("status=? and id IN(".implode(",", $app->settings->integration_delivery_services_active).")", [1]);
```

**Рекомендация:** Использовать `array_map('intval', (array)$app->settings->integration_delivery_services_active)` для приведения ID к целым.

---

### 1.6 Высокая — ProfileController.php:57

**Файл:** `ProfileController.php`  
**Строка:** 57  
**Критичность:** Высокая

**Описание:** `$items_ids` из `_json_decode($value["items_id"])` (данные из БД) подставляется в `getAll("id IN(".$items_ids.")", [])` без приведения к int. При компрометации БД или некорректных данных возможна инъекция.

**Уязвимый код:**
```php
$items_ids = implode(",", _json_decode($value["items_id"]));
$getItems = $this->model->users_tariffs_items->getAll("id IN(".$items_ids.")", []);
```

**Рекомендация:** Использовать `array_map('intval', _json_decode($value["items_id"]))` и `implode(",", array_filter($items_ids))`.

---

### 1.7 Высокая — CatalogController.php:484, 509

**Файл:** `CatalogController.php`  
**Строки:** 484, 509  
**Критичность:** Высокая

**Описание:** `$topLeft`, `$topRight`, `$bottomLeft`, `$bottomRight` из `$_GET` передаются в SQL как координаты без валидации. Должны быть числовыми (float).

**Уязвимый код:**
```php
$build["params"][] = $topLeft;     
$build["params"][] = $topRight;
// ...
$data = $this->model->ads_data->sort($sort)->getAll($build["query"], $build["params"]);
```

**Рекомендация:** Валидировать: `floatval($_GET["top_left"])`, `is_numeric()` или использовать `filter_var` с FILTER_VALIDATE_FLOAT.

---

### 1.8 Высокая — DeliveryController.php:45

**Файл:** `DeliveryController.php`  
**Строка:** 45  
**Критичность:** Высокая

**Описание:** Координаты `$_GET["topLeft"]`, `$_GET["topRight"]`, `$_GET["bottomLeft"]`, `$_GET["bottomRight"]` передаются в SQL без валидации.

**Уязвимый код:**
```php
$data = $this->model->delivery_points->getAll("delivery_id=? and ((latitude < ? and longitude < ?) and (latitude > ? and longitude > ?))", [(int)$_GET["id"],$_GET["topLeft"]?:null,$_GET["topRight"]?:null,$_GET["bottomLeft"]?:null,$_GET["bottomRight"]?:null]);
```

**Рекомендация:** Использовать `floatval($_GET["topLeft"])` или проверять `is_numeric()` для всех координат.

---

### 1.9 Высокая — GeoController.php:22-32

**Файл:** `GeoController.php`  
**Строки:** 22-32  
**Критичность:** Высокая

**Описание:** `$_GET['lat']` и `$_GET['lon']` используются в математических вычислениях и SQL без валидации. При некорректных значениях возможны ошибки или инъекция.

**Уязвимый код:**
```php
$latitude = $_GET['lat'];
$longitude = $_GET['lon'];
// ...
$city = $this->model->geo_cities->find("(`latitude` BETWEEN ? AND ?) AND (`longitude` BETWEEN ? AND ?) and status=?", [$min_lat,$max_lat,$min_lon,$max_lon,1]);
```

**Рекомендация:** Использовать `floatval($_GET['lat'])` и `floatval($_GET['lon'])` с проверкой диапазона (-90 до 90 для lat, -180 до 180 для lon).

---

## 2. XSS (Cross-Site Scripting)

### 2.1 Средняя — API возвращает JSON

**Критичность:** Средняя (ниже чем для Web)

**Описание:** API возвращает JSON. Риск XSS при отображении в мобильном приложении или веб-клиенте зависит от обработки на клиенте. Данные из БД (`html_entity_decode`, `title`, `text`) передаются без дополнительной санитизации.

**Затронутые:** AdCardController (title, text), ReviewsController (text), ShopController (title, text), BlogController (content) и др.

**Рекомендация:** Клиент должен экранировать HTML при отображении. На сервере — не использовать `html_entity_decode` для пользовательского контента без необходимости; при необходимости — применять `strip_tags` или HTML Purifier для безопасного HTML.

---

### 2.2 Средняя — AdCardController.php:191

**Файл:** `AdCardController.php`  
**Строка:** 191  
**Критичность:** Средняя

**Описание:** `$ad->geo ? $value->geo->name` — переменная `$value` в этом контексте — последний элемент из цикла `foreach ($propertyArray as $name => $value)`. Ошибка: должна быть `$ad->geo->name`. Логическая ошибка и возможный вывод некорректных данных.

**Уязвимый код:**
```php
"city_area"=> $ad->geo ? $value->geo->name : null,
```

**Рекомендация:** Заменить на `$ad->geo ? $ad->geo->name : null`.

---

## 3. Валидация входных данных

### 3.1 Высокая — AdCardController.php:36, 48, 249, 250

**Файл:** `AdCardController.php`  
**Строки:** 36, 48, 249, 250  
**Критичность:** Высокая

**Описание:** `$_GET['id']`, `$_POST['id']` используются без приведения к int при вызовах `getAd()`, `fixView()`, `getContacts()`, `addComplaint()` и др.

**Рекомендация:** Использовать `intval($_GET['id'])` и `intval($_POST['id'])` везде, где ожидается ID.

---

### 3.2 Высокая — CartController.php:31, 97, 124, 135, 146

**Файл:** `CartController.php`  
**Строки:** 31, 97, 124, 135, 146  
**Критичность:** Высокая

**Описание:** `$id` в `foreach ($ids as $id => $count)` — ключ из `_json_decode($_GET["ids"])` без валидации. `$_POST['id']` в `deleteItem`, `plusItem`, `minusItem` без проверки типа.

**Рекомендация:** Приводить к int: `array_map('intval', array_keys($ids))` и проверять `$_POST['id']` через `intval($_POST['id'])`.

---

### 3.3 Высокая — ProfileController.php:131, 141, 356, 510, 514

**Файл:** `ProfileController.php`  
**Строки:** 131, 141, 356, 510, 514  
**Критичность:** Высокая

**Описание:** `$_POST["ad_id"]`, `$_POST["id"]` в `favoritesManage`, `deleteFavorite`, `deleteSearch` без валидации. `$_POST['id']` в `defaultScore`, `deleteScore` без проверки принадлежности.

**Рекомендация:** Использовать `intval()` для всех ID и проверять, что записи принадлежат текущему пользователю.

---

### 3.4 Высокая — UserController.php:171, 172

**Файл:** `UserController.php`  
**Строки:** 171, 172  
**Критичность:** Высокая

**Описание:** `$_POST['whom_user_id']` в `addBlacklist`, `subscribe` передаётся без валидации в компонент.

**Рекомендация:** Использовать `intval($_POST['whom_user_id'])` и проверять существование пользователя.

---

### 3.5 Средняя — AdsController.php:43

**Файл:** `AdsController.php`  
**Строка:** 43  
**Критичность:** Средняя

**Описание:** `$_GET["search"]` передаётся в `build_query` без санитизации. Необходимо проверить, как `buildQuery` обрабатывает поисковый запрос.

**Рекомендация:** Ограничить длину и санитизировать спецсимволы в поисковом запросе.

---

### 3.6 Средняя — ShopsController.php:24

**Файл:** `ShopsController.php`  
**Строка:** 24  
**Критичность:** Средняя

**Описание:** Переменная `$page` не определена перед использованием в `page($page)`.

**Уязвимый код:**
```php
$data = $this->model->shops->pagination(true)->page($page)->output(50)->sort("id desc")->getAll("status=?", ["published"]); 
```

**Рекомендация:** Добавить `$page = (int)($_GET["page"] ?? 1) ?: 1;` перед использованием.

---

## 4. Null pointer / неинициализированные переменные

### 4.1 Критическая — UserController.php:66, 75-76

**Файл:** `UserController.php`  
**Строки:** 66, 75-76  
**Критичность:** Критическая

**Описание:** `$data->user->surname` — переменная `$data` не определена, должна быть `$user->surname`. `$shop` используется в результате, но нигде не инициализируется в методе `getData()`.

**Уязвимый код:**
```php
"surname" => $data->user->surname,
"shop" => $shop ? [
    "id"=>$shop->id,
    ...
] : null,
```

**Рекомендация:** Заменить на `$user->surname`. Добавить `$shop = $this->component->shop->getActiveShopByUserId($user->id);` перед формированием результата.

---

### 4.2 Высокая — ProfileController.php:565

**Файл:** `ProfileController.php`  
**Строка:** 565  
**Критичность:** Высокая

**Описание:** Используется `$app->storage` вместо `$this->storage`. В контексте API-контроллера `$app` может быть не определён (undefined variable).

**Уязвимый код:**
```php
"logo"=>$app->storage->name($shop->image)->host(true)->get(),
```

**Рекомендация:** Заменить на `$this->storage->name($shop->image)->host(true)->get()`.

---

### 4.3 Высокая — AdCardController.php:390

**Файл:** `AdCardController.php`  
**Строка:** 390  
**Критичность:** Высокая

**Описание:** `$ad` может быть `null` (если `find` не найдет запись), но обращение `$ad->status` происходит без проверки. Кроме того, `if($ad->status != 0)` вызовет ошибку при `$ad = null`.

**Уязвимый код:**
```php
$ad = $this->model->ads_data->find("id=? and user_id=?", [$_POST['id'], $_POST['user_id']]);
if($ad->status != 0){
```

**Рекомендация:** Добавить проверку `if(!$ad) return json_answer(["auth"=>true, "status"=>false]);` перед обращением к `$ad->status`.

---

### 4.4 Высокая — ShopController.php:31-32

**Файл:** `ShopController.php`  
**Строки:** 31-32  
**Критичность:** Высокая

**Описание:** `$user` получается из `$shop->user_id` без проверки `$shop` на null. При `!$shop` вызов `$shop->user_id` приведёт к ошибке.

**Уязвимый код:**
```php
$shop = $this->model->shops->find("id=?", [intval($_GET['id'])]);
$user = $this->model->users->find("id=?", [(int)$shop->user_id]);
if(!$shop || !$user || !$this->settings->shops_status){
```

**Рекомендация:** Проверять `$shop` перед обращением: `if(!$shop) return json_answer(["exist"=>false]);` и только затем получать `$user`.

---

### 4.5 Средняя — ShopController.php:124

**Файл:** `ShopController.php`  
**Строка:** 124  
**Критичность:** Средняя

**Описание:** `$value["alias"]` используется, но `$value` в этом контексте — последний элемент из цикла `foreach ($getBanners as $key => $value)`. Должно быть `$shop->alias`.

**Уязвимый код:**
```php
"link"=>$this->component->shop->linkToShopCard($value["alias"]),
```

**Рекомендация:** Заменить на `$this->component->shop->linkToShopCard($shop->alias)`.

---

### 4.6 Средняя — StoriesController.php:106

**Файл:** `StoriesController.php`  
**Строка:** 106  
**Критичность:** Средняя

**Описание:** `$user_id` не определена в методе `updateViewStory()`. Используется в `insert` без объявления.

**Уязвимый код:**
```php
$this->model->stories_media_views->insert(["story_id"=>$story_id, "user_id"=>$user_id?:0, "session_id"=>$session_id?:null]);
```

**Рекомендация:** Определить `$user_id` — например, из авторизации или передать 0, если метод публичный: `$user_id = $this->api->verificationAuth($_POST['token'], $_POST['user_id']) ? $this->model->users->findById($_POST['user_id'])->id : 0;` или `$user_id = 0;`.

---

### 4.7 Средняя — StorageController.php:34, 52, 62

**Файл:** `StorageController.php`  
**Строки:** 34, 52, 62  
**Критичность:** Средняя

**Описание:** Переменная `$upload` может быть не определена, если `_file_put_contents` вернёт false или условие не выполнится. В `return json_answer` используется `$upload["name"]` без проверки.

**Рекомендация:** Проверять успешность `_file_put_contents` и инициализировать `$upload` перед использованием. Добавить `else` с возвратом ошибки.

---

### 4.8 Средняя — ReviewsController.php:272

**Файл:** `ReviewsController.php`  
**Строка:** 272  
**Критичность:** Средняя

**Описание:** `$this->component->ads->getAd(intval($_POST['item_id']))->delete` — при `getAd()` возвращающем `null` возникнет ошибка.

**Уязвимый код:**
```php
if(!$this->component->ads->getAd(intval($_POST['item_id']))->delete){
```

**Рекомендация:** `$ad = $this->component->ads->getAd(intval($_POST['item_id'])); if($ad && !$ad->delete)`.

---

### 4.9 Средняя — ReferralController.php:40, 54

**Файл:** `ReferralController.php`  
**Строки:** 40, 54  
**Критичность:** Средняя

**Описание:** `$user` может быть `null` при `find` не нашедшем пользователя. Обращение `$user->id` вызовет ошибку.

**Рекомендация:** Добавить проверку `if($user)` перед использованием в массиве результата.

---

## 5. Отсутствие проверки авторизации для приватных методов

### 5.1 Высокая — CartController.php:getData, CartController.php:getData (ids)

**Файл:** `CartController.php`  
**Строка:** 20  
**Критичность:** Высокая

**Описание:** `getData()` не требует авторизации. При `$_GET["ids"]` от пользователя можно передать произвольные ID и получить данные о товарах. `$user_id` опционален — логика различает авторизованного и неавторизованного, но без rate limiting возможен перебор.

**Рекомендация:** Рассмотреть ограничение по количеству ID в запросе. Добавить rate limiting для публичных endpoint.

---

### 5.2 Высокая — CatalogController.php:getOffers, getAds, getAdsByIds

**Файл:** `CatalogController.php`  
**Строки:** 20, 337, 533  
**Критичность:** Высокая

**Описание:** `getOffers()` требует auth, но `getAdsByIds()` — публичный. `getAdsByIds` с `$_GET['ids']` без ограничения может привести к DoS (большой запрос) или утечке данных при соединении с SQL Injection.

**Рекомендация:** Ограничить количество ID в `getAdsByIds` (например, max 50). Валидировать формат.

---

### 5.3 Высокая — GeoController.php:location, searchGeoCombined

**Файл:** `GeoController.php`  
**Строки:** 20, 47  
**Критичность:** Высокая

**Описание:** `location()` и `searchGeoCombined()` — публичные без авторизации. `$_GET['query']` передаётся в `searchGeoCombined`/`searchCity` без ограничения длины.

**Рекомендация:** Добавить ограничение длины запроса (например, 100 символов). Rate limiting для геопоиска.

---

### 5.4 Высокая — SettingsController.php:get

**Файл:** `SettingsController.php`  
**Строка:** 20  
**Критичность:** Высокая

**Описание:** `get()` возвращает настройки без авторизации. Необходимо убедиться, что `getSettings()` не возвращает чувствительные данные (API ключи, пароли и т.п.).

**Рекомендация:** Аудит метода `getSettings()` на предмет утечки чувствительных данных.

---

### 5.5 Высокая — VerifyController.php:send, verifyCode, checkVerifyPhone

**Файл:** `VerifyController.php`  
**Строки:** 20, 117, 151  
**Критичность:** Высокая

**Описание:** Методы верификации без rate limiting — возможность перебора кодов или спама SMS/email.

**Рекомендация:** Обязательный rate limiting для verify-методов (например, 5 попыток в минуту на контакт/session).

---

### 5.6 Высокая — AuthorizeController.php:auth, recovery, registration

**Файл:** `AuthorizeController.php`  
**Строки:** 34, 99, 250  
**Критичность:** Высокая

**Описание:** Методы входа без rate limiting — возможны brute-force атаки на пароль.

**Рекомендация:** Rate limiting для auth: блокировка после 5–10 неудачных попыток с одного IP.

---

### 5.7 Средняя — goPartnerLink без проверки auth

**Файл:** `AdCardController.php`  
**Строка:** 352  
**Критичность:** Средняя

**Описание:** При `board_card_who_transition_partner_link != "auth"` метод `goPartnerLink` не проверяет авторизацию. Возвращает `$ad->partner_link` — при необходимости можно ограничить доступ.

**Рекомендация:** Оценить необходимость auth для перехода по партнёрской ссылке.

---

## 6. Утечка чувствительных данных в API ответах

### 6.1 Высокая — Api.php:userFullData

**Файл:** `app/Systems/Api.php` (через ProfileController, AuthorizeController, SettingsController)  
**Критичность:** Высокая

**Описание:** `userFullData` возвращает `payments_score_list` с маскированными номерами карт (`**** **** **** XXXX`), но полные данные decrypt-ятся на сервере. `contacts` — расшифрованные контакты. При утечке ответа API возможен доступ к конфиденциальным данным.

**Рекомендация:** Не возвращать decrypt-данные в ответе. Маскировать всё кроме последних 4 цифр. Для контактов — только необходимые для отображения поля.

---

### 6.2 Высокая — DealController.php:236

**Файл:** `DealController.php`  
**Строка:** 236  
**Критичность:** Высокая

**Описание:** В ответе возвращаются `user_email`, `user_phone` из `booking_order` в расшифрованном виде (`decrypt`).

**Уязвимый код:**
```php
"booking_order"=> $booking_order ? ["user_name"=>$booking_order->user_name,"user_email"=>decrypt($booking_order->user_email),"user_phone"=>decrypt($booking_order->user_phone), ...] : null,
```

**Рекомендация:** Проверять, что запрашивающий — участник сделки (from_user или whom_user). Не возвращать чужие email/phone. Маскировать при необходимости.

---

### 6.3 Средняя — ProfileController.php:getData, getVerificationData

**Файл:** `ProfileController.php`  
**Строки:** 250, 261  
**Критичность:** Средняя

**Описание:** `getVerificationData` возвращает `(array)$data` из `users_verifications` — нужно убедиться, что не возвращаются документы (фото паспорта и т.п.) в полном виде.

**Рекомендация:** Аудит полей `users_verifications` — возвращать только статус и дату, не бинарные данные.

---

### 6.4 Средняя — UserController.php:uniq_hash

**Файл:** `UserController.php`  
**Строка:** 71  
**Критичность:** Средняя

**Описание:** `uniq_hash` возвращается в публичном профиле пользователя. Может использоваться для идентификации — оценить необходимость.

**Рекомендация:** Не возвращать `uniq_hash` в публичном API, если он не нужен для функционала.

---

## 7. Rate limiting отсутствует

### 7.1 Критическая — общее

**Критичность:** Критическая

**Описание:** В API-контроллерах не обнаружена глобальная rate limiting. Отдельные методы (например, `adCreate` использует `checkingBadRequests`, `chat` — `checkingBadRequests`) имеют частичную защиту, но большинство endpoint без ограничений.

**Затронутые:** Все публичные и авторизованные методы.

**Рекомендация:** Внедрить middleware rate limiting для API: по IP для публичных методов (например, 100 req/min), по user_id для авторизованных (300 req/min). Для auth, verify, recovery — строже (5–10/min).

---

## 8. Логические ошибки

### 8.1 Высокая — CartController.php:86-87

**Файл:** `CartController.php`  
**Строки:** 86-87  
**Критичность:** Высокая

**Описание:** В блоке `if($ids[$value["item_id"]])` присваивание `$ids[$value["item_id"]] = $ids[$value["item_id"]]` — тавтология, не обновляет значение.

**Уязвимый код:**
```php
if($ids[$value["item_id"]]){
    $ids[$value["item_id"]] = $ids[$value["item_id"]];
}else{
```

**Рекомендация:** Вероятно, должно быть `$ids[$value["item_id"]] = $value["count"]` или `$ids[$value["item_id"]]` оставить как есть. Уточнить бизнес-логику.

---

### 8.2 Низкая — AdCardController.php:203

**Файл:** `AdCardController.php`  
**Строка:** 203  
**Критичность:** Низкая

**Описание:** `$available_services_ids` не определена в методе `getCard`, используется в `"button_added_services_tariffs" => $available_services_ids ? true : false`.

**Рекомендация:** Инициализировать переменную — например, из `$getActiveServices->ids` или убрать поле из ответа.

---

### 8.3 Низкая — TransactionController.php:64-67

**Файл:** `TransactionsController.php`  
**Строки:** 64-67  
**Критичность:** Низкая

**Описание:** `$items_id` собирается из `$value["id"]` корзины (`cart`), но в `initPaymentCart` передаются ID корзины, а не ID товаров. Необходимо проверить, что `initPaymentCart` ожидает именно ID записей корзины.

**Рекомендация:** Подтвердить контракт API компонента `initPaymentCart`.

---

## 9. Прочие уязвимости

### 9.1 Высокая — StorageController.php: upload без проверки типа файла

**Файл:** `StorageController.php`  
**Строки:** 30-142  
**Критичность:** Высокая

**Описание:** Загрузка base64-изображений по `$_POST["action"]` без проверки MIME-типа и расширения. Злоумышленник может загрузить PHP или другой исполняемый файл, если система не проверяет расширение при сохранении.

**Рекомендация:** Проверять расширение по whitelist (webp, jpg, png, mp4). Проверять содержимое файла (magic bytes). Не сохранять файлы с расширением .php, .phtml и т.д.

---

### 9.2 Высокая — ProfileController.php:addVerification

**Файл:** `ProfileController.php`  
**Строка:** 278  
**Критичность:** Высокая

**Описание:** `$attach` из `$_POST["attach"]` — имена файлов. Используется в `uploadAttachFiles`. Необходимо проверить защиту от path traversal (например, `../../../etc/passwd`).

**Рекомендация:** В `uploadAttachFiles` использовать `basename()` или `pathinfo(..., PATHINFO_FILENAME)` для имён файлов. Проверять допустимые расширения.

---

### 9.3 Средняя — fortuneAddBonus — логика array_search

**Файл:** `ProfileController.php`  
**Строка:** 556  
**Критичность:** Средняя

**Описание:** `array_search($amount, $bonuses)` — при `$amount = 0` `array_search` вернёт индекс 0, что в PHP считается truthy. Но `!$amount` для 0 — true, поэтому условие `array_search($amount, $bonuses) || !$amount` может работать некорректно.

**Уязвимый код:**
```php
if(array_search($amount, $bonuses) || !$amount){
```

**Рекомендация:** Использовать `array_search($amount, $bonuses) !== false` и отдельно проверять `$amount > 0` для избежания фолс-позитивов.

---

## Сводная таблица по критичности

| Критичность | Количество |
|-------------|------------|
| Критическая | 5 |
| Высокая     | 42 |
| Средняя     | 25 |
| Низкая      | 4 |

---

## Рекомендуемые приоритеты исправления

1. **Критическая:** SQL Injection (CatalogController, AdCardController, BlogController); Null pointer (UserController); Undefined variable (ShopsController).
2. **Высокая:** SQL Injection в BookingController, DealController, ProfileController, DeliveryController, GeoController; Валидация ID (AdCardController, CartController, ProfileController, UserController); Null pointer (ProfileController, AdCardController, ShopController, StorageController, ReviewsController, ReferralController); Отсутствие rate limiting; Логическая ошибка (CartController); Утечка данных (DealController).
3. **Средняя:** Ошибки в переменных (ShopController, StoriesController); Формат ответов API; Валидация поиска; Проверка auth.
4. **Низкая:** Мелкие логические ошибки (AdCardController, TransactionsController).

---

## Приложение: проверка getSettings() и userFullData()

Рекомендуется отдельный аудит:
- `$this->api->getSettings()` — какие данные возвращаются;
- `$this->api->userFullData($user)` — полный список полей и их чувствительность.
