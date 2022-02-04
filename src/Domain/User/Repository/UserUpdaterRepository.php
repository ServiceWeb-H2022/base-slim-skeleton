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
     * @param array $user The user data
     *
     * @return array The user array or an empty array
     */
    public function UpdateUser(array $user): array
    {
        try {
            $result = [];

            $row = [];
            foreach ($user as $key => $value) {
                $row[$key] = $value;
            }

            $sql = "Update users SET 
            username=:username, 
            first_name=:first_name, 
            last_name=:last_name, 
            email=:email
            WHERE id=:id;";

            $this->connection->prepare($sql)->execute($row);
            return [ "userId" => $user['id'] ];
            
        } catch (\Throwable $th) {
            return [];
        }
    }
}

