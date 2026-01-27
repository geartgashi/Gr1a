<?php

// Kontrolli strikt i datatypes
declare(strict_types=1);


class User
{
    //Ruajtja e lidhjes me DB
    private mysqli $connection;

    //Konstruktori
    public function __construct(mysqli $connection){
        $this->connection = $connection;
    }

    //Merr te gjithe userat, rendit nga newest
    public function all(): array{
        $result = $this->connection->query(
            'SELECT * FROM users ORDER BY created_at DESC'
        );

        //Error check
        if (!$result) {
            return [];
        }

        // fetch_all(MYSQLI_ASSOC) kthen të gjitha rreshtat
        // si array asociativ
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function find(int $id): ?array
    {
        //Query per gjetje te User permes ID '?'
        $statement = $this->connection->prepare(
            'SELECT * FROM users WHERE id = ?'
        );

        //Lidhja e ID me ?
        $statement->bind_param('i', $id);

        //Ekzekutimi
        $statement->execute();
        $result = $statement->get_result();
        $user = $result->fetch_assoc();
        $statement->close();

        //Kthen User-in
        return $user ?: null;
    }

    //Krijimi i User
    public function create(string $name, string $surname, string $email, int $phone, string $password): void {

        //Shtimi i User
        $statement = $this->connection->prepare(
            'INSERT INTO users (name, surname, email, phone, password)  VALUES (?, ?, ?, ?, ?)'
        );

        //sssis DATATYPE te parametrave
        $statement->bind_param('sssis', $name, $surname, $email, $phone, $password );

        $statement->execute();
        $statement->close();
    }

    //Nryshimi i user
    public function update(int $id, string $name, string $surname, string $email, int $phone, string $password ): void {
        
        $statement = $this->connection->prepare(
            'UPDATE users 
             SET name = ?, surname = ?, email = ?, phone = ?, password = ? 
             WHERE id = ?'
        );

        //sssisi DATATYPE te parametrave
        $statement->bind_param('sssisi', $name, $surname, $email, $phone, $password, $id );

        $statement->execute();
        $statement->close();
    }

    //Fshirja e user
    public function delete(int $id): void{

        $statement = $this->connection->prepare(
            'DELETE FROM users WHERE id = ?'
        );

        //'i' DATATYPE
        $statement->bind_param('i', $id);

        $statement->execute();
        $statement->close();
    }
}