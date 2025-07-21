<?php
// Test script to send POST request to fetch_name.php with contact number

$contact = "9142420000";

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, "http://localhost/hospital_backend/fetch_name.php");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array('contact' => $contact)));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);

if(curl_errno($ch)) {
    echo 'Curl error: ' . curl_error($ch);
} else {
    echo "Response for contact $contact: " . $response;
}

curl_close($ch);
?>
