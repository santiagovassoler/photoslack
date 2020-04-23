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
        $this->list();
        $this->render('index',  []);
    }

    public function list()
    {
        $collection = $this->repo->getCollection();
        $this->render('list',  $collection);
    }

    public function show($ts)
    {
        $image = $this->repo->show($ts);
        $this->render('show', $image);
    }
}
