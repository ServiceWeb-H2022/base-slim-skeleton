<?php

namespace App\Domain\User\Service;

use App\Domain\User\Repository\UserUpdaterRepository;

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
     * Update a new user.
     *
     * @param array $data The form data
     *
     * @return array The new user ID in an array or an error array
     */
    public function UpdateUser(array $data): array
    {
        // Input validation
        $result = $this->validateNewUserInput($data);

        if(! $result['errors']){
            // Update user
            $result = $this->repository->UpdateUser($data);
            $result =  $this->validateUserSelectionOutput($result);
        }
        return $result;
    }

    /**
     * Input validation.
     *
     * @param array $data The input data to Update the user
     *
     * @return array An array containing errors if any
     */
    private function validateNewUserInput(array $data): array
    {
        $errors = [];
        $inputErrors = null;

        // Here you can also use your preferred validation library

        if (empty($data['username'])) {
            $inputErrors['username'] = 'A unique username is requiered';
        }
        if (empty($data['first_name'])) {
            $inputErrors['first_name'] = 'Firstname is requiered';
        }
        if (empty($data['last_name'])) {
            $inputErrors['last_name'] = 'Lastname is requiered';
        }

        if (empty($data['email'])) {
            $inputErrors['email'] = 'A valid email is requiered';
        } elseif (filter_var($data['email'], FILTER_VALIDATE_EMAIL) === false) {
            $inputErrors['email'] = 'A valid email is requiered';
        }
        $inputErrors ? $errors['errors'] =  $inputErrors : null;

        return $errors;
    }
    
    /**
     * Output validation.
     *
     * @param array $data The LGBD result data
     *
     * @return array An array containing errors if any
     */
    private function validateUserSelectionOutput(array $data): array
    {
        // Here you can also use your preferred validation library

        $errors = [];
        $outputErrors = null;

        if (empty($data) || $data['userId'] === 0) {
           $outputErrors['errorDescription'] = 'Failed Updateing the user';
           $outputErrors['username'] = 'Username must be unique';
           $errors['errors'] =  $outputErrors;
        }
        
        return $outputErrors ? $errors : $data;
   }
}
