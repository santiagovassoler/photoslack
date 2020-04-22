<?php

namespace PhotoSlack\Controller;

use PhotoSlack\Repository\ImageRepository;
use PhotoSlack\Repository\RepositoryInterface;

class SlackController extends AbstractController
{
    private $repo;

    public function __construct(RepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function index()
    {
        $collection = $this->repo->getCollection();
        $this->render('index',  $collection);
    }

    public function show($ts)
    {
        $image = $this->repo->show($ts);
        //var_dump($hey);
        $this->render('show', $image);
        //$data = $this->repo->show($ts);
        //$this->render('show', $data);
    }
}
