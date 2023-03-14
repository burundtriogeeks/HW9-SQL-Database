USE `test`;

CREATE TABLE `users` (
                         `id` int(10) UNSIGNED NOT NULL,
                         `name` char(50) NOT NULL,
                         `date_no_index` char(10) NOT NULL,
                         `date_index` char(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

ALTER TABLE `users`
    ADD PRIMARY KEY (`id`),
    ADD KEY `date_index` (`date_index`);

ALTER TABLE `users`
    MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;