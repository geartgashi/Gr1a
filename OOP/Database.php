<?php

// Kontrolli strikt i datatypes
declare(strict_types=1);

class Database
{
    //Adresa e serverit
    private string $host;

    //Perdoruesi i DB
    private string $user;

    //Fjalekalimi'i DB
    private string $password;

    //Emri i DB
    private string $database;
    
    //Ruajtja e lidhjes me DB
    private ?mysqli $connection = null;

    //Kontruktori i DB
    public function __construct()
    {
        //Merr adresen, default 127.0.0.1
        $this->host = getenv('DB_HOST') ?: '127.0.0.1';

        //Merr perdoruesin, default root
        $this->user = getenv('DB_USER') ?: 'root';

        //Merr PW, default bosh
        $this->password = getenv('DB_PASSWORD') ?: '';

        //Merr emrin, default Travel_Project
        $this->database = getenv('DB_NAME') ?: 'Travel_Project';
    }

    //Lidhja me DB
    public function getConnection(): mysqli{

        //Nese ka Lidhje e kthen ate
        if ($this->connection instanceof mysqli) {
            return $this->connection;
        }

        //Nese nuk ka e krijon ate
        $this->connection = new mysqli(
            $this->host,
            $this->user,
            $this->password
        );

        //Error check
        if ($this->connection->connect_error) {
            throw new RuntimeException(
                'Database connection failed: ' . $this->connection->connect_error
            );
        }

        //Kthen lidhjen
        return $this->connection;
    }

    //Inicializimi i DB dhe tabelave
    public function initialize(): void{
        
        $connection = $this->getConnection();
        $databaseName = $connection->real_escape_string($this->database);

        //Krijimi i DB
        $connection->query(
            "CREATE DATABASE IF NOT EXISTS `{$databaseName}` 
             CHARACTER SET utf8mb4 
             COLLATE utf8mb4_unicode_ci"
        );

        //Selektimi i saj
        $connection->select_db($this->database);

        //Krijimi i Tabeles USERS
        $createTableSql = <<<SQL
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    surname VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    phone VARCHAR(20),
    password VARCHAR(255) NOT NULL,
    role ENUM('user','admin') DEFAULT 'user',

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB
SQL;
        $connection->query($createTableSql);

        //Krijimi i Tabeles TOURS
        $createTableSql = <<<SQL
CREATE TABLE IF NOT EXISTS tours (
    id INT AUTO_INCREMENT PRIMARY KEY,
    location VARCHAR(100) NOT NULL,
    date DATE NOT NULL,
    length INT NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    availability ENUM('available','sold out') DEFAULT 'available',

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB
SQL;
        $connection->query($createTableSql);

        //Krijimi i Tabeles BOOKINGS
        $createTableSql = <<<SQL
CREATE TABLE IF NOT EXISTS bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    guests INT NOT NULL,
    user_id INT NOT NULL,
    user_name VARCHAR(100) NOT NULL,
    tour_id INT NOT NULL,
    tour_location VARCHAR(100) NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (tour_id) REFERENCES tours(id) ON DELETE CASCADE,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB
SQL;
        $connection->query($createTableSql);

        //Krijimi i Tabeles RATINGS
        $createTableSql = <<<SQL
CREATE TABLE IF NOT EXISTS reviews (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    user_name VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    stars char(1) NOT NULL,
    
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB
SQL;
        $connection->query($createTableSql);
    }
}
