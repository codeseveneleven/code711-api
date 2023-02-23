<?php

declare(strict_types=1);

namespace Code711\Code711Api\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use TYPO3\CMS\Core\Http\JsonResponse;

class BasicAuthentication implements MiddlewareInterface
{

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $header = $request->getHeader('authorization');
        if (isset($header[0])) {
            $authorization = $request->getHeader('authorization')[0];

            if (str_starts_with($authorization, 'Basic ')) {
                return new JsonResponse(
                    [
                        'message' => 'Authorization header not found.',
                        'headers' => $request->getHeaders(),
                    ],
                    403
                );
            }
            $authKey = trim(str_replace('Basic ', '', $authorization), '"\'');
            $key = base64_encode(getenv('REST_API_USER') . ':' . getenv('REST_API_PW'));
            if ($authKey !== $key) {
                return new JsonResponse(['message' => 'Web Token is invalid'], 401);
            }
        }
        return $handler->handle($request);
    }

}
