-- Удаление неиспользуемых столбцов из uni_ads_data.
-- Контакты и способ связи задаются в настройках профиля (uni_users_contacts_visibility).
-- Выполнить один раз на существующей БД (phpMyAdmin, mysql и т.д.).

ALTER TABLE `uni_ads_data`
  DROP COLUMN `contact_method`,
  DROP COLUMN `contacts`;
