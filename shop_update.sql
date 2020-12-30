CREATE TABLE `wallets` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `amount` double(8,2) NOT NULL,
  `payment_method` varchar(255) COLLATE utf32_bin NOT NULL,
  `payment_details` longtext COLLATE utf32_bin,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_bin;

ALTER TABLE `wallets` ADD PRIMARY KEY (`id`);

ALTER TABLE `wallets` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

COMMIT;
