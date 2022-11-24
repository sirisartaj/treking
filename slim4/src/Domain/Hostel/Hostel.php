<?php
namespace App\Domain\Hostel;

use App\Domain\Hostel\HostelRepository;
use App\Exception\ValidationException;
use App\Utilities\ImageUpload;

/**
 * Service.
 */
final class Hostel
{
  /**
   * @var HostelRepository
   */
  private $repository;
  /**
   * The constructor.
   *
   * @param HostelRepository $repository The repository
   */
  public function __construct(HostelRepository $repository)
  {
    $this->repository = $repository;
  }
  public function Gethostels(): array
  {        
    $Hostel = $this->repository->getHostels();
    return $Hostel;
  }
  public function addHostel($data) {
    extract($data);
    $Hostel = $this->repository->addHostel($data);
    return $Hostel;
  }
  public function updateHostel($data) {
	  
    extract($data);
    
    $Hostel = $this->repository->updateHostel($data);
    return $Hostel;
  }
  public function getHostel($data): array
  {        
    $Hostel = $this->repository->getHostel($data);
    return $Hostel;
  }
  public function updateHostelStatus($data) {
    $Hostel = $this->repository->updateHostelStatus($data);
    return $Hostel;
  }
  
}