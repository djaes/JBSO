<?php
// src/Controller/AbstractControllerInterface.php
namespace JBSO\Controller;

interface AbstractControllerInterface
{
    public function list();

    public function show(int $id);

    public function showCreateForm();

    public function create();

    public function showUpdateForm(int $id);

    public function update(int $id);

    public function delete(int $id);


}
