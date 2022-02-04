<?php

namespace App\Domain\User\Service;

use App\Domain\User\Repository\UserCreatorRepository;
use App\Exception\ValidationException;
use Slim\Psr7\Response;

/**
 * Service.
 */
final class UserCreator
{
    /**
     * @var UserCreatorRepository
     */
    private $repository;

    /**
     * The constructor.
     *
     * @param UserCreatorRepository $repository The repository
     */
    public function __construct(UserCreatorRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Create a new user.
     *
     * @param array $data The form data
     *
     * @return array The new user ID in an array or an error array
     */
    public function createUser(array $data): array
    {
        // Input validation
        $result = $this->validateNewUserInput($data);

        if(! $result['errors']){
            // Insert user
            $result = $this->repository->insertUser($data);
            $result =  $this->validateUserSelectionOutput($result);
        }
        return $result;
    }

    /**
     * Input validation.
     *
     * @param array $data The input data to create the user
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
           $outputErrors['errorDescription'] = 'Failed inserting the user';
           $outputErrors['username'] = 'Username must be unique';
           $errors['errors'] =  $outputErrors;
        }
        
        return $outputErrors ? $errors : $data;
   }
}
