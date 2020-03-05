
-- Create Users Table
CREATE TABLE `api_bklib`.`users` ( `id` INT(11) NOT NULL AUTO_INCREMENT , `name` VARCHAR(72) NOT NULL , `email` VARCHAR(72) NOT NULL , `role` SET('1','2','3') NOT NULL DEFAULT '1' COMMENT '1 for junior students 2 for senior students 3 for teachers' , `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , PRIMARY KEY (`id`), UNIQUE `email` (`email`(72))) ENGINE = MyISAM;

-- Create Books Table
CREATE TABLE `api_bklib`.`books` ( `id` INT(11) NOT NULL AUTO_INCREMENT , `isbn` VARCHAR(52) NOT NULL , `title` TINYTEXT NOT NULL , `author` VARCHAR(128) NOT NULL , `description` MEDIUMTEXT NOT NULL , `in_stock` INT(11) NOT NULL DEFAULT '1' , PRIMARY KEY (`id`)) ENGINE = MyISAM;

-- Create lend out table for books lended out logging
CREATE TABLE `api_bklib`.`lend_outs` ( `id` INT(11) NOT NULL AUTO_INCREMENT , `book_id` INT(11) NOT NULL , `recipent_id` INT(11) NOT NULL , `collected` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , `returned` DATETIME NULL DEFAULT NULL , PRIMARY KEY (`id`)) ENGINE = MyISAM;

-- Populate User Table with some dummy data
INSERT INTO `users` (`id`, `name`, `email`, `role`, `create_time`) VALUES (NULL, 'Junior User One', 'userone@booklib.com', '1', CURRENT_TIMESTAMP), (NULL, 'Senior User Two', 'usertwo@booklib.com', '2', CURRENT_TIMESTAMP), (NULL, 'Teacher One', 'teacherone@booklib.com', '3', CURRENT_TIMESTAMP)

-- Populate the Books  Table with some dummy data
INSERT INTO `books` (`id`, `isbn`, `title`, `author`, `description`, `in_stock`) VALUES (NULL, '123456789000', 'The Great First ', 'Author 1', 'This is just a dummy book for the product development', '1'), (NULL, '000987654321', 'The great second ', 'Author 2', 'This is just a dummy book for the product development', '1'), (NULL, '135790864210', 'The great third ', 'Author 3 ', 'This is just a dummy book for the product development', '1')
