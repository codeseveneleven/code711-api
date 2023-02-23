<?php

declare(strict_types=1);

namespace Code711\Code711Api\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Http\JsonResponse;
use TYPO3\CMS\Core\Utility\VersionNumberUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class VersionController extends ActionController
{

    public function getVersionAction(ServerRequestInterface $request): ResponseInterface
    {
        $version = [
            'version' => VersionNumberUtility::getNumericTypo3Version(),
        ];
        return new JsonResponse($version);
    }
}
