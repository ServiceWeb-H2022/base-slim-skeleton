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
     * Read a single user row.
     *
     * @param object $querryObj 
     *
     * @return array Un array clées : valeurs des données de l'usager
     */
    public function selectSingleUser(object $querryObj): array
    {
        // TODO: Utiliser les propriétées du queryObj avec le DBO

        $sql = "SELECT * FROM users WHERE id= ?;";
        $stmt = $this->connection->prepare($querryObj->sql);
        $stmt->execute($querryObj->cond);
        $resultat = $stmt->fetch(PDO::FETCH_ASSOC);
        return $resultat ? $resultat: [];
    }

    /**
     * Selectione plusieurs utilisateurs selon les conditions
     *
     * @param object $querryObj 
     *
     * @return array Un array clées(userId) : valeurs(infos) des users
     */
    public function selectManyUsers(object $querryObj): array
    {
        $sql = "SELECT * FROM users WHERE id= ?;";
        $stmt = $this->connection->prepare($querryObj->sql);
        $stmt->execute($querryObj->cond);
        $resultat = $stmt->fetch(PDO::FETCH_ASSOC);
        return $resultat ? $resultat: [];
    }
}

