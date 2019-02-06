CREATE DATABASE IF NOT EXISTS ta-ticketing;
USE ta-ticketing;

CREATE TABLE Permissions (
    permission_id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT UNIQUE,
    permisson_level INTEGER NOT NULL UNIQUE,
    permission_name VARCHAR(256) NOT NULL UNIQUE,
    PRIMARY KEY (permission_id)
);

CREATE TABLE Available_Courses (
    available_course_id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT UNIQUE,
    course_name VARCHAR(256),
    course_number VARCHAR(256),
    section VARCHAR(256),
    create_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    update_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE,
    PRIMARY KEY (available_course_id)
);

CREATE TABLE Users (
    user_id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT UNIQUE,
    permission_id BIGINT UNSIGNED NOT NULL,
    email VARCHAR(256) NOT NULL UNIQUE,
    password VARCHAR(512) NOT NULL,
    first_name VARCHAR(32),
    last_name VARCHAR(32),
    create_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    update_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE,
    FOREIGN KEY (permission_id) REFERENCES Permissions(permission_id),
    PRIMARY KEY (user_id)
);

CREATE TABLE Teaching_Assistants (
    teaching_assistant_id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT UNIQUE,
    user_id BIGINT UNSIGNED NOT NULL,
    start_time_past_midnight TIME NOT NULL,
    end_time_past_midnight TIME NOT NULL,
    create_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    update_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE,
    FOREIGN KEY (user_id) REFERENCES Users(user_id),
    PRIMARY KEY (teaching_assitant_id)
);

CREATE TABLE Active_Tickets (
    active_ticket_id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT UNIQUE,
    available_course_id BIGINT UNSIGNED NOT NULL,
    user_id BIGINT UNSIGNED NOT NULL,
    description TEXT,
    node_number INTEGER,
    room_number INTEGER,
    create_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    update_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE,
    FULLTEXT (description),
    FOREIGN KEY (available_course_id) REFERENCES Available_Courses(available_course_id),
    FOREIGN KEY (user_id) REFERENCES Users(user_id),
    PRIMARY KEY (active_ticket_id)
);

CREATE TABLE Completed_Tickets (
    active_ticket_id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT UNIQUE,
    available_course_id BIGINT UNSIGNED NOT NULL,
    user_id BIGINT UNSIGNED NOT NULL,
    description TEXT,
    node_number INTEGER,
    room_number INTEGER,
    completion_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    update_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE,
    FULLTEXT (description),
    FOREIGN KEY (available_course_id) REFERENCES Available_Courses(available_course_id),
    FOREIGN KEY (user_id) REFERENCES Users(user_id),
    PRIMARY KEY (active_ticket_id)
);

