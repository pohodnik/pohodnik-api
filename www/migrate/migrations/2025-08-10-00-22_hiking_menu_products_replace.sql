CREATE TABLE `hiking_menu_products_replace` (
    `id` INT(9) NOT NULL AUTO_INCREMENT ,
    `id_hiking` INT(9) NOT NULL ,
    `id_source_product` INT(9) NOT NULL ,
    `id_target_product` INT(9) NOT NULL ,
    `rate` FLOAT(4,2) NOT NULL,
    `comment` VARCHAR(255) NOT NULL ,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ,
    `creator_id` INT(9) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE = InnoDB COMMENT = 'Замены продуктов';

ALTER TABLE `hiking_menu_products_replace`
  ADD KEY `fk_hiking_menu_products_replace_id_source_product` (`id_source_product`),
  ADD KEY `fk_hiking_menu_products_replace_id_target_product` (`id_target_product`),
  ADD KEY `fk_hiking_menu_products_replace_id_hiking` (`id_hiking`),
  ADD KEY `fk_hiking_menu_products_replace_creator_id` (`creator_id`)
;

ALTER TABLE `hiking_menu_products_replace` ADD CONSTRAINT `fkey_hiking_menu_products_replace_id_hiking` FOREIGN KEY (`id_hiking`) REFERENCES `hiking` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE `hiking_menu_products_replace` ADD CONSTRAINT `fkey_hiking_menu_products_replace_id_source_product` FOREIGN KEY (`id_source_product`) REFERENCES `recipes_products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE `hiking_menu_products_replace` ADD CONSTRAINT `fkey_hiking_menu_products_replace_id_target_product` FOREIGN KEY (`id_target_product`) REFERENCES `recipes_products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE `hiking_menu_products_replace` ADD CONSTRAINT `fkey_hiking_menu_products_replace_creator_id` FOREIGN KEY (`creator_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE;


