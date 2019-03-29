CREATE DATABASE IF NOT EXISTS TA_Ticketing;
USE TA_Ticketing;

CREATE TABLE IF NOT EXISTS Permissions (
    permission_id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT UNIQUE PRIMARY KEY,
    permission_name VARCHAR(256) NOT NULL UNIQUE
);

CREATE TABLE IF NOT EXISTS Available_Courses (
    available_course_id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT UNIQUE PRIMARY KEY,
    course_name VARCHAR(256),
    course_number VARCHAR(256) NOT NULL,
    course_description VARCHAR(4096),
    create_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    update_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS Users (
    user_id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT UNIQUE PRIMARY KEY,
    permission_id BIGINT UNSIGNED NOT NULL DEFAULT 1,
    online TINYINT(1) UNSIGNED NOT NULL DEFAULT 0,
    email VARCHAR(256) NOT NULL UNIQUE,
    first_name VARCHAR(32),
    last_name VARCHAR(32),
    create_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    update_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (permission_id) REFERENCES Permissions(permission_id)
);

CREATE TABLE IF NOT EXISTS Teaching_Assistants (
    teaching_assistant_id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT UNIQUE PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    available_course_id BIGINT UNSIGNED NOT NULL,
    start_time_past_midnight TIME NOT NULL,
    end_time_past_midnight TIME NOT NULL,
    create_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    update_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES Users(user_id),
    FOREIGN KEY (available_course_id) REFERENCES Available_Courses(available_course_id)
);

CREATE TABLE IF NOT EXISTS Open_Tickets (
    open_ticket_id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT UNIQUE PRIMARY KEY,
    available_course_id BIGINT UNSIGNED NOT NULL,
    creator_user_id BIGINT UNSIGNED NOT NULL,
    opener_user_id BIGINT UNSIGNED DEFAULT NULL,
    description TEXT,
    node_number INTEGER NOT NULL,
    room_number INTEGER,
    create_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    update_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FULLTEXT (description),
    FOREIGN KEY (available_course_id) REFERENCES Available_Courses(available_course_id),
    FOREIGN KEY (creator_user_id) REFERENCES Users(user_id),
    FOREIGN KEY (opener_user_id) REFERENCES Users(user_id)
);

CREATE TABLE IF NOT EXISTS Closed_Tickets (
    closed_ticket_id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT UNIQUE PRIMARY KEY,
    available_course_id BIGINT UNSIGNED NOT NULL,
    creator_user_id BIGINT UNSIGNED NOT NULL,
    closer_user_id BIGINT UNSIGNED NOT NULL,
    description TEXT,
    node_number INTEGER NOT NULL,
    room_number INTEGER,
    create_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    update_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FULLTEXT (description),
    FOREIGN KEY (available_course_id) REFERENCES Available_Courses(available_course_id),
    FOREIGN KEY (creator_user_id) REFERENCES Users(user_id),
    FOREIGN KEY (closer_user_id) REFERENCES Users(user_id)
);

CREATE TABLE IF NOT EXISTS Frequently_Asked_Questions (
    faq_id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT UNIQUE PRIMARY KEY,
    admin_user_id BIGINT UNSIGNED NOT NULL,
    question TEXT,
    answer TEXT,
    create_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    update_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FULLTEXT (question),
    FOREIGN KEY (admin_user_id) REFERENCES Users(user_id)
);

CREATE EVENT IF NOT EXISTS Logout
    ON SCHEDULE EVERY 1 MINUTE
    DO
        UPDATE Users SET online = 0
        WHERE online = 2 AND DATE_ADD(update_date, INTERVAL 15 MINUTE) < NOW();

CREATE EVENT IF NOT EXISTS Delete_Old_Tickets
    ON SCHEDULE EVERY 1 DAY
    DO
        DELETE FROM Closed_Tickets
        WHERE DATE_ADD(update_date, INTERVAL 1 YEAR) < NOW();