<?php
    function get_qr($device)
    {
        $curl = curl_init();
    	curl_setopt_array($curl, array(
    	  CURLOPT_URL => 'http://127.0.0.1:8000/sessions/status/'.$device.'?apikey=A4gx18YGxKAvR01ClcHpcR7TjZUNtwvE',
    	  CURLOPT_RETURNTRANSFER => true,
    	  CURLOPT_ENCODING => '',
    	  CURLOPT_MAXREDIRS => 10,
    	  CURLOPT_TIMEOUT => 0,
    	  CURLOPT_FOLLOWLOCATION => true,
    	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    	  CURLOPT_CUSTOMREQUEST => 'GET',
    	));
	    $session = curl_exec($curl);
    	curl_close($curl);
    	$session_result = json_decode($session, true);
        if($session_result['success'] == false) {
            $curl = curl_init();
        	curl_setopt_array($curl, array(
        	  CURLOPT_URL => 'http://127.0.0.1:8000/sessions/add?apikey=A4gx18YGxKAvR01ClcHpcR7TjZUNtwvE',
        	  CURLOPT_RETURNTRANSFER => true,
        	  CURLOPT_ENCODING => '',
        	  CURLOPT_MAXREDIRS => 10,
        	  CURLOPT_TIMEOUT => 0,
        	  CURLOPT_FOLLOWLOCATION => true,
        	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        	  CURLOPT_CUSTOMREQUEST => 'POST',
        	  CURLOPT_POSTFIELDS => 'id='.$device.'&typeAuth=qr&phoneNumber='.$device,
        	));
    	    $response = curl_exec($curl);
        	curl_close($curl);
        	$qr_res = json_decode($response, true);
        	$qr['success'] = true;
        	$qr['status'] = 2;
        	$qr['code'] = $qr_res['data']['qr'];
        	$qr['message'] = $qr_res['message'];
        } else {
            if($session_result['data']['status'] != 'authenticated') {
        	    $qr['success'] = false;
        	    $qr['status'] = 0;
        	    $qr['message'] = '<center><a href="whatsapp"><img src="../assets/img/design/qrexpired.png" style="width:320px;"/></a></center>';
            } else {
                $qr['success'] = false;
                $qr['status'] = 1;
            	$qr['message'] = 'Nomor whatsapp sudah terhubung';
            }
        }
        return $qr;
    }
    
    function send_text($device, $text, $receiver) 
    {
        $url = 'http://127.0.0.1:8000/chats/send?id='.$device.'&apikey=A4gx18YGxKAvR01ClcHpcR7TjZUNtwvE';
        $data = array(
            'receiver' => $receiver,
            'isGroup' => false,
            'message' => array(
                'text' => $text
            )
        );
        $data_json = json_encode($data);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
    	$result = json_decode($response, true);
    	return $result;
    }
    
    function send_image($device, $text, $image_url, $receiver) 
    {
        $url = 'http://127.0.0.1:8000/chats/send?id='.$device.'&apikey=A4gx18YGxKAvR01ClcHpcR7TjZUNtwvE';
        $data = array(
            'receiver' => $receiver,
            'isGroup' => false,
            'message' => array(
                'image' => array(
                    'url' => $image_url
                ),
                'caption' => $text
            )
        );
        $data_json = json_encode($data);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
    	$result = json_decode($response, true);
    	return $result;
    }
    
    function get_profile($device) {
        $url = 'http://127.0.0.1:8000/misc/my-profile?id='.$device.'&apikey=A4gx18YGxKAvR01ClcHpcR7TjZUNtwvE';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
    	$result = json_decode($response, true);
    	return $result;
    }
    
    function get_status($device) {
        $curl = curl_init();
    	curl_setopt_array($curl, array(
    	  CURLOPT_URL => 'http://127.0.0.1:8000/sessions/status/'.$device.'?apikey=A4gx18YGxKAvR01ClcHpcR7TjZUNtwvE',
    	  CURLOPT_RETURNTRANSFER => true,
    	  CURLOPT_ENCODING => '',
    	  CURLOPT_MAXREDIRS => 10,
    	  CURLOPT_TIMEOUT => 0,
    	  CURLOPT_FOLLOWLOCATION => true,
    	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    	  CURLOPT_CUSTOMREQUEST => 'GET',
    	));
	    $session = curl_exec($curl);
    	curl_close($curl);
    	$session_result = json_decode($session, true);
    	return $session_result;
    }
    
    function logout_device($device) {
        $curl = curl_init();
    	curl_setopt_array($curl, array(
    	  CURLOPT_URL => 'http://127.0.0.1:8000/sessions/delete/'.$device.'?apikey=A4gx18YGxKAvR01ClcHpcR7TjZUNtwvE',
    	  CURLOPT_RETURNTRANSFER => true,
    	  CURLOPT_ENCODING => '',
    	  CURLOPT_MAXREDIRS => 10,
    	  CURLOPT_TIMEOUT => 0,
    	  CURLOPT_FOLLOWLOCATION => true,
    	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    	  CURLOPT_CUSTOMREQUEST => 'DELETE',
    	));
	    $session = curl_exec($curl);
    	curl_close($curl);
    	$session_result = json_decode($session, true);
    	return $session_result;
    }
?>