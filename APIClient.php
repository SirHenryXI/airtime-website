<?php
require("config.php");

class APIClient{



    //Used for getting beacons, locations, and sublocations to display on dashboard
    function multiRequest($data, $options = array()) {
            $headers = array(
                'Content-Type: application/json',                                                                                
                'Content-Length: ' . strlen($data_string),
                "X-Airtime-Token: peWcXrMFjaW0Tz4x",   
            );


        // array of curl handles
        $curly = array();
        // data to be returned
        $result = array();

        // multi handle
        $mh = curl_multi_init();

        // loop through $data and create curl handles
        // then add them to the multi-handle
        foreach ($data as $id => $d) {

            $curly[$id] = curl_init();

            $url = (is_array($d) && !empty($d['url'])) ? $d['url'] : $d;
            curl_setopt($curly[$id], CURLOPT_URL,            $url);
            curl_setopt($curly[$id], CURLOPT_HEADER,         0);
            curl_setopt($curly[$id], CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curly[$id], CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',                                                                                
                'Content-Length: ' . strlen($data_string),
                "X-Airtime-Token: peWcXrMFjaW0Tz4x",   
            ) );

            // post?
            if (is_array($d)) {
                if (!empty($d['post'])) {
                    curl_setopt($curly[$id], CURLOPT_POST,       1);
                    curl_setopt($curly[$id], CURLOPT_POSTFIELDS, $d['post']);
                }
            }

            // extra options?
            if (!empty($options)) {
                curl_setopt_array($curly[$id], $options);
            }

            curl_multi_add_handle($mh, $curly[$id]);
        }

        // execute the handles
        $running = null;
        do {
            curl_multi_exec($mh, $running);
        } while($running > 0);


        // get content and remove handles
        foreach($curly as $id => $c) {
            $result[$id] = curl_multi_getcontent($c);
            curl_multi_remove_handle($mh, $c);
        }

        // all done
        curl_multi_close($mh);

        return $result;
    }
    
    //Beacons
    
    //Insert
    
    function addBeacon($beaconUUID,$major,$minor,$brand,$model){
        $data = array("uuid" => $beaconUUID,"major" => $major,"minor" => $minor,"brand" => $brand,"model" => $model);                                                                    
        $data_string = json_encode($data);                                                                                   
        $url = "https://airtime.herokuapp.com/beacons";
        $ch = curl_init($url);                                                                      
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
            'Content-Type: application/json',                                                                                
            'Content-Length: ' . strlen($data_string),
            "X-Airtime-Token: peWcXrMFjaW0Tz4x")                                                                       
        );                                                                                                                   
        $response = curl_exec($ch);
//         return $response;
    }
 
     //Update
    
    function updateBeacon($beaconID,$uuid,$major,$minor,$brand,$model){
        $data = array("uuid" => $uuid,"major" => $major,"minor" => $minor,"brand" => $brand,"model" => $model);                                                                    
        $data_string = json_encode($data);                                                                                   
        $url = "https://airtime.herokuapp.com/beacon/".$beaconID;
        $ch = curl_init($url);                                                                      
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");                                                                     
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
            'Content-Type: application/json',                                                                                
            'Content-Length: ' . strlen($data_string),
            "X-Airtime-Token: peWcXrMFjaW0Tz4x")                                                                       
        );                                                                                                                   
        $response = curl_exec($ch);
        return $response;
    }
       
    //Delete
    
    function deleteBeacon($beaconID){
        $url = "https://airtime.herokuapp.com/beacon/" . $beaconID;
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array("X-Airtime-Token: peWcXrMFjaW0Tz4x"));
        
        // Make the REST call, returning the result
        $response = curl_exec($curl);
        if (!$response) {
            die("Connection Failure.n");
        }
    
        return $response;
    }
    
    
    //Sublocations
    
    
    //Insert
    
    function addSublocation($name){
        $data = array("name" => $name);                                                                    
        $data_string = json_encode($data);                                                                                   
        $url = "https://airtime.herokuapp.com/sublocations";
        $ch = curl_init($url);                                                                      
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
            'Content-Type: application/json',                                                                                
            'Content-Length: ' . strlen($data_string),
            "X-Airtime-Token: peWcXrMFjaW0Tz4x")                                                                       
        );                                                                                                                   
        $response = curl_exec($ch);
        return $response;
    }
    
    //Update
    
    function updateSublocation($sublocationID,$name){
        $data = array("name" => $name);                                                                    
        $data_string = json_encode($data);                                                                                   
        $url = "https://airtime.herokuapp.com/sublocation/".$sublocationID;
        $ch = curl_init($url);                                                                      
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");                                                                     
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
            'Content-Type: application/json',                                                                                
            'Content-Length: ' . strlen($data_string),
            "X-Airtime-Token: peWcXrMFjaW0Tz4x")                                                                       
        );                                                                                                                   
        $response = curl_exec($ch);
        return $response;
    }
    
    //Delete
    
    function deleteSublocation($sublocationID){
        $url = "https://airtime.herokuapp.com/sublocation/" . $sublocationID;
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array("X-Airtime-Token: peWcXrMFjaW0Tz4x"));
        
        // Make the REST call, returning the result
        $response = curl_exec($curl);
        if (!$response) {
            die("Connection Failure.n");
        }
    
        return $response;
    }
    
    
    //Locations
    
    
    //Insert
    
    function addLocation($name){
        $data = array("name" => $name);                                                                    
        $data_string = json_encode($data);                                                                                   
        $url = "https://airtime.herokuapp.com/locations";
        $ch = curl_init($url);                                                                      
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
            'Content-Type: application/json',                                                                                
            'Content-Length: ' . strlen($data_string),
            "X-Airtime-Token: peWcXrMFjaW0Tz4x")                                                                       
        );                                                                                                                   
        $response = curl_exec($ch);
        return $response;
    }
    
    //Update
    
    function updateLocation($locationID,$name){
        $data = array("name" => $name);                                                                    
        $data_string = json_encode($data);                                                                                   
        $url = "https://airtime.herokuapp.com/location/".$locationID;
        $ch = curl_init($url);                                                                      
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");                                                                     
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
            'Content-Type: application/json',                                                                                
            'Content-Length: ' . strlen($data_string),
            "X-Airtime-Token: peWcXrMFjaW0Tz4x")                                                                       
        );                                                                                                                   
        $response = curl_exec($ch);
        return $response;
    }
    
    //Delete
    
    function deleteLocation($locationID){
        $url = "https://airtime.herokuapp.com/location/" . $locationID;
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array("X-Airtime-Token: peWcXrMFjaW0Tz4x"));
        
        // Make the REST call, returning the result
        $response = curl_exec($curl);
        if (!$response) {
            die("Connection Failure.n");
        }
    
        return $response;
    }
}

?>