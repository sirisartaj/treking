<?php

namespace App\Action\CampaignManagement;

use App\Domain\CampaignManagement\CampaignManagement;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class GetTemplates
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
    $campaignManagement = $this->campaignManagement->getTemplates();
    $response->getBody()->write((string)json_encode($campaignManagement));
    return $response
          ->withHeader('Content-Type', 'application/json');
  }
}