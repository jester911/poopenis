<?php
$images = "templates/images.txt";
$videos = "templates/videos.txt";
$audio = "templates/audio.txt";
$other = "templates/other.txt";
$Failsafe = 'templates/Failsafe.txt';
$targetdir = "uploads/";
$targetfile = $targetdir . basename($_FILES["fileToUpload"]["name"]);
$a = strtolower($targetfile);
$b = strtolower($filename);
$filename = basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$filetype = pathinfo($targetfile,PATHINFO_EXTENSION);
$under = strtolower($filetype);
$img = array("jpg", "png", "gif", "bmp"); 
$vid = array("webm", "mp4");
$aud = array("wav", "mp3", "ogg");
$php = array("php", "phtml", "php4", "php3", "php5", "phps" );
$temp =  $targetdir . basename($_FILES["fileToUpload"]["name"]);

rename($targetfile , "temp");
exec("chmod 664 temp");
rename($targetfile , $temp);

if(strpos($b, "index.") > 0){
	$uploadOk = 0;
	echo "Index files are not allowed, please rename. ";
}

if (file_exists($targetfile)) {
	echo "File $filename already exists, please rename. ";
    $uploadOk = 0;
} 
 // Check file size
if ($_FILES["fileToUpload"]["size"] > 50000000) {
    echo "File is too large.";
    $uploadOk = 0;
}

if(in_array($under, $php)) {
    echo "No hacking pls. If you want to share your file rename it to $filename.txt.";
    $uploadOk = 0;
} 
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $targetfile)) {
		file_put_contents($Failsafe, $filename, FILE_APPEND  | LOCK_EX);
		file_put_contents($Failsafe, "\n", FILE_APPEND  | LOCK_EX);
		if(in_array($under, $img)){
			file_put_contents($images, $filename, FILE_APPEND | LOCK_EX);
			file_put_contents($images, "\n", FILE_APPEND | LOCK_EX);
		}
		elseif(in_array($under, $vid)){
			file_put_contents($video, $b, FILE_APPEND | LOCK_EX);
			file_put_contents($video, "\n", FILE_APPEND | LOCK_EX);
		}
		elseif(in_array($under, $aud)){
			file_put_contents($audio, $b, FILE_APPEND | LOCK_EX);
			file_put_contents($audio, "\n", FILE_APPEND | LOCK_EX);
		}
		else{
			file_put_contents($other, $b, FILE_APPEND | LOCK_EX);
			file_put_contents($other, "\n", FILE_APPEND | LOCK_EX);
		}
		
        header("Location: http://poopenis.tk/uploads/" . $filename, 303);
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
?> 
