<?php

namespace App\Domain\User\Repository;

use PDO;

/**
 * Repository.
 */
class UserReaderRepository
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
     * Read user row.
     *
     * @param int $userId The user ID
     *
     * @return array bool The fetched user stdArray
     */
    public function selectUser(int $userId): array
    {
        $cond = [
            $userId
        ];
        $sql = "SELECT * FROM USERS WHERE id= ?;";

        $stmt = $this->connection->prepare($sql);
        $stmt->execute($cond);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result: [];

    }
}

