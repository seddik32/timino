<?php

/** 
 * Timino - PHP MVC framework
 *
 * @package     Timino
 * @author      Lotfio Lakehal <contact@lotfio-lakehal.com>
 * @copyright   2017 Lotfio Lakehal
 * @license     MIT
 * @link        https://github.com/lotfio-lakehal/timino
 * 
 * Copyright (C) 2018
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * INFO :
 * Mailer service class
 * 
 */
namespace Timino\App\Services\Custom;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Timino\App\Core\Linker;

class Mailer
{
    /**
     * send simple mail method
     *
     * @param array $data
     * exemple:
     * 
     *    "to"           => "contact@lotfio-lakehal.com",
     *    "subject"      => "test message from lotfio",
     *    "title"        => "message title",
     *    "header"       => "lorem header",
     *    "msg"          => "lorem lorem lorem lorem ",
     *    "footer"       => "23 13213213132123",
     *    "greetings"    => "23 13213213132123",
     *    "infoLink"     => "qlmsdkqmsldkqlmsd",
     *    "company"      => "aza1zsa2z1a2z1"
     * 
     * @return bool
     */
    public function sendSimpleEmail($data)
    {



        $mail = new PHPMailer(true);

        $mail->IsSMTP();
        $mail->Host = Linker::mail("HOST");

        $mail->SMTPAuth = true;
        $mail->Username = Linker::mail("USER");
        $mail->Password = Linker::mail("PASS");

        $mail->From     = Linker::mail("FROM");
        $mail->FromName = Linker::mail("FROM_NAME");
        $mail->Sender   = Linker::mail("FROM");

        //$mail->AddReplyTo(Linker::mail("REPLAY_TO"));
        $mail->AddAddress($data["to"]);

        $mail->Subject = $data["subject"];
        $mail->IsHTML(true);

        $template = file_get_contents(Linker::route("EMAIL") . "normal.html");

        $template = str_replace("#title#", $data["title"], $template);
        $template = str_replace("#header#", $data["header"], $template);
        $template = str_replace("#msg#", $data["msg"], $template);
        $template = str_replace("#footer#", $data["footer"], $template);
        $template = str_replace("#greetings#", $data["greetings"], $template);
        $template = str_replace("#infoLink#", $data["infoLink"], $template);
        $template = str_replace("#company#", $data["company"], $template);

        $mail->Body = $template;

        return (!$mail->Send()) ? 0 : 1 ;

    }

}