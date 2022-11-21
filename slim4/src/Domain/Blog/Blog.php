<?php
namespace App\Domain\Blog;

use App\Domain\Blog\BlogRepository;
use App\Exception\ValidationException;
use App\Utilities\ImageUpload;

/**
 * Service.
 */
final class Blog
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
  public function __construct(BlogRepository $repository)
  {
    $this->repository = $repository;
  }
  public function getBlogs(): array
  {        
    $Blog = $this->repository->getBlogs();
    return $Blog;
  }
  public function getBlog($data): array 
  {
    $Blog = (array) $this->repository->getBlog($data);
    return $Blog;
  }
  public function updateBlog($data) : array 
  {    
    extract($data);
    if(isset($blogImage)&&!empty($blogImage)){
      $filedir = UPLOADPATH."blog/"; 
      $randName = rand(10101010, 9090909090);
      $newName = "blog_". $randName;
      $ext = substr($blogImage['name'], strrpos($blogImage['name'], '.') + 1);
      $ImageUpload = new ImageUpload;
      $ImageUpload->File = $blogImage;
      $ImageUpload->method = 1;
      $ImageUpload->SavePath = $filedir;
      $ImageUpload->NewWidth = '100';
      $ImageUpload->NewHeight = '100';
      $ImageUpload->NewName = $newName;
      $ImageUpload->OverWrite = true;
      $err = $ImageUpload->UploadFile();
      $blogImage = $newName.".".strtolower($ext);              
    }
    $res = $this->repository->updateBlog($data);
    return $res;    
  }
  public function updateBlogStatus($data) : array 
  {    
    extract($data);
    $res = $this->repository->updateBlogStatus($data);
    return $res;    
  }
  public function getBlogArticles($data) {
    $blog = $this->repository->getBlogArticles($data);
    return $blog;
  }
  public function getBlogArticleDetails($data) {
    $blog = $this->repository->getBlogArticleDetails($data);
    return $blog;
  }
  public function getBlogCategories($data) {
    $blog = $this->repository->getBlogCategories($data);
    return $blog;
  } 
  public function addBlogArticle($data) {    
    extract($data);
    if(isset($postImage)&&!empty($postImage)){
      $filedir = UPLOADPATH."blog/"; 
      $randName = rand(10101010, 9090909090);
      $newName = "blog_". $randName;
      $ext = substr($postImage['name'], strrpos($postImage['name'], '.') + 1);
      $ImageUpload = new ImageUpload;
      $ImageUpload->File = $postImage;
      $ImageUpload->method = 1;
      $ImageUpload->SavePath = $filedir;
      $ImageUpload->NewWidth = '100';
      $ImageUpload->NewHeight = '100';
      $ImageUpload->NewName = $newName;
      $ImageUpload->OverWrite = true;
      $err = $ImageUpload->UploadFile();
      $postImage = $newName.".".strtolower($ext);              
    }
    $res = $this->repository->addBlogArticle($data);
    return $res;    
  }
  public function updateBlogArticle($data) {    
    extract($data);
    if(isset($postImage)&&!empty($postImage)){
      $filedir = UPLOADPATH."blog/"; 
      $randName = rand(10101010, 9090909090);
      $newName = "blog_". $randName;
      $ext = substr($postImage['name'], strrpos($postImage['name'], '.') + 1);
      $ImageUpload = new ImageUpload;
      $ImageUpload->File = $postImage;
      $ImageUpload->method = 1;
      $ImageUpload->SavePath = $filedir;
      $ImageUpload->NewWidth = '100';
      $ImageUpload->NewHeight = '100';
      $ImageUpload->NewName = $newName;
      $ImageUpload->OverWrite = true;
      $err = $ImageUpload->UploadFile();
      $postImage = $newName.".".strtolower($ext);              
    }
    $res = $this->repository->updateBlogArticle($data);
    return $res;    
  }
  public function updateArticleStatus($data) {  
    $res = $this->repository->updateArticleStatus($data);
    return $res;    
  }
  public function deleteArticle($data) {  
    $res = $this->repository->deleteArticle($data);
    return $res;    
  }
}