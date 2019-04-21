<?php  
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app = new \Slim\App;

$app->options('/{routes:.+}', function ($request, $response, $args) {
    return $response;
});
$app->add(function ($req, $res, $next) {
    $response = $next($req, $res);
    return $response
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
});


//get all Customers

$app->get('/api/customers', function(Request $request, Response $response){
	
	$sql = 'SELECT * FROM customers';

	try {
		//Get DB Object
		$db = new db();
		//connect
		$db = $db->connect();

		$stmt = $db->query($sql);
		$customers = $stmt->fetchAll(PDO::FETCH_OBJ);
		$db = null;

		echo json_encode($customers);

	} catch (PDOException $e) {
		// echo '{"error" : {"text" :'.$e->getMessage().' }}';
		die($e->getMessage());
	}


});


//Get single customer
$app->get('/api/customer/{id}', function(Request $request, Response $response){
	
	$id = $request->getAttribute('id');

	$sql = "SELECT * FROM customers WHERE id = $id";

	try {
		//Get DB Object
		$db = new db();
		//connect
		$db = $db->connect();

		$stmt = $db->query($sql);
		$customer = $stmt->fetch(PDO::FETCH_OBJ);
		$db = null;

		echo json_encode($customer);

	} catch (PDOException $e) {
		// echo '{"error" : {"text" :'.$e->getMessage().' }}';
		die($e->getMessage());
	}


});



//Add customer
$app->post('/api/customer/add', function(Request $request, Response $response){
	
	$first_name = $request->getParam('first_name');
	$last_name = $request->getParam('last_name');
	$phone = $request->getParam('phone');
	$email = $request->getParam('email');
	$address = $request->getParam('address');
	$city = $request->getParam('city');
	$province = $request->getParam('province');
	
	

	$sql = "INSERT INTO customers (first_name,last_name,phone,email,address,city,province) VALUES
	 (:first_name,:last_name,:phone,:email,:address,:city,:province)";

	try {
		//Get DB Object
		$db = new db();
		//connect
		$db = $db->connect();

		$stmt = $db->prepare($sql);
		
		$stmt->bindParam(':first_name', $first_name);
		$stmt->bindParam(':last_name', $last_name);
		$stmt->bindParam(':phone', $phone);
		$stmt->bindParam(':email', $email);
		$stmt->bindParam(':address', $address);
		$stmt->bindParam(':city', $city);
		$stmt->bindParam(':province', $province);
		
		$stmt->execute();

		echo 'Customer has been added to the system';
		

	} catch (PDOException $e) {
		// echo '{"error" : {"text" :'.$e->getMessage().' }}';
		die($e->getMessage());
	}


});


//Add customer
$app->put('/api/customer/update/{id}', function(Request $request, Response $response){
	$id = $request->getAttribute('id');
	
	$first_name = $request->getParam('first_name');
	$last_name = $request->getParam('last_name');
	$phone = $request->getParam('phone');
	$email = $request->getParam('email');
	$address = $request->getParam('address');
	$city = $request->getParam('city');
	$province = $request->getParam('province');
	
	
	$sql = "UPDATE customers SET
				first_name = :first_name,
				last_name = :last_name,
				phone = :phone,
				email = :email,
				address = :address,
				city = :city,
				province = :province
			WHERE id = $id";

	try {
		//Get DB Object
		$db = new db();
		//connect
		$db = $db->connect();

		$stmt = $db->prepare($sql);
		
		$stmt->bindParam(':first_name', $first_name);
		$stmt->bindParam(':last_name', $last_name);
		$stmt->bindParam(':phone', $phone);
		$stmt->bindParam(':email', $email);
		$stmt->bindParam(':address', $address);
		$stmt->bindParam(':city', $city);
		$stmt->bindParam(':province', $province);
		
		$stmt->execute();

		echo 'Customer has been updated';
		

	} catch (PDOException $e) {
		// echo '{"error" : {"text" :'.$e->getMessage().' }}';
		die($e->getMessage());
	}


});


//Delete customer
$app->delete('/api/customer/delete/{id}', function(Request $request, Response $response){
	
	$id = $request->getAttribute('id');

	$sql = " DELETE FROM customers WHERE id = $id";

	try {
		//Get DB Object
		$db = new db();
		//connect
		$db = $db->connect();

		$stmt = $db->prepare($sql);
		$stmt->execute();
		$db = null;

		echo 'Customer has been deleted';


	} catch (PDOException $e) {
		// echo '{"error" : {"text" :'.$e->getMessage().' }}';
		die($e->getMessage());
	}


});




?>