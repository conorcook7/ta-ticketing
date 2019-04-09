USE Dummy_TA_Ticketing;
INSERT INTO Users (permission_id, email, first_name, last_name) VALUES (1, 'michaelsanchez563@u.boisestate.edu', 'Michael', 'Sanchez');
INSERT INTO Users (user_id, permission_id, email, first_name, last_name) VALUES (200, 2, 'conorcook@u.boisestate.edu', 'Conor', 'Cook');
INSERT INTO Teaching_Assistants (user_id, available_course_id, start_time_past_midnight, end_time_past_midnight) VALUES (200, 1, '08:00:00', '16:00:00');
INSERT INTO Users (permission_id, email, first_name, last_name) VALUES (3, 'malikherring@u.boisestate.edu', 'Malik', 'Herring');
INSERT INTO Users (permission_id, email, first_name, last_name) VALUES (3, 'haydenphothong@u.boisestate.edu', 'Hayden', 'Phothong');