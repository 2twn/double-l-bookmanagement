CREATE USER 'books'@'localhost' IDENTIFIED BY  'BsGxedJnpsczzauA';
GRANT USAGE ON * . * TO  'books'@'localhost' IDENTIFIED BY  'BsGxedJnpsczzauA' WITH MAX_QUERIES_PER_HOUR 0 MAX_CONNECTIONS_PER_HOUR 0 MAX_UPDATES_PER_HOUR 0 MAX_USER_CONNECTIONS 0 ;
CREATE DATABASE IF NOT EXISTS  `books` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
GRANT ALL PRIVILEGES ON  `books` . * TO  'books'@'localhost';