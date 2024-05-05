<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Email_model extends CI_Model{
	
	public function sendemail($email,$subject,$body)
	{
       $data = sitedata(); 
		   $this->load->library('phpmailer_lib');
       $emailconfig = $this->db->select('*')->from('settings_smtp')->get()->result_array();
       if(!empty($emailconfig)) {
           $mail = $this->phpmailer_lib->load();
           $mail->isSMTP();
           $mail->Host = $emailconfig[0]['smtp_host'];
           $mail->SMTPAuth = $emailconfig[0]['smtp_auth'];
           $mail->Username = $emailconfig[0]['smtp_uname'];
           $mail->Password = $emailconfig[0]['smtp_pwd'];
           $mail->SMTPSecure = $emailconfig[0]['smtp_issecure'];
           $mail->Port = $emailconfig[0]['smtp_port'];
           $mail->setFrom($emailconfig[0]['smtp_emailfrom']);
           $mail->addReplyTo($emailconfig[0]['smtp_replyto']);
           $mail->addAddress($email); //email address of recipient
           $mail->Subject = $subject;
           $mail->isHTML(true);
           $mail->Body = '
            
            <!doctype html>
            <html>
              <head>
                <meta name="viewport" content="width=device-width" />
                <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
                <title>Email</title>
                <style>body{background-color:#f6f6f6;font-family:sans-serif;-webkit-font-smoothing:antialiased;font-size:14px;line-height:1.4;margin:0;padding:0;-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%}table{border-collapse:separate;mso-table-lspace:0;mso-table-rspace:0;width:100%}table td{font-family:sans-serif;font-size:14px;vertical-align:top}.body{background-color:#f6f6f6;width:100%}.container{display:block;Margin:0 auto!important;max-width:580px;padding:10px;width:580px}.content{box-sizing:border-box;display:block;Margin:0 auto;max-width:580px;padding:10px}.main{background:#fff;border-radius:3px;width:100%}.wrapper{box-sizing:border-box;padding:20px}.content-block{padding-bottom:10px;padding-top:10px}.footer{clear:both;Margin-top:10px;text-align:center;width:100%}.footer a,.footer p,.footer span,.footer td{color:#999;font-size:12px;text-align:center}h1,h2,h3,h4{color:#000;font-family:sans-serif;font-weight:400;line-height:1.4;margin:0;Margin-bottom:30px}h1{font-size:35px;font-weight:300;text-align:center;text-transform:capitalize}ol,p,ul{font-family:sans-serif;font-size:14px;font-weight:400;margin:0;Margin-bottom:15px}ol li,p li,ul li{list-style-position:inside;margin-left:5px}a{color:#3498db;text-decoration:underline}.btn{box-sizing:border-box;width:100%}.btn>tbody>tr>td{padding-bottom:15px}.btn table{width:auto}.btn table td{background-color:#fff;border-radius:5px;text-align:center}.btn a{background-color:#fff;border:solid 1px #3498db;border-radius:5px;box-sizing:border-box;color:#3498db;cursor:pointer;display:inline-block;font-size:14px;font-weight:700;margin:0;padding:12px 25px;text-decoration:none;text-transform:capitalize}.btn-primary table td{background-color:#3498db}.btn-primary a{background-color:#3498db;border-color:#3498db;color:#fff}.last{margin-bottom:0}.first{margin-top:0}.align-center{text-align:center}.align-right{text-align:right}.align-left{text-align:left}.clear{clear:both}.mt0{margin-top:0}.mb0{margin-bottom:0}.preheader{color:transparent;display:none;height:0;max-height:0;max-width:0;opacity:0;overflow:hidden;mso-hide:all;visibility:hidden;width:0}.powered-by a{text-decoration:none}hr{border:0;border-bottom:1px solid #f6f6f6;Margin:20px 0}@media only screen and (max-width:620px){table[class=body] h1{font-size:28px!important;margin-bottom:10px!important}table[class=body] a,table[class=body] ol,table[class=body] p,table[class=body] span,table[class=body] td,table[class=body] ul{font-size:16px!important}table[class=body] .article,table[class=body] .wrapper{padding:10px!important}table[class=body] .content{padding:0!important}table[class=body] .container{padding:0!important;width:100%!important}table[class=body] .main{border-left-width:0!important;border-radius:0!important;border-right-width:0!important}table[class=body] .btn table{width:100%!important}table[class=body] .btn a{width:100%!important}table[class=body] .img-responsive{height:auto!important;max-width:100%!important;width:auto!important}}@media all{.ExternalClass{width:100%}.ExternalClass,.ExternalClass div,.ExternalClass font,.ExternalClass p,.ExternalClass span,.ExternalClass td{line-height:100%}.apple-link a{color:inherit!important;font-family:inherit!important;font-size:inherit!important;font-weight:inherit!important;line-height:inherit!important;text-decoration:none!important}.btn-primary table td:hover{background-color:#34495e!important}.btn-primary a:hover{background-color:#34495e!important;border-color:#34495e!important}}</style>
              </head>
              <body class="">
                <table border="0" cellpadding="0" cellspacing="0" class="body">
                  <tr>
                    <td>&nbsp;</td>
                    <td class="container">
                      <div class="content">

                        <!-- START CENTERED WHITE CONTAINER -->
                        <span class="preheader"></span>
                          <div style="width: 170px;padding-left: 19px;"></div> 
                        <table class="main">

                          <!-- START MAIN CONTENT AREA -->
                          <tr>
                            <td class="wrapper">
                              <table border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                  <td>
                                  '.$body.'
                                  </td>
                                </tr>
                              </table>
                            </td>
                          </tr>
                        </table>
                        <div class="footer">
                          <table border="0" cellpadding="0" cellspacing="0">
                            <tr>
                              <td class="content-block">
                                <span class="apple-link">'.$data['s_companyname'].'</span>
                              </td>
                            </tr>
                          </table>
                        </div>
                      </div>
                    </td>
                    <td>&nbsp;</td>
                  </tr>
                </table>
              </body>
            </html>';
           if($mail->send())
              return 'true';
           else
              return $mail->ErrorInfo;
        } else {
              return 'Please add smtp configurations';
        }
	}
} 