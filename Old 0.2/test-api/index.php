<?PHP
$json = file_get_contents('serpents.json');
$json_data = json_decode($json,true);
header('Content-Type: application/json');
echo json_encode($json_data);
//Met de volgende lijn code kan je een folder aanmaken
//mkdir('D:\xampp\htdocs\Old 0.2\test-api\1', 0777, true);