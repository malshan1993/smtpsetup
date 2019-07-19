<?php

//PHP varible set
$body = array(
    'name' => $_POST['name'],
    'phone' => $_POST['phone'],
    'email' => $_POST['email'],
    'message' => $_POST['message'],
);

//Setting setup 
/**
 * Logo - add logo image PHPMailer folder anl link ex: PHPMailer/logo.png
 * Address - Address footer
 * TP - Contact footer 
 * Email - Email footer 
 * smtphost - ex: smtp.gmail.com
 * smtpport - 443 or 587 or 465
 * smtpsecure - Secure tls or ssl
 * smtpuser - smtp username
 * smtppass - smtp password
 */
$settings = (object) array(
    'logo' => '',
    'address' => '',
    'tp' => '',
    'email' => '',
    'smtphost' => '',
    'smtpport' => '',
    'smtpsecure' => '',
    'smtpuser' => '',
    'smtppass' => '',
);

//Send email setup
$name = '';
$content = '';
$signature = '';
$subject = '';
$sender = '';


date_default_timezone_set('Etc/UTC');

include ('PHPMailer/PHPMailerAutoload.php');

//Create a new PHPMailer instance
$mail = new PHPMailer();

$dataArray = $body;


foreach($dataArray as $key => $dataItem){
    $submitData .= '<tr><td style="padding: 8px 0;"><b>'.$key.'</b></td><td style="padding: 8px 0;">'.$dataItem.'</td></tr>';
}

$mainBody = file_get_contents('PHPMailer/template.html'); 

$mainBody = str_replace('%submitData%',$submitData , $mainBody);

$mainBody = str_replace('%name%', $name , $mainBody );
$mainBody = str_replace('%content%', $content , $mainBody );
$mainBody = str_replace('%signature%', $signature , $mainBody );

$mainBody = str_replace('%email_logo%', $settings->logo , $mainBody );
$mainBody = str_replace('%email_adress%', nl2br($settings->address), $mainBody); 
$mainBody = str_replace('%email_tp%', $settings->tp, $mainBody); 
$mainBody = str_replace('%email_email%', $settings->email, $mainBody); 

$mail->ClearAllRecipients();

//Tell PHPMailer to use SMTP
$mail->isSMTP();

// $mail->SMTPOptions = array(
//     'ssl' => array(
//         'verify_peer' => false,
//         'verify_peer_name' => false,
//         'allow_self_signed' => true
//     )
// );

//Enable SMTP debugging
// 0 = off (for production use)
// 1 = client messages
// 2 = client and server messages
$mail->SMTPDebug = 2;

//Ask for HTML-friendly debug output
$mail->Debugoutput = 'html';

//set keep live
$mail->SMTPKeepAlive = true;

//Set the hostname of the mail server
$mail->Host = $settings->smtphost;

//Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
$mail->Port = $settings->smtpport;

//Set the encryption system to use - ssl (deprecated) or tls
$mail->SMTPSecure = $settings->smtpsecure;

//Whether to use SMTP authentication
$mail->SMTPAuth = true;

//Username to use for SMTP authentication - use full email address for gmail
$mail->Username = $settings->smtpuser;

//Password to use for SMTP authentication
$mail->Password = $settings->smtppass;

//Set who the message is to be sent from
$mail->setFrom($sender, $subject);

//Set an alternative reply-to address
$mail->addReplyTo($sender, $subject);

//Set who the message is to be sent to
$mail->addAddress($sender, $subject);

//Set the subject line
$mail->Subject = $subject;

//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
$mail->msgHTML($mainBody);
//Replace the plain text body with one created manually
//$mail->AltBody = 'This is a plain-text message body';

//Attach an image file
//$mail->addAttachment('images/phpmailer_mini.png');
$mail->AddEmbeddedImage($settings->logo, "logos" );

//send the message, check for errors
//$mail->send();

if (!$mail->send()) {
    return false;
} else {
    //echo "Message sent!";
    return true;
}

?>