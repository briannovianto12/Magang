<?php
if(!empty($posts))  
{ 
    $count = 1;
    $outputhead = '';
    $outputbody = '';  
    $outputtail ='';

    $outputhead .= '<div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>User Name</th>
                                <th>Phone No</th>
                            </tr>
                        </thead>
                        <tbody>
                ';
                  
    foreach ($posts as $post)    
    {   
    $outputbody .=  ' 
                
                            <tr> 
		                        <td>'.$post->full_name.'</td>
                                <td>'.$post->msisdn.'</td>
                            </tr> 
                            <input type="hidden" value="'.$post->full_name.' ('.$post->msisdn.')'.'"/>
                    ';
    }  

    $outputtail .= ' 
                        </tbody>
                    </table>
                </div>';
         
    echo $outputhead; 
    echo $outputbody; 
    echo $outputtail; 
 }  
 
 else  
 {  
    echo 'Data Not Found';  
 } 
 ?>  