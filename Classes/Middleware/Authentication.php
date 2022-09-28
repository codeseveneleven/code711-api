<?php

namespace Code711\Code711Api\Middleware;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\SignatureInvalidException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use TYPO3\CMS\Core\Http\JsonResponse;

class Authentication implements MiddlewareInterface
{

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $authorization = $request->getHeader('Authorization')[0];
        if (strpos($authorization, 'Bearer ') !== 0) {
            return new JsonResponse(
                [
                    'message' => 'Authorization header not found.',
                    'headers' => $request->getHeaders(),
                ],
                403
            );
        }
        $jwt = trim(str_replace('Bearer ', '', $authorization), '"\'');

        try {
            $data = (array)JWT::decode($jwt, new Key(getenv('REST_API_SECRET'), 'HS256'));
        } catch (SignatureInvalidException $exception) {
            return new JsonResponse(['message' => 'Web Token is invalid', 'error' => $exception->getMessage()], 401);
        }
        if (!$data) {
            return new JsonResponse(['message' => 'Web Token is invalid'], 401);
        }
        if ($data['expires'] < time()) {
            return new JsonResponse(['message' => 'Web Token has expired'], 401);
        }
        $request = $request->withAddedHeader('api-user', (string)$data['user_id']);

        return $handler->handle($request);
    }

}
