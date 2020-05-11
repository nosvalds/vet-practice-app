ALTER TABLE graduates ADD COLUMN `favourite_beverage` VARCHAR(255);

UPDATE graduates SET favourite_beverage = 'water' WHERE id = 1;
UPDATE graduates SET favourite_beverage = 'coffee' WHERE id = 2;
UPDATE graduates SET favourite_beverage = 'tea' WHERE id = 3;
UPDATE graduates SET favourite_beverage = 'water' WHERE id = 4;
UPDATE graduates SET favourite_beverage = 'herbal tea' WHERE id = 5;

SELECT * FROM graduates;

ALTER TABLE graduates ADD COLUMN last_updated TIMESTAMP;

-- Vet DB
CREATE DATABASE vet_practice;

USE vet_practice;

CREATE TABLE animals (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `full_name` VARCHAR(255),
    `owner_id` INT,
    `dob` DATE
);

CREATE TABLE owners (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `full_name` VARCHAR(255),
    `address` TEXT
);

CREATE TABLE medications (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `pet_id` INT,
    `medication_name` VARCHAR(255),
    `date_started` DATE,
    `cost` DECIMAL
);

INSERT INTO animals (full_name,owner_id,dob) VALUES ('Scruffy', 1, "2000-01-01");


INSERT INTO animals (full_name,owner_id,dob) VALUES ('Bob', 1, "2010-05-06");
INSERT INTO animals (full_name,owner_id,dob) VALUES ('Mr. Bigglesworth', 1, "2015-04-09");
INSERT INTO animals (full_name,owner_id,dob) VALUES ('Carl', 2, "2005-09-09");
INSERT INTO animals (full_name,owner_id,dob) VALUES ('Wally', 3, "2018-01-01");

INSERT INTO owners (full_name,address) VALUES ('Joe Exotic', '123 Weird Farm Rd, Oklahoma, USA');
INSERT INTO owners (full_name,address) VALUES ('Carole Baskin', '456 Shelter Place, Florida, USA');
INSERT INTO owners (full_name,address) VALUES ('Dr. Cult Weiro', '8893 Cult Place Zoo, South Carolina, USA');

INSERT INTO medications (pet_id,medication_name,date_started,cost) VALUES (1,'Ketamine', "2019-10-10", 9.99);
INSERT INTO medications (pet_id,medication_name,date_started,cost) VALUES (1,'Cloroform', "2018-10-10", 19.99);
INSERT INTO medications (pet_id,medication_name,date_started,cost) VALUES (1,'Paracetamol', "2016-10-10", 1.99);
INSERT INTO medications (pet_id,medication_name,date_started,cost) VALUES (2,'Ketamine', "2019-10-10", 9.99);
INSERT INTO medications (pet_id,medication_name,date_started,cost) VALUES (2,'Paracetamol', "2014-10-10", 9.99);
INSERT INTO medications (pet_id,medication_name,date_started,cost) VALUES (3,'Cloroform', "2015-11-10", 9.99);
INSERT INTO medications (pet_id,medication_name,date_started,cost) VALUES (4,'Ketamine', "2019-11-10", 9.99);
INSERT INTO medications (pet_id,medication_name,date_started,cost) VALUES (5,'Paracetamol', "2019-08-10", 9.99);

-- Joining animals and owners
SELECT * FROM animals JOIN owners ON animals.owner_id = owners.id;

SELECT animals.full_name AS pet_name,
       owners.full_name AS owner_name
FROM animals JOIN owners ON animals.owner_id = owners.id;

-- mysql> SELECT animals.full_name AS pet_name,
--     ->        owners.full_name AS owner_name
--     -> FROM animals JOIN owners ON animals.owner_id = owners.id;
-- +------------------+----------------+
-- | pet_name         | owner_name     |
-- +------------------+----------------+
-- | Scruffy          | Joe Exotic     |
-- | Bob              | Joe Exotic     |
-- | Mr. Bigglesworth | Joe Exotic     |
-- | Carl             | Carole Baskin  |
-- | Wally            | Dr. Cult Weiro |
-- +------------------+----------------+

-- Calc birthdate

SELECT full_name, dob,
       TIMESTAMPDIFF(YEAR,dob,CURDATE()) AS age
       FROM animals;
-- +------------------+------------+------+
-- | full_name        | dob        | age  |
-- +------------------+------------+------+
-- | Scruffy          | 2000-01-01 |   20 |
-- | Bob              | 2010-05-06 |   10 |
-- | Mr. Bigglesworth | 2015-04-09 |    5 |
-- | Carl             | 2005-09-09 |   14 |
-- | Wally            | 2018-01-01 |    2 |
-- +------------------+------------+------+
-- 5 rows in set (0.00 sec)

SELECT full_name AS "Pet Name", dob AS "Birthday",
       TIMESTAMPDIFF(YEAR,dob,CURDATE()) AS age
       FROM animals ORDER BY age;

-- +------------------+------------+------+
-- | Pet Name         | Birthday   | age  |
-- +------------------+------------+------+
-- | Wally            | 2018-01-01 |    2 |
-- | Mr. Bigglesworth | 2015-04-09 |    5 |
-- | Bob              | 2010-05-06 |   10 |
-- | Carl             | 2005-09-09 |   14 |
-- | Scruffy          | 2000-01-01 |   20 |
-- +------------------+------------+------+

-- Foreign Keys
ALTER TABLE animals 
    ADD FOREIGN KEY (owner_id)
     REFERENCES owners(id)
    ON DELETE CASCADE;

--     mysql> DESCRIBE animals;
-- +-----------+--------------+------+-----+---------+----------------+
-- | Field     | Type         | Null | Key | Default | Extra          |
-- +-----------+--------------+------+-----+---------+----------------+
-- | id        | int(11)      | NO   | PRI | NULL    | auto_increment |
-- | full_name | varchar(255) | YES  |     | NULL    |                |
-- | owner_id  | int(11)      | YES  | MUL | NULL    |                |
-- | dob       | date         | YES  |     | NULL    |                |
-- +-----------+--------------+------+-----+---------+----------------+
-- 4 rows in set (0.00 sec)

-- mysql> DESCRIBE owners;
-- +-----------+--------------+------+-----+---------+----------------+
-- | Field     | Type         | Null | Key | Default | Extra          |
-- +-----------+--------------+------+-----+---------+----------------+
-- | id        | int(11)      | NO   | PRI | NULL    | auto_increment |
-- | full_name | varchar(255) | YES  |     | NULL    |                |
-- | address   | text         | YES  |     | NULL    |                |
-- +-----------+--------------+------+-----+---------+----------------+


ALTER TABLE medications 
    ADD FOREIGN KEY (pet_id)
     REFERENCES animals(id)
    ON DELETE CASCADE;

--     mysql> DESCRIBE medications;+-----------------+---------------+------+-----+---------+----------------+
-- | Field           | Type          | Null | Key | Default | Extra          |
-- +-----------------+---------------+------+-----+---------+----------------+
-- | id              | int(11)       | NO   | PRI | NULL    | auto_increment |
-- | pet_id          | int(11)       | YES  | MUL | NULL    |                |
-- | medication_name | varchar(255)  | YES  |     | NULL    |                |
-- | date_started    | date          | YES  |     | NULL    |                |
-- | cost            | decimal(10,0) | YES  |     | NULL    |                |
-- +-----------------+---------------+------+-----+---------+----------------+
-- 5 rows in set (0.00 sec)