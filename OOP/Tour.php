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

    //Merr te gjithe tours, rendit me data
    public function readTour(): array{
        $result = $this->connection->query(
            'SELECT * FROM tours ORDER BY date ASC'
        );


        // fetch_all(MYSQLI_ASSOC) kthen të gjitha rreshtat
        // si array asociativ
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function findTour(int $id): ?array
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
    public function createTour(string $location, string $date, int $length, float $price, string $image): void {

        //Shtimi i Tour
        $statement = $this->connection->prepare(
            'INSERT INTO tours (location, date, length, price, image)  VALUES (?, ?, ?, ?, ?)'
        );

        //ssids DATATYPE te parametrave
        $statement->bind_param('ssids', $location, $date, $length, $price, $image);

        $statement->execute();
        $statement->close();
    }

    //Nryshimi i tour
    public function updateTour(int $id, string $location, string $date, int $length, float $price, string $image, string $availability ): void {
        
        $statement = $this->connection->prepare(
            'UPDATE tours 
             SET location = ?, date = ?, length = ?, price = ?, image = ?, availability = ? 
             WHERE id = ?'
        );

        //ssidssi DATATYPE te parametrave
        $statement->bind_param('ssidssi', $location, $date, $length, $price, $image, $availability, $id );

        $statement->execute();
        $statement->close();
    }

    //Fshirja e tour
    public function deleteTour(int $id): void{

        $statement = $this->connection->prepare(
            'DELETE FROM tours WHERE id = ?'
        );

        //'i' DATATYPE
        $statement->bind_param('i', $id);

        $statement->execute();
        $statement->close();
    }

    
}