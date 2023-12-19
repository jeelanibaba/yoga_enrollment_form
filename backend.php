<?php
function CompletePayment($userData) {
  return ['status' => 'success', 'message' => 'Payment successful'];
}

$data = json_decode(file_get_contents('php://input'), true);


if (empty($data['name']) || empty($data['email']) || empty($data['age']) || empty($data['batch']) ) {
    echo json_encode([
        "status" => "error",
        "message" => "Please fill all required fields."
    ]);
    exit;
}
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "yoga_classes";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$name = $conn->real_escape_string($data['name']);
$email = $conn->real_escape_string($data['email']);
$age = $conn->real_escape_string($data['age']);
$batch = $conn->real_escape_string($data['batch']);

if($conn->query("SELECT * FROM participant WHERE LOWER(name) = LOWER('$name')")->num_rows > 0){
    echo json_encode([
        "status" => "error",
        "message" => "You have already enrolled. Please log in instead."
    ]);
    exit;
}

$sql = "INSERT INTO participant (name, email, age, batch)
        VALUES ('$name', '$email', '$age', '$batch')";

if ($conn->query($sql) === TRUE) {
    $paymentResponse = CompletePayment($data);
    echo json_encode([
      "status" => "success",
      "message" => "Enrollment successful! Payment status: " . $paymentResponse["message"]
    ]);
  } 
  else {
    echo json_encode([
      "status" => "error",
      "message" => "Error storing data: " 
    ]);
  }

$conn->close();
?> 
