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
    public function readUser(): array{
        $result = $this->connection->query(
            'SELECT * FROM users ORDER BY created_at DESC'
        );

        
        // fetch_all(MYSQLI_ASSOC) kthen të gjitha rreshtat
        // si array asociativ
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function findUser(int $id): ?array
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
    public function createUser(string $name, string $surname, string $email, int $phone, string $password): void {

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        //Shtimi i User
        $statement = $this->connection->prepare(
            'INSERT INTO users (name, surname, email, phone, password)  VALUES (?, ?, ?, ?, ?)'
        );

        //sssis DATATYPE te parametrave
        $statement->bind_param('sssis', $name, $surname, $email, $phone, $hashedPassword );

        $statement->execute();
        $statement->close();
    }

    //Nryshimi i user
    public function updateUser(int $id, string $name, string $surname, string $email, string $phone): void {
        
        $statement = $this->connection->prepare(
            'UPDATE users 
             SET name = ?, surname = ?, email = ?, phone = ?
             WHERE id = ?'
        );

        //ssssi DATATYPE te parametrave
        $statement->bind_param('ssssi', $name, $surname, $email, $phone, $id );

        $statement->execute();
        $statement->close();
    }

    //Ndryshimi i rolit te nje useri
    public function updaterole(int $id, string $role): void {

        $statement = $this->connection->prepare(
            'UPDATE users 
             SET role = ? 
             WHERE id = ?'
        );

        //is DATATYPE te parametrave
        $statement->bind_param('si', $role, $id );

        $statement->execute();
        $statement->close();
    }

    //Nryshimi i password
    public function updateUserPassword(int $id, string $password ): void {
        
        $statement = $this->connection->prepare(
            'UPDATE users SET password = ? WHERE id = ?'
        );

        //si DATATYPE te parametrave
        $statement->bind_param('si', $password, $id );

        $statement->execute();
        $statement->close();
    }

    //Fshirja e user
    public function deleteUser(int $id): void{

        $statement = $this->connection->prepare(
            'DELETE FROM users WHERE id = ?'
        );

        //'i' DATATYPE
        $statement->bind_param('i', $id);

        $statement->execute();
        $statement->close();
    }



    //Gjej sipas email
    public function findByEmail(string $email): ?array
    {
        //Query per gjetje te User permes email '?'
        
        $statement = $this->connection->prepare(
            "SELECT * FROM users WHERE email = ?"
        );

        //Lidhja e Email me ?
        $statement->bind_param("s", $email);

        //Ekzekutimi dhe kthimi i user
        $statement->execute();

        $result = $statement->get_result();
        return $result->fetch_assoc() ?: null;
    }

   
    // LOGOUT fshirja e session
    public function logout() {
        session_destroy();
    }
}