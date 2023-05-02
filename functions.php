<?php
function total_views($db)
{
    // count total website views
    $query = "SELECT sum(total_views) as total_views FROM pages";
    $rec = $db->query($query)->fetchAll(PDO::FETCH_OBJ);
        return $rec[0]->total_views;
}

function is_unique_view($page_id,$db)
{
    $visitor_ip = $_SERVER['REMOTE_ADDR'];
  $rec = $db->query("SELECT * FROM page_views WHERE visitor_ip='$visitor_ip' AND page_id='$page_id'")->fetchAll(PDO::FETCH_OBJ);
  if(sizeof($rec) > 0)
  {
    return false;
  }
  else
  {
    return true;
  }
}

function add_view( $page_id,$db)
{
  $visitor_ip = $_SERVER['REMOTE_ADDR'];
  /*$yy = date('y');
    $mm =date('m');  **** this is an abandoned idea *********
    $my = $db->query("SELECT * FROM `pages` WHERE month(dates) = $mm and year(dates)= $yy")->fetchAll(PDO::FETCH_OBJ);*/
  if(is_unique_view($page_id,$db) === true)
  {
    // insert unique visitor record for checking whether the visit is unique or not in future.
    $query = "INSERT INTO page_views (visitor_ip, page_id) VALUES ('$visitor_ip', '$page_id')";
    $db ->exec($query);
      // At this point unique visitor record is created successfully. Now update total_views of specific page.
      $query1 = "UPDATE pages SET total_views = total_views + 1 WHERE id='$page_id'";
      $db ->exec($query1);
    }
    else{
      $query1 = "UPDATE pages SET total_views = total_views + 1 WHERE id='$page_id'";
      $db ->exec($query1);
    }
    $q = "INSERT INTO activity (dates, visitor, page) VALUES (NOW(), '$visitor_ip', '$page_id')" ;
    $db ->exec($q);
}

function logincount( $page_id,$db)
{
    // count total website views
    $query = "SELECT total_views  FROM pages where id=4";
    $rec = $db->query($query)->fetchAll(PDO::FETCH_OBJ);
        return $rec[0]->total_views;
}
?>