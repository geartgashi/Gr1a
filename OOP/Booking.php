<?php

// Kontrolli strikt i datatypes
declare(strict_types=1);


class Booking
{
    //Ruajtja e lidhjes me DB
    private mysqli $connection;

    //Konstruktori
    public function __construct(mysqli $connection){
        $this->connection = $connection;
    }

    //Merr te gjithe bookings, rendit nga newest
    public function all(): array{
        $result = $this->connection->query(
            'SELECT * FROM bookings ORDER BY created_at DESC'
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
        //Query per gjetje te Booking permes ID '?'
        $statement = $this->connection->prepare(
            'SELECT * FROM bookings WHERE id = ?'
        );

        //Lidhja e ID me ?
        $statement->bind_param('i', $id);

        //Ekzekutimi
        $statement->execute();
        $result = $statement->get_result();
        $booking = $result->fetch_assoc();
        $statement->close();

        //Kthen Booking-in
        return $booking ?: null;
    }

    //Krijimi i Booking
    public function create(int $guests, int $user_id, string $user_name, int $tour_id, string $tour_location ): void {

        //Shtimi i Booking
        $statement = $this->connection->prepare(
            'INSERT INTO bookings (guests, user_id, user_name, tour_id, tour_location )  VALUES (?, ?, ?, ?)'
        );

        //iisis DATATYPE te parametrave
        $statement->bind_param('iisis', $user_id, $user_name, $tour_id, $tour_location );

        $statement->execute();
        $statement->close();
    }

    //Nryshimi i booking nuk nevojitet
    

    //Fshirja e booking
    public function delete(int $id): void{

        $statement = $this->connection->prepare(
            'DELETE FROM bookings WHERE id = ?'
        );

        //'i' DATATYPE
        $statement->bind_param('i', $id);

        $statement->execute();
        $statement->close();
    }
}