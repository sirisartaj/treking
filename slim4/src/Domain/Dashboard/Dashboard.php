<?php
namespace App\Domain\Dashboard;

use App\Domain\Dashboard\DashboardRepository;
use App\Exception\ValidationException;
use App\Utilities\ImageUpload;

/**
 * Service.
 */
final class Dashboard
{
  /**
   * @var DashboardRepository
   */
  private $repository;
  /**
   * The constructor.
   *
   * @param DashboardRepository $repository The repository
   */
  public function __construct(DashboardRepository $repository)
  {
    $this->repository = $repository;
  }
  public function getDashboard(): array
  {        
    $Dashboard = $this->repository->getDashboard();
    return $Dashboard;
  }
}