CREATE USER 'klient'@'localhost' IDENTIFIED BY 'klient';

GRANT ALL PRIVILEGES ON `minishop`.* TO 'klient'@'localhost' WITH GRANT OPTION;