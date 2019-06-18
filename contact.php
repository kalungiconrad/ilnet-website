<?php
//if there is post
if(isset($_POST) && !empty($_POST)){
    //if there is an attachment
     if(!empty($_FILES['file']['name'])){
         //store some variables
         $file_name = $_FILES['attachment']['name'];
         $temp_name = $_FILES['attachment']['tmp_name'];
         $file_type = $_FILES['attachment']['type'];

         //get extension of the file
         $base = basename(file_name);
         $extension = substr($base, strlen($base)-4, strlen($base));

         //only these file types will be allowed
         $allowed_extensions= array(".doc", "docx",".pdf", ".zip",".png);
     
         // check that this file is allowed
         if(in_array($extension, $allowed_extensiions)) {

            //mail essentials
            $from = $_POST['email'];
            $to = "kalungi.conrad@gmail.com";
            $firstname =$_POST['firstname'];
            $lastname =$_POST['lastname'];
            $subject = ' ILNET training programme';
            $message = "Name: $firstname $lastname. \n".
                        "Email: $email.\n".
                        "Message: Hello: \n I need to engage in the training and the and the 
                        attached  are my accademic documents. \n  Thank you. $file.\n";
                    
            //things u need
            $file = $temp_name;
            $content = chunk_split(base64_encode(file_get_contents($file)));
            $uid = md5(uniqid(time()));

            //standard mail headers
            $header = "From: ".$from."\r\n";
            $header .= "Reply-To: ".$replyto."\r\n";
            $header .= "MIME-Version: 1.0\r\n";

            //declare we have multiple kinds of email (i.e plaintext and attachment)
            $header .= "Content-Type: multipart/mixed; boudary=\"".$uid. "\"\r\n\r\n";
            $header .= "This is a  multi-part message in MIME format.\r\n";

            //plain text part
            $header .= "--" .$uid. "\r\n";
            $header .= "Content-type:text/plain; charset=iso859-1\r\n";
            $header .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
            $header .= $message."\r\n\r\n";

            // file attachment
            $header .= "__".$uid. "\r\n";
            $header .= "Content-Transfer-Encoding: base64\r\n";
            $header .= "Content-Diposition: attachment; filename =\"".$file_name."\"\r\n\r\n";
            $header .= $content."\r\n\r\n";

            // send the mail (message is not here because its in the heaer in a multipart header)
            if (mail($to, $subject, "", $header)) {
                echo "Thank you, \n form sent successfully";
                header("location: index.html" )
            } else {
                echo "send failed, sorry!"
            }


         } else {
             echo "file type not alllowed";
         }

     } else{
        echo "no file posted";
     }


}








?> 
