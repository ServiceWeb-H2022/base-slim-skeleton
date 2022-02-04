<?php

namespace App\Domain\User\Service;

use App\Domain\User\Repository\UserReaderRepository;
use App\Domain\User\Repository\UserUpdaterRepository;

/**
 * Service.
 */
final class UserUpdater
{
    /**
     * @var UserUpdaterRepository
     */
    private $updateRepository;

    /**
     * The constructor.
     *
     * @param UserUpdaterRepository $updateRepository The updateRepository
     */
    public function __construct(
        UserUpdaterRepository $updateRepository)
    {
        $this->updateRepository = $updateRepository;
    }

    /**
     * Update a user.
     *
     * @param array $data The form data
     *
     * @return array The user ID in an array or an error array
     */
    public function updateUser(array $data): array
    {
        // Input validation
        $result = $this->validateUserInput($data);

        if(! $result['validation-errors']){
            // Update user
            $result = $this->updateRepository->UpdateUser($data);
            $result =  $this->validateUserUpdateOutput($result);
        }
        return $result;
    }

    /**
     * Input validation.
     *
     * @param array $data The input data to update the user
     *
     * @return array An array containing errors if any
     */
    private function validateUserInput(array $data): array
    {
        $errors = [];
        $inputErrors = null;

        if($data['email']){
            if (filter_var($data['email'], FILTER_VALIDATE_EMAIL) === false) {
                $inputErrors['email'] = 'Email must be valid';
            }
        }
       
        $inputErrors ? $errors['validation-errors'] =  $inputErrors : null;

        return $errors;
    }
    
    /**
     * Output validation.
     *
     * @param array $data The LGBD result data
     *
     * @return array An array containing errors if any
     */
    private function validateUserUpdateOutput(array $data): array
    {
        $errors = [];
        $outputErrors = null;

        if (empty($data)) {
           $outputErrors['errorDescription'] = 'Failed Updating the user';
           $outputErrors['username'] = 'Username must be unique';
           $errors['validation-errors'] =  $outputErrors;
        }
        return $outputErrors ? $errors : $data;
   }
}
