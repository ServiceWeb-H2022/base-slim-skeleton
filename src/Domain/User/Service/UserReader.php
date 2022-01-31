<?php

namespace App\Domain\User\Service;

use App\Domain\User\Repository\UserReaderRepository;

/**
 * Service.
 */
final class UserReader
{
    /**
     * @var UserReaderRepository
     */
    private $repository;

    /**
     * The constructor.
     *
     * @param UserReaderRepository $repository The repository
     */
    public function __construct(UserReaderRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Read a user
     *
     * @param int $userId the user ID
     *
     * @return array The fetched user array
     */
    public function selectUser(int $userId): array
    {

        // Insert user
        $userStd = $this->repository->selectUser($userId);

        // Logging here: User selected successfully
        //$this->logger->info(sprintf('User selected successfully: %s', $userId));

        return $userStd;
    }
}
