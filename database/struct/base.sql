-- DATABASE `gatehouse`

-- townhouse
-- все коттеджные поселки в базе

-- pipelines
-- очереди застройки (hardcoded)

-- allotments
-- дачные участки

CREATE TABLE allotments (
                                      id INT NOT NULL AUTO_INCREMENT,
                                      `pipeline` INT NULL,
                                      `name` INT NULL,
                                      `owner` varchar(100) NULL,
                                      `status` enum('ok', 'restricted') DEFAULT 'ok' NOT NULL,
                                      CONSTRAINT allotments_PK PRIMARY KEY (id)
)
    ENGINE=InnoDB
    DEFAULT CHARSET=utf8
    COLLATE=utf8_general_ci;
CREATE UNIQUE INDEX `allotments_pipeline_and_index` USING BTREE ON allotments (`pipeline`,`name`);




-- vehicles
-- транспортные средства

