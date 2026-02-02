<?php

// Kontrolli strikt i datatypes
declare(strict_types=1);


class Company
{
    //Ruajtja e lidhjes me DB
    private mysqli $connection;

    //Konstruktori
    public function __construct(mysqli $connection){
        $this->connection = $connection;
    }

    //Merr kompanine
    public function readCompany(): array{
        $result = $this->connection->query(
            'SELECT * FROM company LIMIT 1'
        );

        if ($result && $row = $result->fetch_assoc()) {
        return $row;
        }

        return [];
    }

    
    

    //Nryshimi i te dhenave te kompanise
    public function updateCompany(
        int $id, 
        string $name, 
        string $location, 
        string $description, 
        string $email, 
        string $phone, 
        string $facebook, 
        string $instagram, 
        string $twitter, 
        string $terms_of_service, 
        string $privacy_policy  
        ): void {
        
        $statement = $this->connection->prepare(
            'UPDATE company 
             SET 
             name = ?, 
             location = ?, 
             description = ?, 
             email = ?,
             phone = ?, 
             facebook = ?, 
             instagram = ?, 
             twitter = ?, 
             terms_of_service = ?, 
             privacy_policy = ?
             WHERE id = ?'
        );

        //ssssisssssi DATATYPE te parametrave
        $statement->bind_param(
            'ssssssssssi',
             $name, 
             $location,
             $description, 
             $email, 
             $phone,
             $facebook, 
             $instagram, 
             $twitter, 
             $terms_of_service,
             $privacy_policy,
             $id
             );

        $statement->execute();
        $statement->close();
    }

    
}