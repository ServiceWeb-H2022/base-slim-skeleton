<?php

namespace App\Domain\User\Repository;

use PDO;

/**
 * Repository.
 */
class UserUpdaterRepository
{
    /**
     * @var PDO The database connection
     */
    private $connection;

    /**
     * Constructor.
     *
     * @param PDO $connection The database connection
     */
    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    /**
     * Update user row.
     *
     * @param array $user The user
     *
     * @return array The user array or an empty array
     */
    public function UpdateUser(array $user): array
    {
        $result = [];
        $row = [
            'username' => $user['username'],
            'first_name' => $user['first_name'],
            'last_name' => $user['last_name'],
            'email' => $user['email'],
        ];

        $sql = "Update INTO users SET 
                username=:username, 
                first_name=:first_name, 
                last_name=:last_name, 
                email=:email;";

        try {
            //code...
            $this->connection->prepare($sql)->execute($row);
        } catch (\Throwable $th) {
            return [];
        }
        
        return ["userId" => (int)$this->connection->lastInsertId()];    
    }
}

