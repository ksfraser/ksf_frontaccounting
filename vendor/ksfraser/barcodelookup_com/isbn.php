<?php

 $url = 'https://api2.isbndb.com/book/9780134093413';  
 $restKey = 'HZEAG6KT';  
 
 $headers = array(  
   "Content-Type: application/json",  
   "Authorization: " . $restKey  
 );  
 
 $rest = curl_init();  
 curl_setopt($rest,CURLOPT_URL,$url);  
 curl_setopt($rest,CURLOPT_HTTPHEADER,$headers);  
 curl_setopt($rest,CURLOPT_RETURNTRANSFER, true);  
 
 $response = curl_exec($rest);  
 
 echo $response;  
 print_r($response);  
 curl_close($rest);
