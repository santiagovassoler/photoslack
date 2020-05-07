<?php

namespace PhotoSlack\Controller;

use PhotoSlack\Repository\RepositoryInterface;

class MessageController extends AbstractController
{
    /* @var RepositoryInterface */
    private $repo;

    /**
     * MessageController constructor.
     * @param RepositoryInterface $repo
     */
    public function __construct(RepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    /**
     *  renders a collection of all images
     */
    public function index() : void
    {
        $this->list();
        $this->render('index', []);
    }

    /**
     *  renders a collection of all images
     */
    public function list() : void
    {
        $collection = $this->repo->getCollection();
        $this->render('list', $collection);
    }

    /**
     *  renders a single image
     *  @param $ts
     */
    public function show($ts) : void
    {
        $image = $this->repo->show($ts);
        $this->render('show', $image);
    }
}
