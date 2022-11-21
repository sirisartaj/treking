<?php

namespace App\Action\CampaignManagement;

use App\Domain\CampaignManagement\CampaignManagement;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class AddTemplate
{
  private $campaignManagement;
  public function __construct(CampaignManagement $campaignManagement)
  {
    $this->campaignManagement = $campaignManagement;
  }
  public function __invoke(
      ServerRequestInterface $request, 
      ResponseInterface $response 
  ): ResponseInterface
  {
     // $data = $request->getParsedBody();
    // $data =(array) json_decode($data);
    $data = array_merge($_POST, $_FILES);
    $campaignManagement = $this->campaignManagement->addTemplate($data);
    $response->getBody()->write((string)json_encode($campaignManagement));
    return $response
          ->withHeader('Content-Type', 'application/json');
  }
}