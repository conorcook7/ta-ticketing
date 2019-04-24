CREATE DATABASE IF NOT EXISTS TA_Ticketing;
USE TA_Ticketing;

DROP USER IF EXISTS 'ta-ticketing'@'localhost';

CREATE USER 'ta-ticketing'@'localhost' IDENTIFIED WITH
mysql_native_password BY '34$5iu98&7o7%76d4Ss35';
GRANT ALL PRIVILEGES ON TA_Ticketing.* TO 'ta-ticketing'@'localhost' WITH GRANT OPTION;

CREATE TABLE IF NOT EXISTS Permissions (
    permission_id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT UNIQUE PRIMARY KEY,
    permission_name VARCHAR(256) NOT NULL UNIQUE
);

CREATE TABLE IF NOT EXISTS Available_Courses (
    available_course_id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT UNIQUE PRIMARY KEY,
    course_name VARCHAR(256) UNIQUE,
    course_number VARCHAR(256) NOT NULL UNIQUE,
    course_description VARCHAR(4096),
    create_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    update_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS Users (
    user_id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT UNIQUE PRIMARY KEY,
    permission_id BIGINT UNSIGNED NOT NULL DEFAULT 1,
    online TINYINT(1) UNSIGNED NOT NULL DEFAULT 0,
    email VARCHAR(256) NOT NULL UNIQUE,
    image_URL varchar(4096) DEFAULT NULL,
    first_name VARCHAR(32),
    last_name VARCHAR(32),
    create_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    update_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (permission_id) REFERENCES Permissions(permission_id)
);

CREATE TABLE IF NOT EXISTS Teaching_Assistants (
    teaching_assistant_id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT UNIQUE PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    available_course_id BIGINT UNSIGNED,
    start_time_past_midnight TIME DEFAULT NULL,
    end_time_past_midnight TIME DEFAULT NULL,
    create_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    update_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES Users(user_id) ON DELETE CASCADE,
    FOREIGN KEY (available_course_id) REFERENCES Available_Courses(available_course_id) ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS Open_Tickets (
    open_ticket_id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT UNIQUE PRIMARY KEY,
    available_course_id BIGINT UNSIGNED NOT NULL,
    creator_user_id BIGINT UNSIGNED NOT NULL,
    opener_user_id BIGINT UNSIGNED DEFAULT NULL,
    description TEXT,
    node_number VARCHAR(256) NOT NULL,
    room_number INTEGER,
    create_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    update_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FULLTEXT (description),
    FOREIGN KEY (available_course_id) REFERENCES Available_Courses(available_course_id) ON DELETE CASCADE,
    FOREIGN KEY (creator_user_id) REFERENCES Users(user_id) ON DELETE CASCADE,
    FOREIGN KEY (opener_user_id) REFERENCES Users(user_id) ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS Closed_Tickets (
    closed_ticket_id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT UNIQUE PRIMARY KEY,
    available_course_id BIGINT UNSIGNED NULL,
    creator_user_id BIGINT UNSIGNED NOT NULL,
    closer_user_id BIGINT UNSIGNED,
    description TEXT,
    closing_description TEXT,
    node_number VARCHAR(256) NOT NULL,
    room_number INTEGER,
    create_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    update_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FULLTEXT (description),
    FULLTEXT (closing_description),
    FOREIGN KEY (available_course_id) REFERENCES Available_Courses(available_course_id) ON DELETE CASCADE,
    FOREIGN KEY (creator_user_id) REFERENCES Users(user_id) ON DELETE CASCADE,
    FOREIGN KEY (closer_user_id) REFERENCES Users(user_id) ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS Frequently_Asked_Questions (
    faq_id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT UNIQUE PRIMARY KEY,
    admin_user_id BIGINT UNSIGNED,
    question TEXT NOT NULL,
    answer TEXT NOT NULL,
    create_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    update_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FULLTEXT (question),
    FOREIGN KEY (admin_user_id) REFERENCES Users(user_id) ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS Bug_Reports (
    bug_report_id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT UNIQUE PRIMARY KEY,
    creator_user_id BIGINT UNSIGNED NOT NULL,
    closer_user_id BIGINT UNSIGNED DEFAULT NULL,
    active TINYINT NOT NULL DEFAULT 1,
    title TEXT NOT NULL,
    description TEXT,
    closing_description TEXT,
    create_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    update_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FULLTEXT (title),
    FOREIGN KEY (creator_user_id) REFERENCES Users(user_id) ON DELETE CASCADE,
    FOREIGN KEY (closer_user_id) REFERENCES Users(user_id) ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS Blacklist (
    blacklist_id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT UNIQUE PRIMARY KEY,
    creator_user_id BIGINT UNSIGNED,
    blacklist_email VARCHAR(256) NOT NULL UNIQUE,
    create_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    update_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FULLTEXT (blacklist_email),
    FOREIGN KEY (creator_user_id) REFERENCES Users(user_id) ON DELETE SET NULL
);

INSERT INTO Permissions VALUES (1, 'USER');
INSERT INTO Permissions VALUES (2, 'TA');
INSERT INTO Permissions VALUES (3, 'PROFESSOR');
INSERT INTO Permissions VALUES (4, 'ADMIN');
INSERT INTO Permissions VALUES (5, 'DENIED');

INSERT INTO Users VALUES (1, 4, 0, 'taticketing@boisestate.edu', NULL, 'TA Tticketing', 'Server', NOW(), NOW());

CREATE EVENT IF NOT EXISTS Logout
    ON SCHEDULE EVERY 15 MINUTE
    DO
        UPDATE Users SET online = 0
        WHERE DATE_ADD(update_date, INTERVAL 30 MINUTE) < NOW();

CREATE EVENT IF NOT EXISTS Delete_Old_Tickets
    ON SCHEDULE EVERY 1 DAY
    DO
        DELETE FROM Closed_Tickets
        WHERE DATE_ADD(update_date, INTERVAL 1 YEAR) < NOW();

CREATE EVENT IF NOT EXISTS Delete_Old_Bug_Reports
    ON SCHEDULE EVERY 7 DAY
    DO
        DELETE FROM Bug_Reports
        WHERE DATE_ADD(update_date, INTERVAL 1 YEAR) < NOW();
