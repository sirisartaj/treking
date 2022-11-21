<?php
namespace App\Domain\Leads;

use App\Domain\Leads\LeadsRepository;
use App\Exception\ValidationException;
use App\Utilities\ImageUpload;

/**
 * Service.
 */
final class Leads
{
  /**
   * @var LeadsRepository
   */
  private $repository;
  /**
   * The constructor.
   *
   * @param LeadsRepository $repository The repository
   */
  public function __construct(LeadsRepository $repository)
  {
    $this->repository = $repository;
  }
  public function getLeads(): array
  {        
    $Leads = $this->repository->getLeads();
    return $Leads;
  }
  public function getLead($data): array 
  {
    $Leads = (array) $this->repository->getLead($data);
    return $Leads;
  }
  public function addLead($data) : array 
  {
    try {
      extract($data);
      $res = $this->repository->addLead($data);
      return $res;
    } catch(PDOException $e) {
      $status = array(
              'status' => "500",
              'message' => $e->getMessage()
          );
      return $status;
    } 
  }
  public function updateLead($data) : array 
  {
    try {
      extract($data);
      $res = $this->repository->updateLead($data);
      return $res;
    } catch(PDOException $e) {
      $status = array(
              'status' => "500",
              'message' => $e->getMessage()
          );
      return $status;
    } 
  }
  public function addLeadFollowup($data) {
    $Lead = $this->repository->addLeadFollowup($data);
    return $Lead;
  }
  public function getLeadFollowups($data) {
    $Lead = $this->repository->getLeadFollowups($data);
    return $Lead;
  }
  public function deleteLead($data) {
    $Lead = $this->repository->deleteLead($data);
    return $Lead;
  }
  public function getFollowupDetails($data) {
    $followup = $this->repository->getFollowupDetails($data);
    return $followup;
  }
  public function updateLeadFollowup($data) {
    $followup = $this->repository->updateLeadFollowup($data);
    return $followup;
  }
  public function deleteLeadFollowup($data) {
    $Lead = $this->repository->deleteLeadFollowup($data);
    return $Lead;
  }
  public function getUpcomingFollowups() {
     $followup = $this->repository->getUpcomingFollowups();
    return $followup;
  }
  public function updateLeadStatus($data) {
    $Lead = $this->repository->updateLeadStatus($data);
    return $Lead;
  }
  public function updateLeadFollowupStatus($data) {
    $Lead = $this->repository->updateLeadFollowupStatus($data);
    return $Lead;
  }
}