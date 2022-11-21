<?php

namespace App\Action\CampaignManagement;

use App\Domain\CampaignManagement\CampaignManagement;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class GetTemplateDetails
{
  private $campaignManagement;
  public function __construct(CampaignManagement $campaignManagement)
  {
    $this->campaignManagement = $campaignManagement;
  }
  public function __invoke(
      ServerRequestInterface $request, 
      ResponseInterface $response, $args 
  ): ResponseInterface
  {
    $campaignManagement = $this->campaignManagement->getTemplateDetails($args);
    $response->getBody()->write((string)json_encode($campaignManagement));
    return $response
          ->withHeader('Content-Type', 'application/json');
  }
}