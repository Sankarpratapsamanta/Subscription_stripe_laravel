ALTER TABLE `plans` ADD `product_id` VARCHAR(255) NULL DEFAULT NULL AFTER `stripe_id`;


ALTER TABLE `users` ADD `plan` VARCHAR(255) NULL DEFAULT NULL AFTER `stripe_id`;


ALTER TABLE `users` ADD `stripe_status` VARCHAR(255) NULL DEFAULT NULL AFTER `plan`;


ALTER TABLE `users` ADD `subscription_id` VARCHAR(255) NULL DEFAULT NULL AFTER `stripe_id`;


-- 

ALTER TABLE `users` ADD `sub_start` VARCHAR(255) NULL DEFAULT NULL AFTER `trial_ends_at`;
ALTER TABLE `users` ADD `sub_end` VARCHAR(255) NULL DEFAULT NULL AFTER `sub_start`;


ALTER TABLE `plans` ADD `stripe_id_two` VARCHAR(255) NULL DEFAULT NULL AFTER `stripe_id`;

ALTER TABLE `plans` ADD `stripe_plan_two` VARCHAR(255) NULL DEFAULT NULL AFTER `stripe_plan`;