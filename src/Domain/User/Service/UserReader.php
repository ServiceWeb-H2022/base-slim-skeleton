<?php

namespace App\Domain\User\Service;

use App\Domain\User\Repository\UserReaderRepository;
use App\Exception\ValidationException;
use Slim\Psr7\Request;

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

        // Select user
        $userStd = $this->repository->selectUser($userId);
        $errors = $this->validateSelectedUser($userStd);

        // Logging here: User selected successfully
        //$this->logger->info(sprintf('User selected successfully: %s', $userId));

        return $errors ? $errors : $userStd;
    }


    /**
     * Input validation.
     *
     * @param array $data The form data
     *
     * @throws ValidationException
     *
     * @return void
     */
    private function validateSelectedUser(array $data): array
    {
         // Here you can also use your preferred validation library
         $errors = [];
         if (empty($data)) {
             $errors['userId'] = 'Innvalid ID';
         }
         if ($errors) {
            //  throw new ValidationException('Please check your input', $errors);
         }
         return $errors;
    }
}


