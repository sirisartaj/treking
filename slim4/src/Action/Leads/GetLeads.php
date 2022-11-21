<?php
namespace App\Action\Leads;

use App\Domain\Leads\Leads;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class GetLeads
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
    $leads = $this->leads->getLeads();
    $response->getBody()->write((string)json_encode($leads));
    return $response
          ->withHeader('Content-Type', 'application/json');
  }
}