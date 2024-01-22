CREATE DATABASE IF NOT EXISTS mediBase;

USE mediBase;

CREATE TABLE IF NOT EXISTS `doctors` (
    `id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `name` VARCHAR(50) NOT NULL,
    `birth_date` DATE NULL,
    `gender` ENUM('female','male','other') NULL,
    `nationality` VARCHAR(25) NULL,
    `address` VARCHAR(75) NULL,
    `mobile_phone` VARCHAR(25) NULL,
    `email` VARCHAR(50) NOT NULL,
    `license_no` INT(10) NULL,
    `department` ENUM('Cardiology','Orthopedics','Dermatology','Obstetrics and Gynecology (OB/GYN)','Psychiatry','Neurology') NULL,
    `position` ENUM('Medical Doctor (MD)','Consultant') NULL,
    `username` VARCHAR(25) UNIQUE NOT NULL,
    `password` CHAR(255) NOT NULL,
    INDEX (`name`)
);

CREATE TABLE IF NOT EXISTS `patients` (
    `id` INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `name` VARCHAR(50) NOT NULL,
    `birth_date` DATE NOT NULL,
    `gender` ENUM('female','male','other') NOT NULL,
    `nationality` VARCHAR(25) NOT NULL,
    `health_insurance_no` VARCHAR(50) NOT NULL,
    `email` VARCHAR(50) NOT NULL,
    `mobile_phone` VARCHAR(25) NOT NULL,
    `emergency_contact_name` VARCHAR(50) NOT NULL,
    `emergency_contact_no` VARCHAR(25) NOT NULL,
    `doctor_id` INT,
    `height` INT(5) NOT NULL,
    `weight` INT(5) NOT NULL,
    `allergies` VARCHAR(255) NULL,
    `chronic_diseases` VARCHAR(255) NULL,
    `disabilities` VARCHAR(255) NULL,
    `vaccines` VARCHAR(255) NULL,
    INDEX (`name`),
    FOREIGN KEY (`doctor_id`) REFERENCES `doctors`(`id`)
);

CREATE TABLE `appointments` (
    `id` INT(10) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `patient_id` INT,
    `doctor_id` INT,
    `date_time` DATETIME NOT NULL,
    `consultation_type` VARCHAR(25) NOT NULL,
    `status` ENUM('pending','fulfilled','canceled','no-show') NOT NULL,
    `symptoms` TEXT NOT NULL,
    `pregnancy_breastfeeding` ENUM('yes','no','','') NOT NULL,
    `medicine` TEXT NULL,
    `diagnosis` VARCHAR(255) NULL,
    `prescription` TEXT NULL,
    `labs_requested` TEXT NULL,
    FOREIGN KEY (`patient_id`) REFERENCES `patients`(`id`),
    FOREIGN KEY (`doctor_id`) REFERENCES `doctors`(`id`)
);

-- DUMMY DATA FOR EACH TABLE
INSERT INTO doctors VALUES (
    1,
    'Dr. John Doe',
    '1970-01-01',
    'Male',
    'German',
    '123 Main St, Berlin',
    '+491234567890',
    'johndoe@example.com',
    'LIC1234567',
    'Cardiology',
    'Senior Consultant',
    'johndoe',
    'password123');

INSERT INTO patients VALUES (
  1,
  'Jane Doe',
  '1985-02-14',
  'female',
  'German',
  'HIN1234567890',
  'janedoe@example.com',
  '+491234567891',
  'John Doe',
  '+491234567892',
  'janedoe',
  'password123',
  1,
  170,
  65,
  'Penicillin',
  'Hypertension',
  'None',
  'Influenza, Tetanus'
);

INSERT INTO appointments VALUES (
  1, -- patient_id
  1, -- doctor_id
  '2024-01-21 10:00:00', -- date_time in the format 'YYYY-MM-DD HH:MM:SS'
  'Routine Checkup', -- consultation_type
  'pending', -- status
  'Cough and fever for three days', -- symptoms
  'no', -- pregnancy_breastfeeding
  '', -- medicine
  '', -- diagnosis
  '', -- prescription
  'Blood test, X-ray' -- labs_requested
);
