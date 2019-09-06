-- DATABASE `gatehouse`
USE gatehouse;

-- townhouse
-- все коттеджные поселки в базе

-- pipelines
-- очереди застройки (hardcoded)

CREATE TABLE pipelines (
    `id` INT NOT NULL AUTO_INCREMENT,
    `name` varchar(40) NULL,
    `townhouse` INT DEFAULT 1 NOT NULL,
    CONSTRAINT pipeline_PK PRIMARY KEY (`id`)
)
    ENGINE=InnoDB
    DEFAULT CHARSET=utf8
    COLLATE=utf8_general_ci;
CREATE INDEX pipeline_name_IDX USING HASH ON pipelines (`name`);

INSERT INTO pipelines (`name`, `townhouse`) VALUES ('Очередь 1', 1), ('Очередь 2-3', 1);

-- allotments
-- дачные участки

CREATE TABLE allotments (
    `id` INT NOT NULL AUTO_INCREMENT,
    `pipeline` INT NULL,
    `name` INT NULL,
    `owner` varchar(100) NULL,
    `status` enum('allowed', 'restricted') DEFAULT 'allowed' NOT NULL,
    CONSTRAINT allotments_PK PRIMARY KEY (`id`)
)
    ENGINE=InnoDB
    DEFAULT CHARSET=utf8
    COLLATE=utf8_general_ci;
CREATE UNIQUE INDEX `allotments_pipeline_and_index` USING BTREE ON allotments (`pipeline`,`name`);

-- vehicles
-- транспортные средства
CREATE TABLE transport (
    id INT NOT NULL AUTO_INCREMENT,
    id_allotment INT NULL,
    pass_unlimited TINYINT DEFAULT 0 NOT NULL,
    pass_expiration DATE NULL,
    transport_number varchar(100) NULL,
    phone_number_temp varchar(100) NULL,
    CONSTRAINT transport_PK PRIMARY KEY (id)
)
ENGINE=InnoDB
DEFAULT CHARSET=utf8
COLLATE=utf8_general_ci;

-- phones
-- телефоны
CREATE TABLE phones (
    id INT NOT NULL AUTO_INCREMENT,
    id_allotment INT NULL,
    phone_number varchar(100) NULL,
    CONSTRAINT phones_PK PRIMARY KEY (id)
)
    ENGINE=InnoDB
    DEFAULT CHARSET=utf8
    COLLATE=utf8_general_ci;
CREATE FULLTEXT INDEX phones_phone_number_IDX ON phones (phone_number);
CREATE INDEX phones_id_allotment_IDX USING BTREE ON phones (id_allotment);
CREATE UNIQUE INDEX phones_id_allotment___phone USING BTREE ON gatehouse.phones (id_allotment,phone_number);



