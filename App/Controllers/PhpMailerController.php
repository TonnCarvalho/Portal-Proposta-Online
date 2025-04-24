<?php

namespace App\Controllers;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

class PhpMailerController
{
  private $mail;

  public function __construct()
  {
    $this->mail = new PHPMailer(true);
    $this->mail->CharSet = 'UTF-8';
    $this->mail->isSMTP();
    $this->mail->SMTPDebug  = SMTP::DEBUG_OFF;
    $this->mail->Host = 'smtp.hostinger.com';
    $this->mail->SMTPAuth = true;
    $this->mail->Username = 'envios@email.com.br';
    $this->mail->Password = 'SuaSenha123';
    $this->mail->SMTPSecure = 'ssl';
    $this->mail->Port = 465;
  }
  //TODO enviar email para o corretor e associado informando nossos beneficios
  public function emailPropostaCriada($para, $nome_para, $assunto, $nome_associado, $uri_proposta)
  {
    try {
      // Configurações do remetente e destinatário
      $this->mail->setFrom('envios@email.com.br', 'Minha Empresa - Não responda.'); //Quem envia o email 
      $this->mail->addAddress($para, $nome_para); //Quem recebe o email

      // Configurações do e-mail
      $this->mail->isHTML(true); // Define o formato do e-mail como texto simples
      $this->mail->Subject = $assunto;
      $this->mail->Body = "
              <!-- Change values in the template and pass { {variables} } with API call -->
          <!-- Feel free to adjust it to your needs and delete all these comments-->
          <!-- Also adapt TXT version of this email -->
          <!DOCTYPE html>
          <html xmlns='http://www.w3.org/1999/xhtml'>
          
          <head>
            <title></title>
            <!--[if !mso]><!-- -->
            <meta http-equiv='X-UA-Compatible' content='IE=edge'>
            <!--<![endif]-->
            <meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <style type='text/css'>
              #outlook a {
                padding: 0;
              }
          
              .ReadMsgBody {
                width: 100%;
              }
          
              .ExternalClass {
                width: 100%;
              }
          
              .ExternalClass * {
                line-height: 100%;
              }
          
              body {
                margin: 0;
                padding: 0;
                -webkit-text-size-adjust: 100%;
                -ms-text-size-adjust: 100%;
              }
          
              table,
              td {
                border-collapse: collapse;
                mso-table-lspace: 0pt;
                mso-table-rspace: 0pt;
              }
          
            </style>
            <!--[if !mso]><!-->
            <style type='text/css'>
              @media only screen and (max-width:480px) {
                @-ms-viewport {
                  width: 320px;
                }
                @viewport {
                  width: 320px;
                }
              }
            </style>
            <!--<![endif]-->
            <!--[if mso]><xml>  <o:OfficeDocumentSettings>    <o:AllowPNG/>    <o:PixelsPerInch>96</o:PixelsPerInch>  </o:OfficeDocumentSettings></xml><![endif]-->
            <!--[if lte mso 11]><style type='text/css'>  .outlook-group-fix {    width:100% !important;  }</style><![endif]-->
            <!--[if !mso]><!-->
            <link href='https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&display=swap' rel='stylesheet' type='text/css'>
            <style type='text/css'>
              @import url('https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&display=swap');
            </style>
            <!--<![endif]-->
            <style type='text/css'>
              @media only screen and (max-width:595px) {
                .container {
                  width: 100% !important;
                }
                .button {
                  display: block !important;
                  width: auto !important;
                }
              }
            </style>
          </head>
          
          <body style='font-family: 'Inter', sans-serif; background: #E5E5E5;'>
            <table width='100%' cellspacing='0' cellpadding='0' border='0' align='center' bgcolor='#F6FAFB'>
              <tbody>
                <tr>
                  <td valign='top' align='center'>
                    <table class='container' width='600' cellspacing='0' cellpadding='0' border='0'>
                      <tbody>
                        <tr>
                          <td style='padding:48px 0 30px 0; text-align: center; font-size: 14px; color: #4C83EE;'>
                            <img src='https://mailsend-email-assets.mailtrap.io/xprwcczi7emizxjvdu4y9yxxoclm.png'/>
                          </td>
                        </tr>
                        <tr>
                          <td class='main-content' style='padding: 48px 30px 40px; color: #000000;' bgcolor='#ffffff'>
                            <table width='100%' cellspacing='0' cellpadding='0' border='0'>
                              <tbody>
                                <tr>
                                  <td style='padding: 0 0 24px 0; font-size: 20px; line-height: 150%; font-weight: bold; color: #000000; letter-spacing: 0.01em;'>
                                    Olá, nova proposta cadastrada!
                                  </td>
                                </tr>
                                <tr>
                                  <td style='padding: 0 0 10px 0; font-size: 18px; line-height: 150%; font-weight: 400; color: #000000; letter-spacing: 0.01em;'>
                                    Novo associado (a) cadastrado $nome_associado.
                                  </td>
                                </tr>
                                <tr>
                                  <td style='padding: 0 0 16px 0; font-size: 18px; line-height: 150%; font-weight: 400; color: #000000; letter-spacing: 0.01em;'>
                                    Para acessar click no botão abaixo.
                                  </td>
                                </tr>
                                <tr>
                                  <td style='padding: 0 0 24px 0;'>
                                    <a class='button' href='$uri_proposta' title='Acessar proposta' style='width: 100%; background: #4C83EE; text-decoration: none; display: inline-block; padding: 10px 0; color: #fff; font-size: 14px; line-height: 21px; text-align: center; font-weight: bold; border-radius: 7px;'>Acessa a proposta</a>
                                  </td>
                                </tr>
                                </tr>
                                <tr>
                                  <td style='font-size: 14px; line-height: 170%; font-weight: 400; color: #000000; letter-spacing: 0.01em;'>
                                    Por favor, não responda este e-mail.
                                  </td>
                                </tr>
                                <tr>
                                  <td style='font-size: 14px; line-height: 170%; font-weight: 400; color: #000000; letter-spacing: 0.01em;'>
                                    Atenciosamente, <br><strong>Minha Empresa</strong>
                                  </td>
                                </tr>
                              </tbody>
                            </table>
                          </td>
                        </tr>
                        <tr>
                          <td style='padding: 24px 0 48px; font-size: 0px;'>
                            <!--[if mso | IE]>      <table role='presentation' border='0' cellpadding='0' cellspacing='0'>        <tr>          <td style='vertical-align:top;width:300px;'>      <![endif]-->
                            <div class='outlook-group-fix' style='padding: 0 0 20px 0; vertical-align: top; display: inline-block; text-align: center; width:100%;'>
                              <span style='padding: 0; font-size: 11px; line-height: 15px; font-weight: normal; color: #8B949F;'>Minha Empresa<br/>www.minhaempresa.com.br.com.br</span>
                            </div>
                            <!--[if mso | IE]>      </td></tr></table>      <![endif]-->
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </td>
                </tr>
              </tbody>
            </table>
          </body>
          </html>";

      // Enviar e-mail
      $this->mail->send();
      echo 'E-mail enviado com sucesso!';
    } catch (Exception $e) {
      echo 'Erro ao enviar'; // e-mail: { $this->mail->ErrorInfo}';
    }
  }

  public function emailPendenciaCriada($para, $nome_para, $assunto, $nome_corretor, $nome_associado, $num_proposta, $uri_proposta)
  {
    try {
      // Configurações do remetente e destinatário
      $this->mail->setFrom('envios@email.com.br', 'Minha Empresa - Não responda.'); //Quem envia o email 
      $this->mail->addAddress($para, $nome_para); //Quem recebe o email

      // Configurações do e-mail
      $this->mail->isHTML(true); // Define o formato do e-mail como texto simples
      $this->mail->Subject = $assunto;
      $this->mail->Body = "
            <!-- Change values in the template and pass { {variables} } with API call -->
        <!-- Feel free to adjust it to your needs and delete all these comments-->
        <!-- Also adapt TXT version of this email -->
        <!DOCTYPE html>
        <html xmlns='http://www.w3.org/1999/xhtml'>
        
        <head>
          <title></title>
          <!--[if !mso]><!-- -->
          <meta http-equiv='X-UA-Compatible' content='IE=edge'>
          <!--<![endif]-->
          <meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>
          <meta name='viewport' content='width=device-width, initial-scale=1.0'>
          <style type='text/css'>
            #outlook a {
              padding: 0;
            }
        
            .ReadMsgBody {
              width: 100%;
            }
        
            .ExternalClass {
              width: 100%;
            }
        
            .ExternalClass * {
              line-height: 100%;
            }
        
            body {
              margin: 0;
              padding: 0;
              -webkit-text-size-adjust: 100%;
              -ms-text-size-adjust: 100%;
            }
        
            table,
            td {
              border-collapse: collapse;
              mso-table-lspace: 0pt;
              mso-table-rspace: 0pt;
            }
        
          </style>
          <!--[if !mso]><!-->
          <style type='text/css'>
            @media only screen and (max-width:480px) {
              @-ms-viewport {
                width: 320px;
              }
              @viewport {
                width: 320px;
              }
            }
          </style>
          <!--<![endif]-->
          <!--[if mso]><xml>  <o:OfficeDocumentSettings>    <o:AllowPNG/>    <o:PixelsPerInch>96</o:PixelsPerInch>  </o:OfficeDocumentSettings></xml><![endif]-->
          <!--[if lte mso 11]><style type='text/css'>  .outlook-group-fix {    width:100% !important;  }</style><![endif]-->
          <!--[if !mso]><!-->
          <link href='https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&display=swap' rel='stylesheet' type='text/css'>
          <style type='text/css'>
            @import url('https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&display=swap');
          </style>
          <!--<![endif]-->
          <style type='text/css'>
            @media only screen and (max-width:595px) {
              .container {
                width: 100% !important;
              }
              .button {
                display: block !important;
                width: auto !important;
              }
            }
          </style>
        </head>
        
        <body style='font-family: 'Inter', sans-serif; background: #E5E5E5;'>
          <table width='100%' cellspacing='0' cellpadding='0' border='0' align='center' bgcolor='#F6FAFB'>
            <tbody>
              <tr>
                <td valign='top' align='center'>
                  <table class='container' width='600' cellspacing='0' cellpadding='0' border='0'>
                    <tbody>
                      <tr>
                        <td style='padding:48px 0 30px 0; text-align: center; font-size: 14px; color: #4C83EE;'>
                            <img src='https://mailsend-email-assets.mailtrap.io/xprwcczi7emizxjvdu4y9yxxoclm.png'/>
                        </td>
                      </tr>
                      <tr>
                        <td class='main-content' style='padding: 48px 30px 40px; color: #000000;' bgcolor='#ffffff'>
                          <table width='100%' cellspacing='0' cellpadding='0' border='0'>
                            <tbody>
                              <tr>
                                <td style='padding: 0 0 24px 0; font-size: 20px; line-height: 150%; font-weight: bold; color: #000000; letter-spacing: 0.01em;'>
                                  Olá, $nome_corretor!
                                </td>
                              </tr>
                              <tr>
                                <td style='padding: 0 0 10px 0; font-size: 18px; line-height: 150%; font-weight: 400; color: #000000; letter-spacing: 0.01em;'>
                                  Exite uma pendencia na proposta de $nome_associado, número da proposta: $num_proposta.
                                </td>
                              </tr>
                              <tr>
                                <td style='padding: 0 0 16px 0; font-size: 18px; line-height: 150%; font-weight: 400; color: #000000; letter-spacing: 0.01em;'>
                                  Para acessar click no botão abaixo.
                                </td>
                              </tr>
                              <tr>
                                <td style='padding: 0 0 24px 0;'>
                                  <a class='button' href='$uri_proposta' title='Acessar proposta' style='width: 100%; background: #4C83EE; text-decoration: none; display: inline-block; padding: 10px 0; color: #fff; font-size: 14px; line-height: 21px; text-align: center; font-weight: bold; border-radius: 7px;'>Acessa a proposta</a>
                                </td>
                              </tr>
                              </tr>
                              <tr>
                                <td style='font-size: 14px; line-height: 170%; font-weight: 400; color: #000000; letter-spacing: 0.01em;'>
                                  Por favor, não responda este e-mail.
                                </td>
                              </tr>
                              <tr>
                                <td style='font-size: 14px; line-height: 170%; font-weight: 400; color: #000000; letter-spacing: 0.01em;'>
                                  Atenciosamente, <br><strong>Minha Empresa</strong>
                                </td>
                              </tr>
                            </tbody>
                          </table>
                        </td>
                      </tr>
                      <tr>
                        <td style='padding: 24px 0 48px; font-size: 0px;'>
                          <!--[if mso | IE]>      <table role='presentation' border='0' cellpadding='0' cellspacing='0'>        <tr>          <td style='vertical-align:top;width:300px;'>      <![endif]-->
                          <div class='outlook-group-fix' style='padding: 0 0 20px 0; vertical-align: top; display: inline-block; text-align: center; width:100%;'>
                            <span style='padding: 0; font-size: 11px; line-height: 15px; font-weight: normal; color: #8B949F;'>Minha Empresa<br/>www.minhaempresa.com.br.com.br</span>
                          </div>
                          <!--[if mso | IE]>      </td></tr></table>      <![endif]-->
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </td>
              </tr>
            </tbody>
          </table>
        </body>
        </html>";

      // Enviar e-mail
      $this->mail->send();
      echo 'E-mail enviado com sucesso!';
    } catch (Exception $e) {
      echo 'Erro ao enviar e-mail:' . $this->mail->ErrorInfo;
    }
  }

  public function emailConsultaRespondida($para, $nome_para, $assunto, $nome_corretor, $uri_proposta, $codigoConsulta)
  {
    try {
      // Configurações do remetente e destinatário
      $this->mail->setFrom('envios@email.com.br', 'Minha Empresa - Não responda.'); //Quem envia o email 
      $this->mail->addAddress($para, $nome_para); //Quem recebe o email

      // Configurações do e-mail
      $this->mail->isHTML(true); // Define o formato do e-mail como texto simples
      $this->mail->Subject = $assunto;
      $this->mail->Body = "
              <!-- Change values in the template and pass { {variables} } with API call -->
          <!-- Feel free to adjust it to your needs and delete all these comments-->
          <!-- Also adapt TXT version of this email -->
          <!DOCTYPE html>
          <html xmlns='http://www.w3.org/1999/xhtml'>
          
          <head>
            <title></title>
            <!--[if !mso]><!-- -->
            <meta http-equiv='X-UA-Compatible' content='IE=edge'>
            <!--<![endif]-->
            <meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <style type='text/css'>
              #outlook a {
                padding: 0;
              }
          
              .ReadMsgBody {
                width: 100%;
              }
          
              .ExternalClass {
                width: 100%;
              }
          
              .ExternalClass * {
                line-height: 100%;
              }
          
              body {
                margin: 0;
                padding: 0;
                -webkit-text-size-adjust: 100%;
                -ms-text-size-adjust: 100%;
              }
          
              table,
              td {
                border-collapse: collapse;
                mso-table-lspace: 0pt;
                mso-table-rspace: 0pt;
              }
          
            </style>
            <!--[if !mso]><!-->
            <style type='text/css'>
              @media only screen and (max-width:480px) {
                @-ms-viewport {
                  width: 320px;
                }
                @viewport {
                  width: 320px;
                }
              }
            </style>
            <!--<![endif]-->
            <!--[if mso]><xml>  <o:OfficeDocumentSettings>    <o:AllowPNG/>    <o:PixelsPerInch>96</o:PixelsPerInch>  </o:OfficeDocumentSettings></xml><![endif]-->
            <!--[if lte mso 11]><style type='text/css'>  .outlook-group-fix {    width:100% !important;  }</style><![endif]-->
            <!--[if !mso]><!-->
            <link href='https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&display=swap' rel='stylesheet' type='text/css'>
            <style type='text/css'>
              @import url('https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&display=swap');
            </style>
            <!--<![endif]-->
            <style type='text/css'>
              @media only screen and (max-width:595px) {
                .container {
                  width: 100% !important;
                }
                .button {
                  display: block !important;
                  width: auto !important;
                }
              }
            </style>
          </head>
          
          <body style='font-family: 'Inter', sans-serif; background: #E5E5E5;'>
            <table width='100%' cellspacing='0' cellpadding='0' border='0' align='center' bgcolor='#F6FAFB'>
              <tbody>
                <tr>
                  <td valign='top' align='center'>
                    <table class='container' width='600' cellspacing='0' cellpadding='0' border='0'>
                      <tbody>
                        <tr>
                          <td style='padding:48px 0 30px 0; text-align: center; font-size: 14px; color: #4C83EE;'>
                              <img src='https://mailsend-email-assets.mailtrap.io/xprwcczi7emizxjvdu4y9yxxoclm.png'/>
                          </td>
                        </tr>
                        <tr>
                          <td class='main-content' style='padding: 48px 30px 40px; color: #000000;' bgcolor='#ffffff'>
                            <table width='100%' cellspacing='0' cellpadding='0' border='0'>
                              <tbody>
                                <tr>
                                  <td style='padding: 0 0 24px 0; font-size: 20px; line-height: 150%; font-weight: bold; color: #000000; letter-spacing: 0.01em;'>
                                    Olá, $nome_corretor!
                                  </td>
                                </tr>
                                <tr>
                                  <td style='padding: 0 0 10px 0; font-size: 18px; line-height: 150%; font-weight: 400; color: #000000; letter-spacing: 0.01em;'>
                                    Sua consulta de código: $codigoConsulta, foi respondida 
                                  </td>
                                </tr>
                                <tr>
                                  <td style='padding: 0 0 16px 0; font-size: 18px; line-height: 150%; font-weight: 400; color: #000000; letter-spacing: 0.01em;'>
                                    Para acessar click no botão abaixo.
                                  </td>
                                </tr>
                                <tr>
                                  <td style='padding: 0 0 24px 0;'>
                                    <a class='button' href='$uri_proposta' title='Acessar proposta' style='width: 100%; background: #4C83EE; text-decoration: none; display: inline-block; padding: 10px 0; color: #fff; font-size: 14px; line-height: 21px; text-align: center; font-weight: bold; border-radius: 7px;'>Acessa a proposta</a>
                                  </td>
                                </tr>
                                </tr>
                                <tr>
                                  <td style='font-size: 14px; line-height: 170%; font-weight: 400; color: #000000; letter-spacing: 0.01em;'>
                                    Por favor, não responda este e-mail.
                                  </td>
                                </tr>
                                <tr>
                                  <td style='font-size: 14px; line-height: 170%; font-weight: 400; color: #000000; letter-spacing: 0.01em;'>
                                    Atenciosamente, <br><strong>Minha Empresa</strong>
                                  </td>
                                </tr>
                              </tbody>
                            </table>
                          </td>
                        </tr>
                        <tr>
                          <td style='padding: 24px 0 48px; font-size: 0px;'>
                            <!--[if mso | IE]>      <table role='presentation' border='0' cellpadding='0' cellspacing='0'>        <tr>          <td style='vertical-align:top;width:300px;'>      <![endif]-->
                            <div class='outlook-group-fix' style='padding: 0 0 20px 0; vertical-align: top; display: inline-block; text-align: center; width:100%;'>
                              <span style='padding: 0; font-size: 11px; line-height: 15px; font-weight: normal; color: #8B949F;'>Minha Empresa<br/>www.minhaempresa.com.br.com.br</span>
                            </div>
                            <!--[if mso | IE]>      </td></tr></table>      <![endif]-->
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </td>
                </tr>
              </tbody>
            </table>
          </body>
          </html>";

      // Enviar e-mail
      $this->mail->send();
      echo 'E-mail enviado com sucesso!';
    } catch (Exception $e) {
      echo 'Erro ao enviar'; // e-mail: { $this->mail->ErrorInfo}';
    }
  }

  public function emailRecuperarSenha($para, $assunto, $uri_proposta)
  {
    try {
      // Configurações do remetente e destinatário
      $this->mail->setFrom('envios@email.com.br', 'Minha Empresa - Não responda.'); //Quem envia o email 
      $this->mail->addAddress($para); //Quem recebe o email

      // Configurações do e-mail
      $this->mail->isHTML(true); // Define o formato do e-mail como texto simples
      $this->mail->Subject = $assunto;
      $this->mail->Body = "
              <!-- Change values in the template and pass { {variables} } with API call -->
          <!-- Feel free to adjust it to your needs and delete all these comments-->
          <!-- Also adapt TXT version of this email -->
          <!DOCTYPE html>
          <html xmlns='http://www.w3.org/1999/xhtml'>
          
          <head>
            <title></title>
            <!--[if !mso]><!-- -->
            <meta http-equiv='X-UA-Compatible' content='IE=edge'>
            <!--<![endif]-->
            <meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <style type='text/css'>
              #outlook a {
                padding: 0;
              }
          
              .ReadMsgBody {
                width: 100%;
              }
          
              .ExternalClass {
                width: 100%;
              }
          
              .ExternalClass * {
                line-height: 100%;
              }
          
              body {
                margin: 0;
                padding: 0;
                -webkit-text-size-adjust: 100%;
                -ms-text-size-adjust: 100%;
              }
          
              table,
              td {
                border-collapse: collapse;
                mso-table-lspace: 0pt;
                mso-table-rspace: 0pt;
              }
          
            </style>
            <!--[if !mso]><!-->
            <style type='text/css'>
              @media only screen and (max-width:480px) {
                @-ms-viewport {
                  width: 320px;
                }
                @viewport {
                  width: 320px;
                }
              }
            </style>
            <!--<![endif]-->
            <!--[if mso]><xml>  <o:OfficeDocumentSettings>    <o:AllowPNG/>    <o:PixelsPerInch>96</o:PixelsPerInch>  </o:OfficeDocumentSettings></xml><![endif]-->
            <!--[if lte mso 11]><style type='text/css'>  .outlook-group-fix {    width:100% !important;  }</style><![endif]-->
            <!--[if !mso]><!-->
            <link href='https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&display=swap' rel='stylesheet' type='text/css'>
            <style type='text/css'>
              @import url('https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&display=swap');
            </style>
            <!--<![endif]-->
            <style type='text/css'>
              @media only screen and (max-width:595px) {
                .container {
                  width: 100% !important;
                }
                .button {
                  display: block !important;
                  width: auto !important;
                }
              }
            </style>
          </head>
          
          <body style='font-family: 'Inter', sans-serif; background: #E5E5E5;'>
            <table width='100%' cellspacing='0' cellpadding='0' border='0' align='center' bgcolor='#F6FAFB'>
              <tbody>
                <tr>
                  <td valign='top' align='center'>
                    <table class='container' width='600' cellspacing='0' cellpadding='0' border='0'>
                      <tbody>
                        <tr>
                          <td style='padding:48px 0 30px 0; text-align: center; font-size: 14px; color: #4C83EE;'>
                              <img src='https://mailsend-email-assets.mailtrap.io/xprwcczi7emizxjvdu4y9yxxoclm.png'/>
                          </td>
                        </tr>
                        <tr>
                          <td class='main-content' style='padding: 48px 30px 40px; color: #000000;' bgcolor='#ffffff'>
                            <table width='100%' cellspacing='0' cellpadding='0' border='0'>
                              <tbody>
                                <tr>
                                  <td style='padding: 0 0 24px 0; font-size: 20px; line-height: 150%; font-weight: bold; color: #000000; letter-spacing: 0.01em;'>
                                    Olá, tudo bem!
                                  </td>
                                </tr>
                                <tr>
                                  <td style='padding: 0 0 10px 0; font-size: 18px; line-height: 150%; font-weight: 400; color: #000000; letter-spacing: 0.01em;'>
                                    Chegou o link para está mudando a senha. 
                                  </td>
                                </tr>
                                <tr>
                                  <td style='padding: 0 0 16px 0; font-size: 18px; line-height: 150%; font-weight: 400; color: #000000; letter-spacing: 0.01em;'>
                                    Para acessar click no botão abaixo.
                                  </td>
                                </tr>
                                <tr>
                                  <td style='padding: 0 0 24px 0;'>
                                    <a class='button' href='$uri_proposta' title='Acessar proposta' style='width: 100%; background: #4C83EE; text-decoration: none; display: inline-block; padding: 10px 0; color: #fff; font-size: 14px; line-height: 21px; text-align: center; font-weight: bold; border-radius: 7px;'>Acessa a proposta</a>
                                  </td>
                                </tr>
                                </tr>
                                <tr>
                                  <td style='font-size: 14px; line-height: 170%; font-weight: 400; color: #000000; letter-spacing: 0.01em;'>
                                    Por favor, não responda este e-mail.
                                  </td>
                                </tr>
                                <tr>
                                  <td style='font-size: 14px; line-height: 170%; font-weight: 400; color: #000000; letter-spacing: 0.01em;'>
                                    Atenciosamente, <br><strong>Minha Empresa</strong>
                                  </td>
                                </tr>
                              </tbody>
                            </table>
                          </td>
                        </tr>
                        <tr>
                          <td style='padding: 24px 0 48px; font-size: 0px;'>
                            <!--[if mso | IE]>      <table role='presentation' border='0' cellpadding='0' cellspacing='0'>        <tr>          <td style='vertical-align:top;width:300px;'>      <![endif]-->
                            <div class='outlook-group-fix' style='padding: 0 0 20px 0; vertical-align: top; display: inline-block; text-align: center; width:100%;'>
                              <span style='padding: 0; font-size: 11px; line-height: 15px; font-weight: normal; color: #8B949F;'>Minha Empresa<br/>www.minhaempresa.com.br.com.br</span>
                            </div>
                            <!--[if mso | IE]>      </td></tr></table>      <![endif]-->
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </td>
                </tr>
              </tbody>
            </table>
          </body>
          </html>";

      // Enviar e-mail
      $this->mail->send();
      echo 'E-mail enviado com sucesso!';
    } catch (Exception $e) {
      echo 'Erro ao enviar'; // e-mail: { $this->mail->ErrorInfo}';
    }
  }
}
