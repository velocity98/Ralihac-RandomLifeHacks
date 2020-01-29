<?php
require_once '../system/initialize.php';

  $connection = $db->query("SELECT * FROM hack_db ORDER BY hack_id DESC");
  $output = '';
 while ($row = mysqli_fetch_assoc($connection)){
  $hack_id = $row['hack_id'];
  $likeQuery = $db->query("SELECT * FROM like_db WHERE hack_id = $hack_id");
  $saveQuery = $db->query("SELECT * FROM save_db WHERE hack_id = $hack_id");
    $output .= "
    <div class='col-md-4'>
      <div class='card widget card-spacing' id='card-hack'>
      <div class='card card-holder'>
        <img src='".trim_image_string($row['hack_image'])."' onclick='hackModal($hack_id)' style='width: auto; height:11rem;'/>
        </div>
        <div class='card-header'>
          <b>".$row['hack_name']."</b>
        </div>
        <div class='card-body card-body-css'>
          <p>
            ".custom_echo($row['hack_description'], 56, $hack_id)."
          </p>
        </div>
        <div class='card-footer'>
          <button onclick='mostLikeButton(".$row['hack_id'].")' class='fas fa-thumbs-up
          ";
          $store = false;
          while ($rowLikes = mysqli_fetch_assoc($likeQuery)) {
            if($rowLikes['user_id'] == $user_id){
              $store = true;
            }
          }
        $output .= ($store == true) ? ' text-primary ' : ' text-secondary ';
        $output.=
          "like-button float-left' id='mostLikeButton".$row['hack_id']."'> <span id='mostLikeCount".$row['hack_id']."'>".mysqli_num_rows($likeQuery)."</span></button>
          <button onclick='mostSaveButton(".$row['hack_id'].")' class='fas fa-bookmark
          ";
          $storeSaved = false;
          while ($rowLikes = mysqli_fetch_assoc($saveQuery)) {
            if($rowLikes['user_id'] == $user_id){
              $storeSaved = true;
            }
          }
        $output .= ($storeSaved == true) ? ' text-success ' : ' text-secondary ';
        $output .=
          "like-button float-right' id='mostSaveButton".$row['hack_id']."'><span id='mostSaveStatus".$row['hack_id']."'>";
        $output .= ($storeSaved == true) ? ' Saved' : ' Save ';
        $output .="</span></button>
        </div>
      </div>
    </div>";
}
if ($output == ''){
  echo $output .= "<span class='no-item text-danger text-justify d-block col-md-12'><i class='fas fa-exclamation-circle'></i> You haven't saved any hacks yet</span>";
}else{
  echo $output;
}
?>
