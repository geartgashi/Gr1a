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
    public function readBooking(): array{
        $result = $this->connection->query(
            'SELECT * FROM bookings ORDER BY created_at DESC'
        );

        // fetch_all(MYSQLI_ASSOC) kthen të gjitha rreshtat
        // si array asociativ
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    //Merr bookings sipas id te user, rendit nga newest
    public function getBookingsByUser($id): array{
        $statement = $this->connection->prepare(
            'SELECT *
             FROM bookings 
             WHERE user_id = ? 
             ORDER BY created_at DESC'
        );

        $statement->bind_param('i', $id);
        $statement->execute();

        $result = $statement->get_result();
        $bookings = $result->fetch_all(MYSQLI_ASSOC);

        $statement->close();

        return $bookings;
    }

    public function findBooking(int $id): ?array
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
    public function createBooking(int $guests, int $user_id, int $tour_id): void {

        //Shtimi i Booking
        $statement = $this->connection->prepare(
            'INSERT INTO bookings (guests, user_id, tour_id )  VALUES (?, ?, ?)'
        );

        //isi DATATYPE te parametrave
        $statement->bind_param('iii', $guests, $user_id, $tour_id );

        $statement->execute();
        $statement->close();
    }

    //Nryshimi i booking nuk nevojitet
    

    //Fshirja e booking
    public function deleteBooking(int $id): void{

        $statement = $this->connection->prepare(
            'DELETE FROM bookings WHERE id = ?'
        );

        //'i' DATATYPE
        $statement->bind_param('i', $id);

        $statement->execute();
        $statement->close();
    }
}