<?php

namespace App\Services;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class MailService
{

    protected $mail;

    public function __construct()
    {
        $this->mail = new PHPMailer(true);
        $this->mail->isSMTP();
        $this->mail->Host       = 'smtp.gmail.com';
        $this->mail->SMTPAuth   = true;
        $this->mail->Username   = 'gaurimobiles.9@gmail.com';
        $this->mail->Password   = 'qdyu qysp ltfk mkxv';   // NOT Gmail password
        $this->mail->SMTPSecure = 'tls';
        $this->mail->Port       = 587;
        $this->mail->setFrom('gaurimobiles.9@gmail.com', 'Gauri Mobiles');
    }

    public function sendInvoice($toEmail, $subject, $body, $pdfBinary, $invoiceNumber)
    {
        try {
            $this->mail->addAddress($toEmail);

            $this->mail->Subject = $subject;
            $this->mail->Body    = $body;

            // Attach PDF
            $this->mail->addStringAttachment($pdfBinary, "Invoice-$invoiceNumber.pdf");

            return $this->mail->send();
        } catch (Exception $e) {
            dd($e->getMessage());
            return false;
        }
    }

    public function sendBackup($toEmail, $subject, $body, $sqlData, $backupName)
    {
        try {
            $this->mail->clearAddresses();
            $this->mail->clearAttachments();

            $this->mail->addAddress($toEmail);
            $this->mail->Subject = $subject;
            $this->mail->Body    = $body;

            // THIS IS THE KEY LINE
            $this->mail->addStringAttachment(
                $sqlData,
                $backupName . '.sql',
                'base64',
                'application/octet-stream'
            );

            return $this->mail->send();
        } catch (Exception $e) {
            dd($e->getMessage());
            return false;
        }
    }
}
