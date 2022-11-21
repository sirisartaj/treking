<?php

namespace App\Action\Leads;

use App\Domain\Leads\Leads;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class UpdateLeadFollowup
{
  private $leads;
  public function __construct(Leads $leads)
  {
    $this->leads = $leads;
  }
  public function __invoke(
      ServerRequestInterface $request, 
      ResponseInterface $response
  ): ResponseInterface 
  {
    $data = $request->getBody();
    $data =(array) json_decode($data);
    $leads = $this->leads->updateLeadFollowup($data);
    $response->getBody()->write((string)json_encode($leads));
    return $response
          ->withHeader('Content-Type', 'application/json');
  }
}