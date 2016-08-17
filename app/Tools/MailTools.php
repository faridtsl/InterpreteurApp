<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 8/2/16
 * Time: 1:06 PM
 */

namespace App\Tools;
use Barryvdh\DomPDF\Facade as PDF;

use Illuminate\Support\Facades\Mail;
use Waavi\Mailman\Facades\Mailman;

class MailTools{

    public static function sendMail($subject, $filename, $from, $to, $attachments, $params, $css){
        /*$mail = Mailman::make('emails.'.$filename,$params);
        $mail = $mail->from($from);
        $mail = $mail->to($to);
        $mail = $mail->subject($subject);
        $mail = $mail->setCss($css);
        foreach ($attachments as $attach) {
            $mail = $mail->attach($attach);
        }
        $mail->send();*/
    }

    public static function downloadAttach($filename,$params){
        $pdf = PDF::loadView('emails.'.$filename, $params);
        return $pdf->download($filename.'.pdf');
    }

}