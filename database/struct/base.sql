-- ЭТО НАЧАЛЬНАЯ ИНИЦИАЛИЗАЦИЯ
-- ИСПОЛЬЗОВАТЬ ЭТИ ОПРЕДЕЛЕНИЯ ТОЛЬКО ПРИ ДЕПЛОЕ НОВОГО ПРОЕКТА!!!!
-- УДАЛЯЕТ ТАБЛИЦЫ ПЕРЕД ИХ СОЗДАНИЕМ

-- townhouse
-- pipelines
-- очереди застройки (hardcoded)

-- DROP TABLE `pipelines`;
CREATE TABLE `pipelines` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `name` varchar(40) DEFAULT NULL COMMENT 'Название очереди',
    `id_townhouse` int(11) NOT NULL DEFAULT '1' COMMENT 'ID коттеджного посёлка',
    PRIMARY KEY (`id`),
    KEY `pipeline_name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT 'Таблица очередей застройки';

INSERT INTO pipelines (`name`, `id_townhouse`)
VALUES ('Очередь 1', 1), ('Очередь 2-3', 1);

-- DROP TABLE `allotments`;
CREATE TABLE `allotments` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `id_pipeline` int(11) DEFAULT NULL COMMENT 'id очереди застройки участков',
    `name` int(11) DEFAULT NULL COMMENT 'номер участка (число)',
    `owner` varchar(200) DEFAULT NULL COMMENT 'владелец участка (ФИО)',
    `status` enum('allowed','restricted') DEFAULT NULL COMMENT 'статус допуска на участок',
    PRIMARY KEY (`id`),
    UNIQUE KEY `pipeline_and_allotment` (`id_pipeline`,`name`),
    KEY `id_pipeline` (`id_pipeline`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Таблица коттеджных участков';

-- DROP TABLE `transport`;
CREATE TABLE `transport` (
     `id` int(11) NOT NULL AUTO_INCREMENT,
     `id_allotment` int(11) DEFAULT NULL COMMENT '-> allotment.id',
     `pass_unlimited` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1 - пропуск бессрочный, 0 - на срок',
     `pass_expiration` date DEFAULT NULL COMMENT 'дата окончания действия пропуска',
     `transport_number` varchar(100) DEFAULT NULL COMMENT 'номерной знак транспортного средства',
     `phone_number_temp` varchar(100) DEFAULT NULL COMMENT 'телефон для регистрации временного пропуска',
     PRIMARY KEY (`id`),
     KEY `transport_transport_number` (`transport_number`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT 'Таблица транспортных средств';

-- DROP TABLE `phones`;
CREATE TABLE `phones` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `id_allotment` int(11) DEFAULT NULL COMMENT '-> allotment.id',
    `phone_number` varchar(100) DEFAULT NULL COMMENT 'номер телефона',
    PRIMARY KEY (`id`),
    UNIQUE KEY `unique_phonenumber` (`phone_number`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT 'Таблица телефонных номеров, привязанных к участкам';

