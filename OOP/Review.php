<?php

// Kontrolli strikt i datatypes
declare(strict_types=1);


class Review
{
    //Ruajtja e lidhjes me DB
    private mysqli $connection;

    //Konstruktori
    public function __construct(mysqli $connection){
        $this->connection = $connection;
    }

    //Merr te gjithe reviews, rendit nga newest
    public function all(): array{
        $result = $this->connection->query(
            'SELECT * FROM reviews ORDER BY created_at DESC'
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
        //Query per gjetje te Reviews permes ID '?'
        $statement = $this->connection->prepare(
            'SELECT * FROM reviews WHERE id = ?'
        );

        //Lidhja e ID me ?
        $statement->bind_param('i', $id);

        //Ekzekutimi
        $statement->execute();
        $result = $statement->get_result();
        $review = $result->fetch_assoc();
        $statement->close();

        //Kthen Review-in
        return $review ?: null;
    }

    //Krijimi i Review
    public function create(int $user_id, string $user_name, string $description, int $stars ): void {

        //Shtimi i Reciew
        $statement = $this->connection->prepare(
            'INSERT INTO reviews (user_id, user_name, description, stars )  VALUES (?, ?, ?, ?)'
        );

        //issi DATATYPE te parametrave
        $statement->bind_param('issi', $user_id, $user_name, $description, $stars );

        $statement->execute();
        $statement->close();
    }

    //Nryshimi i review nuk nevojitet

    //Fshirja e review
    public function delete(int $id): void{

        $statement = $this->connection->prepare(
            'DELETE FROM reviews WHERE id = ?'
        );

        //'i' DATATYPE
        $statement->bind_param('i', $id);

        $statement->execute();
        $statement->close();
    }
}