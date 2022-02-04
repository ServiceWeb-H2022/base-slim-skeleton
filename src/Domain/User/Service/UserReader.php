<?php

namespace App\Domain\User\Service;

use App\Domain\User\Repository\UserReaderRepository;
use App\Exception\ValidationException;

use function PHPUnit\Framework\isEmpty;

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
        $result = $this->repository->selectUser($userId);
        $result = $this->validateUserSelection($result);

        // Logging here: User selected successfully
        //$this->logger->info(sprintf('User selected successfully: %s', $userId));

        return $result;
    }


    /**
     * Input validation.
     *
     * @param array $data The form data
     *
     * @return array
     */
    private function validateUserSelection(array $data): array
    {
        // Here you can also use your preferred validation library
        $errors = [];
        $rqstErrors = null;

        if (empty($data)) {
           $rqstErrors['errorDescription'] = 'Failed selecting the user associated to this ID';
           $rqstErrors['userId'] = 'Invalid ID';
           $errors['errors'] =  $rqstErrors;
        }
        // throw new ValidationException('Please check your input', $errors);
        
        return $rqstErrors ? $errors : $data;
   }
}


