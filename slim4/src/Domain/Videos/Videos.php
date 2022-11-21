<?php
namespace App\Domain\Videos;

use App\Domain\Videos\VideosRepository;
use App\Exception\ValidationException;
use App\Utilities\ImageUpload;

/**
 * Service.
 */
final class Videos
{
  /**
   * @var BannersRepository
   */
  private $repository;
  /**
   * The constructor.
   *
   * @param BannersRepository $repository The repository
   */
  public function __construct(VideosRepository $repository)
  {
    $this->repository = $repository;
  }
  public function getVideos(): array
  {        
    $Videos = $this->repository->getVideos();
    return $Videos;
  }
  public function getVideo($data): array 
  {
    $Videos = (array) $this->repository->getVideo($data);
    return $Videos;
  }
  public function deleteVideo($data) :array 
  {
    $Videos = $this->repository->deleteVideo($data);
    return $Videos;
  }
  public function addVideo($data) : array 
  {    
    $res = $this->repository->addVideo($data);
    return $res;    
  }
  public function updateVideo($data) : array 
  {    
    $res = $this->repository->updateVideo($data);
    return $res;    
  }
  public function updateVideoStatus($data) : array 
  {    
    $res = $this->repository->updateVideoStatus($data);
    return $res;    
  }
}