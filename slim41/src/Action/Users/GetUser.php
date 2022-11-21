<?php

namespace App\Action\Users;

use App\Domain\Users\Users;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class GetUser
{
  private $Users;
  public function __construct(Users $Users)
  {
    $this->Users = $Users;
  }
  public function __invoke(
      ServerRequestInterface $request, 
      ResponseInterface $response, $args
  ): ResponseInterface 
  {
    $Users = $this->Users->getUser($args);
    $response->getBody()->write((string)json_encode($Users));
    return $response
          ->withHeader('Content-Type', 'application/json');
  }
}