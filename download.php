 
 <?php

 ob_start();

    if (isset($_POST['submit'])) {
        $year = $_POST['year'];

        //echo $year;


       
 $zip = new ZipArchive();
  $filename = "./".$year.".zip";

  if ($zip->open($filename, ZipArchive::CREATE)!==TRUE) {
    exit("cannot open <$filename>\n");
  }

  $dir = $year.'/';

  // Create zip
  if (is_dir($dir)){

    if ($dh = opendir($dir)){
       while (($file = readdir($dh)) !== false){
 
         // If file
         if (is_file($dir.$file)) {
            if($file != '' && $file != '.' && $file != '..'){
 
               $zip->addFile($dir.$file);
            }
         }else{
            // If directory
            if(is_dir($dir.$file) ){

              if($file != '' && $file != '.' && $file != '..'){

                // Add empty directory
                $zip->addEmptyDir($dir.$file);

                $folder = $dir.$file.'/';
 
                // Read data of the folder
                createZip($zip,$folder);
              }
            }
 
         }
 
       }
       closedir($dh);
     }
  }


  $zip->close();

 
  $filename = $year.".zip";

  if (file_exists($filename)) {
     header('Content-Type: application/zip');
     header('Content-Disposition: attachment; filename="'.basename($filename).'"');
     header('Content-Length: ' . filesize($filename));
     header('Content-transfer-encoding: binary'); 

 while (ob_get_level()) {
        ob_end_clean();
        }

     flush();
     readfile($filename);

     // delete file
     unlink($filename);

     exit();
 
   }

    }

    ?>
 