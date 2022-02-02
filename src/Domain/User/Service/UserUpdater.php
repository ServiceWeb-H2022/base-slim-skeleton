<?php

namespace App\Domain\User\Service;

use App\Domain\User\Repository\UserUpdaterRepository;
use App\Exception\ValidationException;

/**
 * Service.
 */
final class UserUpdater
{
    /**
     * @var UserUpdaterRepository
     */
    private $repository;

    /**
     * The constructor.
     *
     * @param UserUpdaterRepository $repository The repository
     */
    public function __construct(UserUpdaterRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Read a user
     *
     * @param int $userId the user ID
     * 
     * @param array $data the associative array (field:value) to update the user
     *
     * @return array The updated user array
     */
    public function selectUser(int $userId, array $data): array
    {

        // Select user
        $userStd = $this->repository->updateUser($userId, $data);
        $errors = $this->validateUserUpdate($userStd);

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
    private function validateUserUpdate(array $data): array
    {
         // Here you can also use your preferred validation library
         $errorsArr = [];
         $rqstErrors = null;

         if (empty($data)) {
            $errorsArr['errorDescription'] = 'Failed selecting the user associated to this ID';
            $rqstErrors['userId'] = 'Innvalid ID';

            $errorsArr['errors'] = $rqstErrors;
         }
         if ($rqstErrors) {
            //  throw new ValidationException('Please check your input', $rqstErrors);
         }
         return $errorsArr;
    }
}


