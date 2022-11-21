<?php

namespace App\Action\Users;

use App\Domain\Users\Users;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class UpdateUser
{
  private $Users;
  public function __construct(Users $Users)
  {
    $this->Users = $Users;
  }
  public function __invoke(
      ServerRequestInterface $request, 
      ResponseInterface $response
  ): ResponseInterface 
  {
      $data = $request->getBody();
     $data =(array) json_decode($data);
    $data = array_merge($data, $_FILES);
    $Users = $this->Users->updateUser($data);
    $response->getBody()->write((string)json_encode($Users));
    return $response
          ->withHeader('Content-Type', 'application/json');
  }
}