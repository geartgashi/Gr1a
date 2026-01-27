<?php

// Kontrolli strikt i datatypes
declare(strict_types=1);


class Tour
{
    //Ruajtja e lidhjes me DB
    private mysqli $connection;

    //Konstruktori
    public function __construct(mysqli $connection){
        $this->connection = $connection;
    }

    //Merr te gjithe tours, rendit nga newest
    public function all(): array{
        $result = $this->connection->query(
            'SELECT * FROM tours ORDER BY created_at DESC'
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
        //Query per gjetje te Tour permes ID '?'
        $statement = $this->connection->prepare(
            'SELECT * FROM tours WHERE id = ?'
        );

        //Lidhja e ID me ?
        $statement->bind_param('i', $id);

        //Ekzekutimi
        $statement->execute();
        $result = $statement->get_result();
        $tour = $result->fetch_assoc();
        $statement->close();

        //Kthen Tour-in
        return $tour ?: null;
    }

    //Krijimi i Tour
    public function create(string $location, int $date, int $length, double $price, string $availability): void {

        //Shtimi i Tour
        $statement = $this->connection->prepare(
            'INSERT INTO tours (location, date, length, price, availability)  VALUES (?, ?, ?, ?, ?)'
        );

        //siids DATATYPE te parametrave
        $statement->bind_param('siids', $location, $date, $length, $price, $availability );

        $statement->execute();
        $statement->close();
    }

    //Nryshimi i tour
    public function update(int $id, string $location, int $date, int $length, double $price, string $availability ): void {
        
        $statement = $this->connection->prepare(
            'UPDATE tours 
             SET location = ?, date = ?, length = ?, price = ?, availability = ? 
             WHERE id = ?'
        );

        //isiids DATATYPE te parametrave
        $statement->bind_param('isiids', $location, $date, $length, $price, $availability, $id );

        $statement->execute();
        $statement->close();
    }

    //Fshirja e tour
    public function delete(int $id): void{

        $statement = $this->connection->prepare(
            'DELETE FROM tours WHERE id = ?'
        );

        //'i' DATATYPE
        $statement->bind_param('i', $id);

        $statement->execute();
        $statement->close();
    }
}