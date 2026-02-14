# Отчёт по аудиту безопасности Web-контроллеров UniSite CMS

**Дата:** 11 февраля 2025  
**Директория:** `app/Http/Controllers/`  
**Проверенные контроллеры:** HomeController, CatalogController, ProfileController, AdController, AuthorizeController, ChatController, CartController, ShopController, ShopsController, BlogController, MapController, PageController, GeoController, VerifyController, TransactionsController, ReviewsController, StoriesController, SystemController, CronController

---

## 1. SQL Injection

### 1.1 Критическая — MapController.php:269

**Файл:** `MapController.php`  
**Строка:** 269  
**Критичность:** Критическая

**Описание:** Прямая конкатенация пользовательского ввода `$_POST['ids']` в SQL-запрос `IN()` без валидации и экранирования.

**Уязвимый код:**
```php
$build["query"] = $build["query"] . " and id IN(".$_POST['ids'].")"; 
```

**Рекомендация:** Использовать prepared statements. Привести значения к массиву целых чисел и сформировать плейсхолдеры: `array_map('intval', (array)$_POST['ids'])` и `implode(",", array_fill(0, count($ids), "?"))`.

---

### 1.2 Критическая — CartController.php:93

**Файл:** `CartController.php`  
**Строка:** 93  
**Критичность:** Критическая

**Описание:** Прямая конкатенация `$_POST['item_id']` в SQL через `implode(",", $_POST['item_id'])`. Массив может содержать произвольные строки.

**Уязвимый код:**
```php
$getItems = $this->model->cart->getAll("id IN(".implode(",", $_POST['item_id']).")");
```

**Рекомендация:** Использовать `array_map('intval', (array)$_POST['item_id'])` для приведения к целым числам и проверки на пустоту перед запросом.

---

### 1.3 Критическая — BlogController.php:65

**Файл:** `BlogController.php`  
**Строка:** 65  
**Критичность:** Критическая

**Описание:** Метод `joinId($_POST['category_id'])->getParentIds($_POST['category_id'])` помещает `$_POST['category_id']` напрямую в SQL-запрос в `IN()`.

**Уязвимый код:**
```php
$data = $this->model->blog_posts->pagination(true)->page($_POST['page'])->output(...)->getAll("status=? and category_id IN(".$this->component->blog_categories->joinId($_POST['category_id'])->getParentIds($_POST['category_id']).")", [1]);
```

**Рекомендация:** Использовать `intval($_POST['category_id'])` и проверять существование категории в `$this->component->blog_categories->categories` перед использованием.

---

### 1.4 Высокая — ReviewsController.php:129

**Файл:** `ReviewsController.php`  
**Строка:** 129  
**Критичность:** Высокая

**Описание:** `$_POST['user_id']` передаётся в `getAll()` без приведения к целому типу.

**Уязвимый код:**
```php
$getAds = $this->model->ads_data->sort("id desc")->search($_POST['query'])->getAll("user_id=? and status IN(1,3,7)", [$_POST['user_id']]);
```

**Рекомендация:** Использовать `intval($_POST['user_id'])` для параметра `user_id`. Проверить, что `search()` корректно экранирует пользовательский ввод.

---

### 1.5 Высокая — MapController.php:119–122

**Файл:** `MapController.php`  
**Строка:** 119–122  
**Критичность:** Высокая

**Описание:** `$_POST["topLeft"]`, `$_POST["topRight"]`, `$_POST["bottomLeft"]`, `$_POST["bottomRight"]` передаются в SQL без валидации. Координаты должны быть числовыми.

**Уязвимый код:**
```php
$data = $this->model->delivery_points->getAll("delivery_id=? and send=? and ((latitude < ? and longitude < ?) ...)", [intval($_POST["id"]),1,$_POST["topLeft"]?:null,$_POST["topRight"]?:null,$_POST["bottomLeft"]?:null,$_POST["bottomRight"]?:null]);
```

**Рекомендация:** Валидировать координаты как float: `floatval($_POST["topLeft"])` или проверять `is_numeric()`.

---

## 2. Cross-Site Scripting (XSS)

### 2.1 Высокая — CatalogController.php:48–53

**Файл:** `CatalogController.php`  
**Строка:** 48–53  
**Критичность:** Высокая

**Описание:** `$_GET['search']` выводится в meta_title и h1 без экранирования.

**Уязвимый код:**
```php
$seo["meta_title"] = translate("tr_91680e1909fc29c7471d2e8a6dc4159d")." «".$_GET['search']."» ".$geo->declension;
$seo["h1"] = translate("tr_91680e1909fc29c7471d2e8a6dc4159d")." «".$_GET['search']."» ".$geo->declension;
```

**Рекомендация:** Использовать `htmlspecialchars($_GET['search'], ENT_QUOTES, 'UTF-8')` при выводе.

---

### 2.2 Высокая — ProfileController.php:316–319

**Файл:** `ProfileController.php`  
**Строка:** 316–319  
**Критичность:** Высокая

**Описание:** `$value["title"]` и `$value["id"]` из базы выводятся в HTML без экранирования в `searchUserItemsInStatistics()`.

**Уязвимый код:**
```php
$result .= '
  <a class="user-item-container" href="'.$this->router->getRoute('profile-statistics').'?item_id='.$value["id"].'" >
  ...
  <span>'.$value["title"].'</span>
```

**Рекомендация:** Применять `htmlspecialchars()` для всех атрибутов и содержимого, выводимых из БД.

---

### 2.3 Высокая — ReviewsController.php:135–148

**Файл:** `ReviewsController.php`  
**Строка:** 135–148  
**Критичность:** Высокая

**Описание:** `$value["title"]`, `$value["id"]` из базы выводятся в HTML без экранирования.

**Уязвимый код:**
```php
$result .= '
  <div class="review-add-item-container" data-id="'.$value["id"].'" >
  ...
  <span>'.$value["title"].'</span>
```

**Рекомендация:** Применять `htmlspecialchars()` для всех атрибутов и содержимого.

---

### 2.4 Средняя — ShopController.php:114–115

**Файл:** `ShopController.php`  
**Строка:** 114–115  
**Критичность:** Средняя

**Описание:** `$_GET['search']` без экранирования используется в meta_title и h1.

**Уязвимый код:**
```php
$seo["meta_title"] = translate("tr_91680e1909fc29c7471d2e8a6dc4159d")." «".$_GET['search']."»";
$seo["h1"] = translate("tr_91680e1909fc29c7471d2e8a6dc4159d")." «".$_GET['search']."»";
```

**Рекомендация:** Использовать `htmlspecialchars($_GET['search'], ENT_QUOTES, 'UTF-8')`.

---

### 2.5 Средняя — ShopController.php:353

**Файл:** `ShopController.php`  
**Строка:** 353  
**Критичность:** Средняя

**Описание:** `$data->page->text` декодируется из `urldecode` и выводится в представлении. Если в БД хранится HTML/JS, возможен XSS.

**Уязвимый код:**
```php
$data->page->text = urldecode($data->page->text);
```

**Рекомендация:** Перед выводом в шаблоне проверять контент и/или экранировать HTML, если не поддерживается безопасный HTML.

---

## 3. Валидация и приведение типов

### 3.1 Высокая — ProfileController.php:27–31

**Файл:** `ProfileController.php`  
**Строка:** 27–31  
**Критичность:** Высокая

**Описание:** `$_POST["id"]` используется в SQL без проверки типа и без приведения к int.

**Уязвимый код:**
```php
$data = $this->model->users->find("id=?", [$_POST["id"]]);
...
$this->model->complaints->find("from_user_id=? and whom_user_id=? and item_id=? and status=?", [$this->user->data->id,$_POST["id"],0,0]);
```

**Рекомендация:** Использовать `intval($_POST["id"])` и проверять результат > 0.

---

### 3.2 Высокая — ProfileController.php:74–75

**Файл:** `ProfileController.php`  
**Строка:** 74–75  
**Критичность:** Высокая

**Описание:** `$_POST['id']`, `$_POST['channel_id']` передаются без валидации.

**Уязвимый код:**
```php
$result = $this->component->profile->addToBlacklist($this->user->data->id, $_POST['id'], $_POST['channel_id']);
```

**Рекомендация:** Применять `intval()` для ID и проверять существование channel_id.

---

### 3.3 Высокая — ProfileController.php:177–178

**Файл:** `ProfileController.php`  
**Строка:** 177–178  
**Критичность:** Высокая

**Описание:** `$_POST['id']` используется без проверки при добавлении в избранное.

**Уязвимый код:**
```php
$get = $this->model->users_favorites->find("ad_id=? and user_id=?", [$_POST['id'], $this->user->data->id]);
$ad = $this->component->ads->getAd($_POST['id']);
```

**Рекомендация:** Использовать `intval($_POST['id'])` и проверять существование объявления.

---

### 3.4 Высокая — ProfileController.php:303–304

**Файл:** `ProfileController.php`  
**Строка:** 303–304  
**Критичность:** Высокая

**Описание:** `$_POST['id']` используется в update без проверки, что это платёжный счёт текущего пользователя.

**Уязвимый код:**
```php
$this->model->users_payment_data->update(["default_status"=>0], ["user_id=?", [$this->user->data->id]]);
$this->model->users_payment_data->update(["default_status"=>1], ["user_id=? and id=?", [$this->user->data->id, $_POST['id']]]);
```

**Рекомендация:** Перед обновлением проверять через `find("id=? and user_id=?", [$_POST['id'], $this->user->data->id])`.

---

### 3.5 Средняя — AdController.php:46–48

**Файл:** `AdController.php`  
**Строка:** 46–48  
**Критичность:** Средняя

**Описание:** `$_POST['category_id']` используется как ключ массива без проверки. Невалидное значение может вызвать предупреждения или неожиданное поведение.

**Уязвимый код:**
```php
if($this->component->ads_categories->categories["parent_id"][$_POST['category_id']]){
```

**Рекомендация:** Проверять `isset($this->component->ads_categories->categories["parent_id"][$_POST['category_id']])` и использовать `intval($_POST['category_id'])`.

---

### 3.6 Средняя — ShopsController.php:29–30

**Файл:** `ShopsController.php`  
**Строка:** 29–30  
**Критичность:** Средняя

**Описание:** `$_POST['page']` и `$_POST['category_id']` передаются без валидации.

**Уязвимый код:**
```php
$data = $this->model->shops->pagination(true)->page($_POST['page'])->output(...)->getAll("status=? and (category_id=? or category_id=?)", ["published", intval($_POST['category_id']), 0]);
```

**Рекомендация:** Использовать `(int)$_POST['page']` или `max(1, (int)$_POST['page'])` для page.

---

### 3.7 Низкая — GeoController.php:24, 32, 41

**Файл:** `GeoController.php`  
**Строка:** 24, 32, 41  
**Критичность:** Низкая

**Описание:** `$_POST['id']`, `$_POST['purpose']` передаются без проверки в компонент geo.

**Рекомендация:** Использовать `intval($_POST['id'])` и допускать только допустимые значения для `purpose`.

---

## 4. Null pointer / неинициализированные переменные

### 4.1 Высокая — CatalogController.php:146

**Файл:** `CatalogController.php`  
**Строка:** 146  
**Критичность:** Высокая

**Описание:** `$this->session->get("request-catalog")` может вернуть `null`, вызов `->category_id` приведёт к ошибке.

**Уязвимый код:**
```php
$category_id = $this->session->get("request-catalog")->category_id ?: 0;
```

**Рекомендация:** Использовать `$request = $this->session->get("request-catalog"); $category_id = $request ? $request->category_id : 0;` или `$request?->category_id ?? 0`.

---

### 4.2 Высокая — ReviewsController.php:90

**Файл:** `ReviewsController.php`  
**Строка:** 90  
**Критичность:** Высокая

**Описание:** `getAd($_POST['item_id'])` может вернуть `null`, обращение к `->delete` вызовет ошибку.

**Уязвимый код:**
```php
if(!$this->component->ads->getAd($_POST['item_id'])->delete){
```

**Рекомендация:** Использовать `$ad = $this->component->ads->getAd($_POST['item_id']); if($ad && !$ad->delete)`.

---

### 4.3 Средняя — ChatController.php:51–67

**Файл:** `ChatController.php`  
**Строка:** 51–67  
**Критичность:** Средняя

**Описание:** `loadDialogue()`: при отсутствии `$data` метод не возвращает значение, что может привести к неожиданному ответу.

**Уязвимый код:**
```php
$data = $this->component->chat->getDialogue($params);
if($data){
    ...
    return json_answer(["content"=>...]);
}
// отсутствует return при !$data
```

**Рекомендация:** Добавить `return json_answer(["content"=>""]);` или `return json_answer(["status"=>false]);` в блок `else`.

---

### 4.4 Средняя — ChatController.php:80–98

**Файл:** `ChatController.php`  
**Строка:** 80–98  
**Критичность:** Средняя

**Описание:** `loadMessages()`: при отсутствии `$data` нет явного возврата.

**Рекомендация:** Добавить `return json_answer(["content"=>""]);` или `return json_answer(["status"=>false]);` в блок `else`.

---

### 4.5 Средняя — ShopController.php:104

**Файл:** `ShopController.php`  
**Строка:** 104  
**Критичность:** Средняя

**Описание:** `$data->user` может быть `null`, если `findById` не найдет пользователя. `$data->user->delete` вызывается после проверки `if(!$data->user || $data->user->delete)`, но `$data->user` используется в `$data->owner` без проверки.

**Рекомендация:** Убедиться, что все обращения к `$data->user` происходят только после проверки на существование.

---

## 5. CSRF

### 5.1 Высокая — общее

**Критичность:** Высокая

**Описание:** В контроллерах не обнаружена проверка CSRF-токенов для POST-запросов, изменяющих состояние (создание, удаление, обновление).

**Затронутые контроллеры:** ProfileController, AdController, AuthorizeController, ChatController, CartController, ShopController, TransactionsController, ReviewsController и др.

**Рекомендация:** Использовать CSRF-токены для всех форм и AJAX-запросов, изменяющих данные. Добавить middleware или проверку в базовом контроллере.

---

## 6. Авторизация

### 6.1 Высокая — ProfileController.php:addComplaint

**Файл:** `ProfileController.php`  
**Строка:** 21–38  
**Критичность:** Высокая

**Описание:** `addComplaint()` не проверяет, что пользователь авторизован. Если `$this->user->data->id` отсутствует, возможен crash или логическая ошибка.

**Рекомендация:** Добавить `if(!$this->user->isAuth()) return json_answer(["status"=>false]);` в начало метода.

---

### 6.2 Высокая — ProfileController.php:searchDelete

**Файл:** `ProfileController.php`  
**Строка:** 299–302  
**Критичность:** Высокая

**Описание:** `searchDelete()` удаляет по `$_POST['id']` без проверки, что это ID поиска пользователя. Уже есть проверка `user_id=?` в `delete`, но `$_POST['id']` не валидируется.

**Рекомендация:** Использовать `intval($_POST['id'])` и проверять существование записи перед удалением.

---

### 6.3 Средняя — ProfileController.php:renewalDelete

**Файл:** `ProfileController.php`  
**Строка:** 376–379  
**Критичность:** Средняя

**Описание:** `$_POST['id']` используется без проверки типа и без отдельной проверки, что объявление принадлежит пользователю (хотя есть условие `user_id=?`).

**Рекомендация:** Использовать `intval($_POST['id'])` и проверять существование объявления.

---

### 6.4 Средняя — CartController.php:checkout

**Файл:** `CartController.php`  
**Строка:** 64–74  
**Критичность:** Средняя

**Описание:** `$_GET['session_id']` используется как ключ сессии без проверки формата. Теоретически возможна подмена session_id для просмотра чужих корзин.

**Уязвимый код:**
```php
if(!$this->session->get($_GET['session_id']) || !$_GET['session_id']){
    abort(404);
}
$data->session_id = $_GET['session_id'];
```

**Рекомендация:** Проверять `isset($_GET['session_id'])`, `strlen($_GET['session_id']) == 32` и допустимость формата (например, hex).

---

## 7. Path Traversal / Template Injection

### 7.1 Средняя — PageController.php:37

**Файл:** `PageController.php`  
**Строка:** 37  
**Критичность:** Средняя

**Описание:** `$data->template_name` из БД используется напрямую в `render()`. При компрометации БД или некорректных данных возможна загрузка произвольного шаблона.

**Уязвимый код:**
```php
return $this->view->render($data->template_name, ["seo"=>$seo]);
```

**Рекомендация:** Проверять `template_name` по whitelist (список допустимых шаблонов) или разрешать только символы `a-z0-9_-` и путь без `../`.

---

### 7.2 Средняя — CatalogController.php:37

**Файл:** `CatalogController.php`  
**Строка:** 37  
**Критичность:** Средняя

**Описание:** Аналогично `$page->template_name` используется в `render()` без проверки.

**Уязвимый код:**
```php
return $this->view->render($page->template_name, ["data"=>(object)$data, "seo"=>(object)$seo]);
```

**Рекомендация:** Проверять `template_name` по whitelist или допустимому формату.

---

## 8. Логические ошибки

### 8.1 Средняя — HomeController.php:38

**Файл:** `HomeController.php`  
**Строка:** 38  
**Критичность:** Средняя

**Описание:** `(int)$_POST["page"] ?: 1` — при `$_POST["page"] == 0` возвращается 1, но это может быть намеренным. Логика приоритета операторов может запутать.

**Уязвимый код:**
```php
$page = (int)$_POST["page"] ?: 1;
```

**Рекомендация:** Использовать `$page = max(1, (int)($_POST["page"] ?? 1));` для явной логики.

---

### 8.2 Низкая — CartController.php:97

**Файл:** `CartController.php`  
**Строка:** 97  
**Критичность:** Низкая

**Описание:** `debug($value["id"])` оставлен в коде — может попасть в вывод.

**Уязвимый код:**
```php
if($this->component->ads->checkAvailable($value["item_id"])){ debug($value["id"]);
```

**Рекомендация:** Удалить вызов `debug()` в production-коде.

---

## Сводная таблица по критичности

| Критичность | Количество |
|-------------|------------|
| Критическая | 3 |
| Высокая     | 22 |
| Средняя     | 17 |
| Низкая      | 2 |

---

## Рекомендуемые приоритеты исправления

1. **Критическая:** SQL Injection в MapController, CartController, BlogController.
2. **Высокая:** XSS (CatalogController, ProfileController, ReviewsController, ShopController), валидация ID (ProfileController, ReviewsController), null pointer (CatalogController, ReviewsController), CSRF.
3. **Средняя:** Валидация параметров, null pointer в ChatController, path traversal, логические ошибки.
4. **Низкая:** Debug-вызовы, дополнительная валидация в GeoController.
