<?php



if ((($_FILES["file"]["type"] == "image/gif")
|| ($_FILES["file"]["type"] == "image/jpeg")
|| ($_FILES["file"]["type"] == "image/jpg")
|| ($_FILES["file"]["type"] == "image/pjpeg"))
&& ($_FILES["file"]["size"] < 1000000))
  {
  if ($_FILES["file"]["error"] > 0)
    {
    echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
    }
  else
    {
   

    if (file_exists("/datastore/webdb1243/htdocs/Uploads/" . $_FILES["file"]["name"]))
      {
      echo $_FILES["file"]["name"] . " already exists. ";
      }
    else
      {
      move_uploaded_file($_FILES["file"]["tmp_name"],
      "/datastore/webdb1243/htdocs/Uploads/" . $_FILES["file"]["name"]);
      }
    }
  }
else
  {
  echo "Invalid file" . $_FILES["file"]["size"] . " " . $_FILES["file"]["type"];
  }
?>