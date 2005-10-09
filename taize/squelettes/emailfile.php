<?php
// --- Create Message Text
$form_fields=array_keys($HTTP_POST_VARS);
$temp="Sender's IP Address = " . $REMOTE_ADDR . "\n";
while($field=array_pop($form_fields)){
    $temp.=" $field : = $HTTP_POST_VARS[$field] \n";
}

// Read POST request params into global vars
$to      = $_POST['to'];
$from    = $_POST['Email'];
$message = $temp;

// Obtain file upload vars
$fileatt      = $_FILES['File']['tmp_name'];
$fileatt_type = $_FILES['File']['type'];
$fileatt_name = $_FILES['File']['name'];

$headers = "From: $from";

if (is_uploaded_file($fileatt)) {
  // Read the file to be attached ('rb' = read binary)
  $file = fopen($fileatt,'rb');
  $data = fread($file,filesize($fileatt));
  fclose($file);

  // Generate a boundary string
  $semi_rand = md5(time());
  $mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";

  // Add the headers for a file attachment
  $headers .= "\nMIME-Version: 1.0\n" .
              "Content-Type: multipart/mixed;\n" .
              " boundary=\"{$mime_boundary}\"";

  // Add a multipart boundary above the plain message
  $message = "This is a multi-part message in MIME format.\n\n" .
             "--{$mime_boundary}\n" .
             "Content-Type: text/plain; charset=\"UTF-8\"\n" .
             "Content-Transfer-Encoding: 7bit\n\n" .
             $message . "\n\n";

  // Base64 encode the file data
  $data = chunk_split(base64_encode($data));

  // Add file attachment to the message
  $message .= "--{$mime_boundary}\n" .
              "Content-Type: {$fileatt_type};\n" .
              " name=\"{$fileatt_name}\"\n" .
              //"Content-Disposition: attachment;\n" .
              //" filename=\"{$fileatt_name}\"\n" .
              "Content-Transfer-Encoding: base64\n\n" .
              $data . "\n\n" .
              "--{$mime_boundary}--\n";
}

// Send the message
$ok = @mail($to, "Contact", $message, $headers);
if (!$ok) header("location:https://www.omidsoft.com");

// -- Send Another Message to SENDER
$message = '
<html>
<head>
<title></title>
<style>
a:hover { color: red }
</style>
</head>
<body link="#0000FF" vlink="#0000FF" alink="#0000FF">
<p><font face="Verdana" size="2">Dear Valued Customer,<br>
Your email received<br>
Thank you.</font></p>
<hr>
</body>
</html>
';

$to = $HTTP_POST_VARS['Email'];
$subject = "Received";

$headers  = "MIME-Version: 1.0\r\n";
$headers .= "Content-type: text/html; charset=UTF-8\r\n";
$headers .= "To: ". $to ."\r\n";
$headers .= "From: support@omidsoft.com <support@omidsoft.com>\r\n";

@mail($to, $subject, $message, $headers);

// -- Goto Another Page
header("location:https://www.omidsoft.com");
?>