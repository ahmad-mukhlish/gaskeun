<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Kreait\Firebase;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
use Kreait\Firebase\Database;
use Kreait\Firebase\Auth\UserRecord ;
class FirebaseController extends Controller
{


	public function registerFirebase(Request $request) {
		$serviceAccount = ServiceAccount::fromJsonFile(__DIR__.'/pedagangkeliling99-firebase-adminsdk-kwm7p-205152231a.json');
		$firebase 		  = (new Factory)
		->withServiceAccount($serviceAccount)
		->withDatabaseUri('https://pedagangkeliling99.firebaseio.com')
		->create();

		$auth = $firebase->getAuth();

		$userProperties = [
			'uid' => "pmk-".$request->id,
			'displayName' => $request->username,
			'email' => $request->email,
			'password' => $request->password,
			'disabled' => false

		];

		$createdUser = $auth->createUser($userProperties);
		return redirect('/') ;
	}

	public function addPedagangFirebase(Request $request) {
		$serviceAccount = ServiceAccount::fromJsonFile(__DIR__.'/pedagangkeliling99-firebase-adminsdk-kwm7p-205152231a.json');
		$firebase 		  = (new Factory)
		->withServiceAccount($serviceAccount)
		->withDatabaseUri('https://pedagangkeliling99.firebaseio.com')
		->create();

		$auth = $firebase->getAuth();

		$userProperties = [
			'uid' => "pdg-".$request->id,
			'displayName' => $request->username,
			'email' => $request->email,
			'password' => $request->password,
			'disabled' => false

		];

		$createdUser = $auth->createUser($userProperties);

		$idPmk = "pmk-".$request->id_pemilik;
		$idPdg = "pdg-".$request->id;


		return $idPdg ;
	}

}
?>
