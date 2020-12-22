ALTER TABLE `products` ADD `rating` DOUBLE(8,2) NOT NULL DEFAULT '0' AFTER `slug`;

ALTER TABLE `reviews` ADD `status` INT(1) NOT NULL DEFAULT '1' AFTER `comment`;

ALTER TABLE `orders` ADD `coupon_discount` DOUBLE(8,2) NOT NULL DEFAULT '0' AFTER `grand_total`;

INSERT INTO `business_settings` (`id`, `type`, `value`, `created_at`, `updated_at`) VALUES (NULL, 'coupon_system', '0', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);

INSERT INTO `business_settings` (`id`, `type`, `value`, `created_at`, `updated_at`) VALUES (NULL, 'current_version', '1.4', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);

ALTER TABLE `banners` ADD `position` INT NOT NULL DEFAULT '1' AFTER `url`;

ALTER TABLE `brands` ADD `top` INT(1) NOT NULL DEFAULT '0' AFTER `logo`;

ALTER TABLE `categories` ADD `top` INT(1) NOT NULL DEFAULT '0' AFTER `featured`;

CREATE TABLE `coupons` (
  `id` int(11) NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `details` longtext COLLATE utf8_unicode_ci NOT NULL,
  `discount` double(8,2) NOT NULL,
  `discount_type` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `start_date` int(15) NOT NULL,
  `end_date` int(15) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE `coupons` ADD PRIMARY KEY (`id`);

ALTER TABLE `coupons` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

CREATE TABLE `coupon_usages` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `coupon_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE `coupon_usages` ADD PRIMARY KEY (`id`);
ALTER TABLE `coupon_usages` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

CREATE TABLE `tickets` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `subject` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `details` longtext COLLATE utf8_unicode_ci NOT NULL,
  `viewed` int(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE `tickets` ADD PRIMARY KEY (`id`);

ALTER TABLE `tickets` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

CREATE TABLE `ticket_replies` (
  `id` int(11) NOT NULL,
  `ticket_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `reply` longtext COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE `ticket_replies` ADD PRIMARY KEY (`id`);

ALTER TABLE `ticket_replies` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
