<?php
namespace App\Domain\Blog;
use PDO;
/**
* Repository.
*/
class BlogRepository
{
  /**
   * @var PDO The database connection
   */
  private $connection;
  /**
   * Constructor.
   *
   * @param PDO $connection The database connection
   */
  public function __construct(PDO $connection)
  {
    $this->connection = $connection;
  }
  /**
   * Get Admin Roles rows.
   *
   * @return array 
   */
  public function getBlogs(): array
  {      
    try {
      $sql = "SELECT blog_id AS blogId, blog_title AS blogTitle, CONCAT('".UPLOADURL."blog/', `blog_image`) AS blogImage, blog_url AS blogUrl, posting_date AS postingDate, created_date AS createdDate, created_by AS createdBy, modified_by AS modifiedBy FROM sg_blog";
      $stmt = $this->connection->prepare($sql);  
      $stmt->execute();
      $blog = $stmt->fetchAll(PDO::FETCH_OBJ);
      if(!empty($blog)){
       $status = array(
         'status' => ERR_OK,
         'message' =>"Success",
         'blog' => $blog);
        return $status;
      }else{
        $status = array('status'=>ERR_NO_DATA,
         'message'=>"No Data Found");
         return $status;
      }
    } catch(PDOException $e) {
      $status = array(
              'status' => "500",
              'message' => $e->getMessage()
          );
      return $status;
    }
  }
  public function getBlog($data) {
    try {
      extract($data);
      $sql = "SELECT blog_id AS blogId, blog_title AS blogTitle, CONCAT('".UPLOADURL."blog/', `blog_image`) AS blogImage, blog_url AS blogUrl, posting_date AS postingDate, created_date AS createdDate, created_by AS createdBy, modified_by AS modifiedBy FROM sg_blog WHERE blog_id = :blog_id LIMIT 0,1";
      $stmt = $this->connection->prepare($sql);  
      $stmt->bindParam(':blog_id', $blogId);
      $stmt->execute();
      $blog = $stmt->fetch(PDO::FETCH_OBJ);
      if(!empty($blog)){
        $status = array(
                  'status' => ERR_OK,
                  'message' => "Success",
                  'blog_details' => $blog);
        return $status;
      }else{
        $status = array('status'=> ERR_NO_DATA,
         'message'=>"No Data Found");
        return $status;
      }
    } catch(PDOException $e) {
      $status = array(
              'status' => "500",
              'message' => $e->getMessage()
          );
      return $status;
    }
  }
  public function updateBlog($data) 
  {
    try {
      extract($data);
      $sql  = "UPDATE sg_blog SET blog_title=:blog_title, blog_image=:blog_image, blog_url=:blog_url , posting_date = :posting_date, modified_date = :modified_date, modified_by = :modified_by  WHERE blog_id = :blog_id";  
      $stmt = $this->connection->prepare($sql);
      $strDate = substr($postingDate,4,11);
      $modified_date = date("Y-m-d H:i:s");
      $posting_date = date('Y-m-d', strtotime($strDate));
      $stmt->bindParam(':blog_title', $blogTitle);
      $stmt->bindParam(':blog_image', $blogImage);
      $stmt->bindParam(':blog_url', $blogUrl);
      $stmt->bindParam(':posting_date', $posting_date);
      $stmt->bindParam(":modified_date", $modified_date);
      $stmt->bindParam(":modified_by", $userBy);
      $stmt->bindParam(':blog_id', $blogId);
      $res = $stmt->execute();
      if($res){
        $status = array(
          "status" => ERR_OK,
          "message" => "Updated Successfully");
        return $status;
      }else{
        $status = array(
          "status" => ERR_NO_DATA,
          "message" => "Not Updated Successfully");
        return $status;
      }
    } catch(PDOException $e) {
      $status = array(
              'status' => "500",
              'message' => $e->getMessage()
          );
      return $status;
    } 
  }
  public function updateBlogStatus($data) 
  {
    try {
      extract($data);
      $sql  = "UPDATE sg_blog SET status=:status, modified_date = :modified_date, modified_by = :modified_by  WHERE blog_id = :blog_id";  
      $stmt = $this->connection->prepare($sql);
      $modified_date = date("Y-m-d H:i:s");
      $stmt->bindParam(':status', $status);
      $stmt->bindParam(":modified_date", $modified_date);
      $stmt->bindParam(":modified_by", $userBy);
      $stmt->bindParam(':blog_id', $blogId);
      $res = $stmt->execute();
      if($res){
        $status = array(
          "status" => ERR_OK,
          "message" => "Updated Successfully");
        return $status;
      }else{
        $status = array(
          "status" => ERR_NO_DATA,
          "message" => "Not Updated Successfully");
        return $status;
      }
    } catch(PDOException $e) {
      $status = array(
              'status' => "500",
              'message' => $e->getMessage()
          );
      return $status;
    } 
  }
  public function getBlogArticles($data) {
    try {
      extract($data);
      if(isset($offset) && $offset!=''){
        $offset  = $offset;
      }
      else {
        $offset = 0;
      }
      if(isset($record_count) && ($record_count!='')){
        $record_count = $record_count;
      }
      else {
        $record_count = 50;
      }
      $offsetid = $offset * $record_count;
      $limit = $offsetid + $record_count;
      $sql = "SELECT *, get_user_name(post_author) AS userName FROM sg_posts WHERE post_status != 'delete' ORDER BY post_date DESC LIMIT ".$offsetid.",".$record_count;
      $stmt = $this->connection->prepare($sql);  
      $stmt->execute();
      $blog = $stmt->fetchAll(PDO::FETCH_OBJ);
      if(!empty($blog)){
       $status = array(
         'status' =>"200",
         'message' =>"Success",
         'blog' => $blog);
        return $status;
      }else{
        $status = array('status'=>"204",
         'message'=>"No Data Found");
         return $status;
      }
    } catch(PDOException $e) {        
      $status = array(
                'status' => "500",
                'message' => $e->getMessage()
                );
      return $status;       
    }
  }
  public function getBlogArticleDetails($data) {
    try {
      extract($data);
      
      $sql = "SELECT *, get_user_name(post_author) AS userName, get_post_category_name(post_parent) AS category_name FROM sg_posts WHERE ID='$id'";
      $stmt = $this->connection->prepare($sql);  
      $stmt->execute();
      $blog = $stmt->fetch(PDO::FETCH_OBJ);
      if(!empty($blog)){
       $status = array(
         'status' =>"200",
         'message' =>"Success",
         'blog' => $blog);
        return $status;
      }else{
        $status = array('status'=>"204",
         'message'=>"No Data Found");
         return $status;
      }
    } catch(PDOException $e) {        
      $status = array(
                'status' => "500",
                'message' => $e->getMessage()
                );
      return $status;       
    }
  }
  public function getBlogCategories($data) {
    try {
      extract($data);      
      $sql = "SELECT * FROM sg_post_categories WHERE status = '0' ORDER BY category_id DESC";
      $stmt = $this->connection->prepare($sql);  
      $res = $stmt->execute();
      $blog = $stmt->fetchAll(PDO::FETCH_OBJ);
      if(!empty($blog)){
        $status = array(
         'status' =>"200",
         'message' =>"Success",
         'categories' => $blog);
        return $status;
      }else{
        $status = array('status'=>"204",
         'message'=>"No Data Found");
         return $status;
      }
    } catch(PDOException $e) {        
      $status = array(
                'status' => "500",
                'message' => $e->getMessage()
                );
      return $status;       
    }
  }
  public function addBlogArticle($data) 
  {
    try {
      extract($data);
      $modified_date = date("Y-m-d H:i:s");
      $guid = 'test';$comment_count ='0';
      $posting_date = date('Y-m-d', strtotime($posting_date));
      $sql  = "INSERT INTO `sg_posts`(`post_author`, `post_date`, `post_content`, `post_title`,`post_excerpt`, `post_status`, `comment_status`, `post_modified`, `post_parent`, `guid`, `comment_count`, `post_image`) VALUES (:post_author, :post_date, :post_content, :post_title, :post_excerpt, :post_status, :comment_status, :post_modified, :post_parent, :guid, :comment_count, :post_image)";      
      $stmt = $this->connection->prepare($sql);      
      $stmt->bindParam(':post_author', $userBy);
      $stmt->bindParam(':post_date', $posting_date);
      $stmt->bindParam(':post_content', $post_content);
      $stmt->bindParam(':post_title', $post_title);
      $stmt->bindParam(":post_excerpt", $post_excerpt);
      $stmt->bindParam(":post_status", $post_status);
      $stmt->bindParam(':comment_status', $comment_status);
      $stmt->bindParam(':post_modified', $modified_date);
      $stmt->bindParam(':post_parent', $category_id);
      $stmt->bindParam(":guid", $guid);
      $stmt->bindParam(":comment_count", $comment_count);
      $stmt->bindParam(':post_image', $postImage);
      $res = $stmt->execute();
      if($res){
        $status = array(
          "status" => ERR_OK,
          "message" => "Article added Successfully");
        return $status;
      }else{
        $status = array(
          "status" => ERR_NO_DATA,
          "message" => "Not Added Successfully");
        return $status;
      }
    } catch(PDOException $e) {
      $status = array(
              'status' => "500",
              'message' => $e->getMessage()
          );
      return $status;
    } 
  }
  public function updateBlogArticle($data) 
  {
    try {
      extract($data);
      $sql  = "UPDATE `sg_posts` SET `post_author`=:post_author,`post_date`=:post_date,`post_content`=:post_content,`post_title`=:post_title,`post_excerpt`=:post_excerpt,`post_status`=:post_status,`comment_status`=:comment_status,`post_modified`=:post_modified,`post_parent`=:post_parent,`post_image`=:post_image WHERE ID=:id";      
      $stmt = $this->connection->prepare($sql);
      $modified_date = date("Y-m-d H:i:s");
      $guid = '';
      $posting_date = date('Y-m-d', strtotime($strDate));
      $stmt->bindParam(':post_author', $userBy);
      $stmt->bindParam(':post_date', $posting_date);
      $stmt->bindParam(':post_content', $post_content);
      $stmt->bindParam(':post_title', $post_title);
      $stmt->bindParam(":post_excerpt", $post_excerpt);
      $stmt->bindParam(":post_status", $post_status);
      $stmt->bindParam(':comment_status', $comment_status);
      $stmt->bindParam(':post_modified', $modified_date);
      $stmt->bindParam(':post_parent', $category_id);
      $stmt->bindParam(":id", $id);
      $stmt->bindParam(':post_image', $postImage);
      $res = $stmt->execute();
      if($res){
        $status = array(
          "status" => ERR_OK,
          "message" => "Article updated Successfully");
        return $status;
      }else{
        $status = array(
          "status" => ERR_NO_DATA,
          "message" => "Not updated Successfully");
        return $status;
      }
    } catch(PDOException $e) {
      $status = array(
              'status' => "500",
              'message' => $e->getMessage()
          );
      return $status;
    } 
  }
  public function updateArticleStatus($data) 
  {
    try {
      extract($data);
      $sql  = "UPDATE `sg_posts` SET `post_status`=:post_status, `post_modified`=:post_modified WHERE ID=:id";      
      $stmt = $this->connection->prepare($sql);
      $modified_date = date("Y-m-d H:i:s");
      $guid = '';
      //$posting_date = date('Y-m-d', strtotime($strDate));     
      $stmt->bindParam(":post_status", $post_status);
      $stmt->bindParam(':post_modified', $modified_date);
      $stmt->bindParam(":id", $id);
      $res = $stmt->execute();
      if($res){
        $status = array(
          "status" => ERR_OK,
          "message" => "Article updated Successfully");
        return $status;
      }else{
        $status = array(
          "status" => ERR_NO_DATA,
          "message" => "Not updated Successfully");
        return $status;
      }
    } catch(PDOException $e) {
      $status = array(
              'status' => "500",
              'message' => $e->getMessage()
          );
      return $status;
    } 
  }
  public function deleteArticle($data) 
  {
    try {
      extract($data);
      $sql  = "UPDATE `sg_posts` SET `post_status`='delete', `post_modified`=:post_modified WHERE ID=:id";      
      $stmt = $this->connection->prepare($sql);
      $modified_date = date("Y-m-d H:i:s");
      $guid = '';
      //$posting_date = date('Y-m-d', strtotime($strDate));     
      //$stmt->bindParam(":post_status", $post_status);
      $stmt->bindParam(':post_modified', $modified_date);
      $stmt->bindParam(":id", $id);
      $res = $stmt->execute();
      if($res){
        $status = array(
          "status" => ERR_OK,
          "message" => "Article deleted Successfully");
        return $status;
      }else{
        $status = array(
          "status" => ERR_NO_DATA,
          "message" => "Not deleted Successfully");
        return $status;
      }
    } catch(PDOException $e) {
      $status = array(
              'status' => "500",
              'message' => $e->getMessage()
          );
      return $status;
    } 
  }
}