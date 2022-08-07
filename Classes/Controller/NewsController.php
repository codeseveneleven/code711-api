<?php

namespace Code711\Code711Api\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Http\JsonResponse;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class NewsController extends ActionController
{

    public function getNewsListAction(ServerRequestInterface $request): ResponseInterface
    {
        $news = [];

        return new JsonResponse($news);
    }
}
