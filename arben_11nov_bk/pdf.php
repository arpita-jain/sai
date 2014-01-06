<?php
        $Jt =  $_REQUEST['Jt'];
        $Jd =  $_REQUEST['Jd'];
        $Jl =  $_REQUEST['Jl'];
        $Fn = $_REQUEST['Fn'];
        $Cn =  $_REQUEST['Cn'];
        $Jty =  $_REQUEST['Jty'];
        $Pd =  $_REQUEST['Pd'];
        $url = 'http://constructionmates.co.uk/wp-content/plugins/job-post/job_image/'.$Fn;
        $content = ' <div class="job-list-area">
                        <h3> '. $Jt.'</h3>
                        <div class="job-list-part job_detail">
                              <div class="job-img-part"><img src="'.$url.'" alt=""></div>
                              <div class="job-list-txt-plc"> <span class="job_label">Location</span> <span class="job_detail_txt">'.$Jl.'</span> <span class="clear">&nbsp;</span> <span class="job_label">Salary:</span> <span class="job_detail_txt">£0 - £00,000 per annum + Package</span> <span class="clear">&nbsp;</span> <span class="job_label">Date posted:</span> <span class="job_detail_txt">'.$Pd.'</span> <span class="clear">&nbsp;</span> <span class="job_label">Job type:</span> <span class="job_detail_txt">'.$Jty.'</span> <span class="clear">&nbsp;</span> <span class="job_label">Company:</span> <span class="job_detail_txt">Lorem dummy text</span> <span class="clear">&nbsp;</span> <span class="job_label">Contact:</span> <span class="job_detail_txt">'.$Cn.'</span> <span class="clear">&nbsp;</span> </div>
                        </div>
                         <h3>Job Details</h3>
                        <div class="jobdetal_scroll">
                                <div class="personal_container">
                                      <div class="personal_box"> <span class="text">'.$Jd.'<br/></span> </div>
                                </div>
                         </div>
                 </div>';            
        
         $content1 = utf8_encode($content);
require_once('MPDF/mpdf.php');
//require_once('MPDF/test.php');
        $mpdf = new mPDF();
        $mpdf->WriteHTML($content1);
        $mpdf->Output($Jt,d);
        exit;
?>
