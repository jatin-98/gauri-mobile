<?php

namespace App\Services;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class MailService
{
    public function sendInvoice($toEmail, $subject, $body, $pdfBinary, $invoiceNumber)
    {
        $mail = new PHPMailer(true);

        try {
            // Gmail Settings
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'captainamerica7987@gmail.com';
            $mail->Password   = 'tbuj rcpn hzxs pflo';   // NOT Gmail password
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 587;

            // Email details
            $mail->setFrom('captainamerica7987@gmail.com', 'Gauri Mobiles');
            $mail->addAddress($toEmail);

            $mail->Subject = $subject;
            $mail->Body    = $body;

            // Attach PDF
            $mail->addStringAttachment($pdfBinary, "Invoice-$invoiceNumber.pdf");

            return $mail->send();
        } catch (Exception $e) {
            dd($e->getMessage());
            return false;
        }
    }
}
