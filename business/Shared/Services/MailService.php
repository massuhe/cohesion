<?php

namespace Business\Shared\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\NotificationMail;
use Business\Shared\Exceptions\EmailTemplateNotFound;

class MailService {

    public function sendMail($idMail, $to, $parameters)
    {
        $template = DB::table('templates_mail')->find($idMail);
        if (!$template) {
            throw new EmailTemplateNotFound($idMail);
        }
        $mailContentFormatted = str_replace("\r", '',str_replace("\n", '<br/>', $template->contenido));
        forEach($parameters as $key => $value) {
            $mailContentFormatted = str_replace("#$key#", $value, $mailContentFormatted);
        }
        $title = $template->titulo;
        Mail::to($to)->queue(new NotificationMail($title, $mailContentFormatted));
    }

}