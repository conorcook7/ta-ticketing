"""Creates dummy data for TA Ticketing project."""

import random
import os
import sys

__date__ = '16 February 2019'
__authors__ = [
    'Hayden Phothong'
]


def insert_permission(level, name):
    return 'INSERT INTO Permissions (permission_level, permission_name) VALUES(\'{}\', \'{}\');\n'.format(
        level, name)


def insert_course(course_name):
    course_number = course_name.split('cs')[1]
    section = str(random.randint(1, 20)).zfill(3)
    return 'INSERT INTO Available_Courses (course_name, course_number, section) VALUES(\'{}\', \'{}\', \'{}\');\n'.format(
        course_name, course_number, section)


def insert_user(permission_id, email, password, first_name, last_name):
    return 'INSERT INTO Users (permission_id, email, password, first_name, last_name) VALUES(\'{}\', \'{}\', \'{}\', \'{}\', \'{}\');\n'.format(
        permission_id, email, password, first_name, last_name)


def insert_ta(user_id, start, end):
    return 'INSERT INTO Teaching_Assistants (user_id, start_time_past_midnight, end_time_past_midnight) VALUES(\'{}\', \'{}\', \'{}\');\n'.format(
        user_id, start, end)


def insert_open_ticket(available_course_id, user_id, description, node_number, room_number):
    return 'INSERT INTO Active_Tickets (available_course_id, user_id, description, node_number, room_number) VALUES(\'{}\', \'{}\', \'{}\', \'{}\', \'{}\');\n'.format(
        available_course_id, user_id, description, node_number, room_number)


def insert_closed_ticket(available_course_id, user_id, description, node_number, room_number):
    return 'INSERT INTO Completed_Tickets (available_course_id, user_id, description, node_number, room_number) VALUES(\'{}\', \'{}\', \'{}\', \'{}\', \'{}\');\n'.format(
        available_course_id, user_id, description, node_number, room_number)


if __name__ == '__main__':

    # Set the current working directory
    os.chdir(os.path.dirname(os.path.abspath(__file__)))

    # Set seed
    random.seed(999)

    # Get names
    with open('../../text/names.txt', 'r') as names_file:
        names = names_file.readlines()

    names = [name.strip() for name in names]

    sql_script = open('../sql/dummy-data.sql', 'w+')

    # Change database
    sql_script.write(
        """
        DROP DATABASE IF EXISTS Dummy_TA_Ticketing;
        CREATE DATABASE Dummy_TA_Ticketing;
        USE Dummy_TA_Ticketing;

        CREATE USER IF NOT EXISTS 'ta-ticketing'@'localhost' IDENTIFIED BY '34$5iu98&7o7%76d4Ss35';
        GRANT ALL PRIVILEGES ON TA_Ticketing.* TO 'ta-ticketing'@'localhost' WITH GRANT OPTION;
        """
    )

    # Get database configuration
    with open('../sql/ta-ticketing.sql', 'r') as database_file:
        database_contents = database_file.readlines()

    database_contents = database_contents[2:]
    for line in database_contents:
        sql_script.write(line)

    sql_script.write('\n')

    # Insert permissions
    sql_script.write(insert_permission(1, 'USER'))
    sql_script.write(insert_permission(2, 'TA'))
    sql_script.write(insert_permission(3, 'ADMIN'))
    sql_script.write('\n')

    # Insert courses
    courses = []
    for i in range(121, 1000, 100):
        courses.append('cs{}'.format(i))

    for course in courses:
        sql_script.write(insert_course(course))
    sql_script.write('\n')

    # Insert users
    num_names = len(names)

    users = []
    teaching_assistants = []
    admins = []

    for i in range(num_names):

        permission = random.random()

        if permission < 0.15:
            permission = 3
            admins.append(i + 1)

        elif permission < 0.25:
            permission = 2
            teaching_assistants.append(i + 1)

        else:
            permission = 1
            users.append(i + 1)

        first_name = names[random.randint(0, num_names - 1)]
        last_name = names[random.randint(0, num_names - 1)]
        email = '{}{}@example.boisestate.edu'.format(first_name, last_name)
        password = '{}.{}.{}'.format(first_name, last_name, permission)

        sql_script.write(insert_user(permission, email,
                                     password, first_name, last_name))

    sql_script.write('\n')

    # Insert teaching assistants
    for ta in teaching_assistants:
        user_id = ta
        start_time_past_midnight = '{}:{}:{}'.format(
            str(random.randint(0, 12)).zfill(2),
            str(random.randint(0, 59)).zfill(2),
            str(random.randint(0, 59)).zfill(2)
        )
        end_time_past_midnight = '{}:{}:{}'.format(
            str(random.randint(13, 23)).zfill(2),
            str(random.randint(0, 59)).zfill(2),
            str(random.randint(0, 59)).zfill(2)
        )

        sql_script.write(
            insert_ta(user_id, start_time_past_midnight, end_time_past_midnight))

    sql_script.write('\n')

    # Insert tickets
    with open('../../text/lorem-ipsum.txt', 'r') as lorem_file:
        contents = lorem_file.readlines()
        contents = [content.strip() for content in contents]

    # Active tickets
    for i in range(10000):
        available_course_id = random.randint(1, len(courses))
        user_id = random.randint(1, len(names))
        description = ' '.join(
            contents[
                random.randint(0, len(contents) // 2):
                random.randint(len(contents) // 2 + 1, len(contents) - 1)
            ]
        )
        node_number = random.randint(1, 500)
        room_number = random.randint(1, 900)
        sql_script.write(insert_open_ticket(
            available_course_id, user_id, description, node_number, room_number))

    sql_script.write('\n')

    # Completed tickets
    for i in range(10000):
        available_course_id = random.randint(1, len(courses))
        user_id = random.randint(1, len(names))
        description = ' '.join(
            contents[
                random.randint(0, len(contents) // 2):
                random.randint(len(contents) // 2 + 1, len(contents) - 1)
            ]
        )
        node_number = random.randint(1, 500)
        room_number = random.randint(1, 900)
        sql_script.write(insert_closed_ticket(
            available_course_id, user_id, description, node_number, room_number))
