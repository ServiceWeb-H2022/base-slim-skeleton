<?php

namespace App\Domain\User\Service;

use App\Domain\User\Repository\UserReaderRepository;
use App\Exception\ValidationException;

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
     * Le constructeur.
     *
     * @param UserReaderRepository $repository Le "respository"
     */
    public function __construct(UserReaderRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Read users
     *
     * @param object $dataObj l'objet contenants le data pour la requete
     *
     * @return array Les données sortantes de l'usager
     */
    public function selectUser(object $dataObj): array
    {

        //TODO: Crée un constructeur ou méthodes pour le querryObj

        // Selection d"un usager
        if($dataObj->attribs->id){
            $querryObj = $dataObj;
            $resultat = $this->repository->selectSingleUser($querryObj);
        }

        // Selection de plusieurs usagers
        else {
            $querryObj = $dataObj;
            $resultat = $this->repository->selectManyUsers($querryObj);
        }

        return $resultat;
    }


    /**
     * Validation d'entrées.
     *
     * @param array $data L'array de données
     *
     * @return array
     */
    private function validateUserSelection(array $data): array
    {
        
        $errors = [];
        $rqstErrors = null;

        if (empty($data) ) {
           $rqstErrors['errorDescription'] = "Échec de la selection de l'usager";
           $rqstErrors['user/{id}'] = 'Aucun usager associé à cet identifiant';
           $errors['notFound-errors'] =  $rqstErrors;
        }
        // throw new ValidationException('Please check your input', $errors);
        
        return $rqstErrors ? $errors : $data;
   }
}


