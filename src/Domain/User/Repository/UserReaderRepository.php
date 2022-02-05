<?php

namespace App\Domain\User\Repository;

use PDO;

/**
 * Repository.
 */
class UserReaderRepository
{
    /**
     * @var PDO La connection au LGBD
     */
    private $connection;

    /**
     * Constructor.
     *
     * @param PDO $connection La connection au LGBD
     */
    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    /**
     * Read user row.
     *
     * @param int $usagerId L'id de l'usager
     *
     * @return array Un array clées : valeurs des données de l'usager
     */
    public function selectUser(int $usagerId): array
    {
        $cond = [
            $usagerId
        ];
        $sql = "SELECT * FROM USERS WHERE id= ?;";

        $stmt = $this->connection->prepare($sql);
        $stmt->execute($cond);

        $resultat = $stmt->fetch(PDO::FETCH_ASSOC);
        return $resultat ? $resultat: [];

    }
}

