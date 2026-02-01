ALTER TABLE `uni_users`
  ADD COLUMN IF NOT EXISTS `city_id` int NOT NULL DEFAULT '0' AFTER `phone`;

ALTER TABLE `uni_users`
  ADD INDEX IF NOT EXISTS `city_id` (`city_id`);
