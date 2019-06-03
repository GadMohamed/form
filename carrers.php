<?php
header("Access-Control-Allow-Origin: *");
header('Content-type: application/json');
//recipient

$to = 'email@gmail.com';
echo $to;

//sender


$userMail = $_POST['userMail'];
$message = $_POST['message'];
$username = $_POST['username'];
$position = $_POST['position']; 
$from = $userMail;
$fromName = $userMail;

var_dump($_FILES);

echo $tempPath = $_FILES['file']['tmp_name'];
echo $actualName = $_FILES['file']['name'];

move_uploaded_file($tempPath,'/home3/public_html/uploadfile/'. $actualName);

//email subject
$subject = 'send'; 

//attachment file path
$file = '/home3/public_html/uploadfile/'. $actualName;

//email body content
$htmlContent = '
        <p><b>Name:</b> '.$username.'</p>
        <p><b>Email:</b> '.$userMail.'</p>
        <p><b>position:</b> '.$position.'</p>
        <p><b>Message:</b><br/>'.$message.'</p>';

//header for sender info
$headers = "From: $fromName"." <".$from.">";

//boundary 
$semi_rand = md5(time()); 
$mime_boundary = "==Multipart_Boundary_x{$semi_rand}x"; 

//headers for attachment 
$headers .= "\nMIME-Version: 1.0\n" . "Content-Type: multipart/mixed;\n" . " boundary=\"{$mime_boundary}\""; 

//multipart boundary 
$message = "--{$mime_boundary}\n" . "Content-Type: text/html; charset=\"UTF-8\"\n" .
"Content-Transfer-Encoding: 7bit\n\n" . $htmlContent . "\n\n"; 

//preparing attachment
if(!empty($file) > 0){
    if(is_file($file)){
        $message .= "--{$mime_boundary}\n";
        $fp =    @fopen($file,"rb");
        $data =  @fread($fp,filesize($file));

        @fclose($fp);
        $data = chunk_split(base64_encode($data));
        $message .= "Content-Type: application/octet-stream; name=\"".basename($file)."\"\n" . 
        "Content-Description: ".basename($file)."\n" .
        "Content-Disposition: attachment;\n" . " filename=\"".basename($file)."\"; size=".filesize($file).";\n" . 
        "Content-Transfer-Encoding: base64\n\n" . $data . "\n\n";
    }
}
$message .= "--{$mime_boundary}--";
$returnpath = "-f" . $from;

//send email
$mail = @mail($to, $subject, $message, $headers, $returnpath); 
//@unlink($file);

//email sending status
echo $mail?"<h1>Mail sent.</h1>":"<h1>Mail sending failed.</h1>";

?>