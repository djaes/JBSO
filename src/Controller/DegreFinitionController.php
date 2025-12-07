<?php
namespace JBSO\Controller;

use JBSO\Repository\DegreFinitionRepository;
use JBSO\Entity\DegreFinition;

class DegreFinitionController
{
    private DegreFinitionRepository $repository;

    public function __construct()
    {
        $this->repository = new DegreFinitionRepository();
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $degre = new DegreFinition();
            $degre->setLibelle($_POST['libelle']);
            $this->repository->save($degre);
            header('Location: /test/degreFinition/list');
            exit();
        }
        require __DIR__ . '/../templates/degreFinition/create.html.twig';
    }

    public function list()
    {
        $degres = $this->repository->findAll();
        require __DIR__ . '/../templates/degreFinition/list.html.twig';
    }

    public function delete(int $id)
    {
        $this->repository->delete($id);
        header('Location: /test/degreFinition/list');
        exit();
    }
}
