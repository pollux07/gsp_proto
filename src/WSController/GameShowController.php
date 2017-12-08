<?php
namespace AppBundle\WSController;

use AppBundle\AppBundle;
use AppBundle\Utils\Selectors;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/gs/1.0")
 * Class PsaController
 * @package AppBundle\WSController
 */
class GameShowController extends Controller {
    const RESPONSE_OK = 200;

    /**
     * @Route("/registration", name="gs_registration")
     * @param Request $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function registrationAction(Request $request) {
        $conn = $this->getDoctrine()->getConnection();
        $username = $request->get("username");
        $email = $request->get("email");
        $psw = $request->get("psw");

        $encriptedPsw = sha1($psw);
        /**************************
         * BEGIN TRANSACTION
         **************************/
        $conn->beginTransaction();

        Selectors::execute($conn, "
            INSERT INTO users (nombre_usuario, email, password) 
            VALUES ('$username', '$email', '$encriptedPsw')
        ");

        /**************************
         * COMMIT
         **************************/
        $conn->commit();

        return new JsonResponse(array(
            "code" =>self::RESPONSE_OK,
        ));
    }

    public function loginAction(Request $request) {
        $conn = $this->getDoctrine()->getConnection();
        $email = $request->get("email");
        $pwd = $request->get("pwd");
        $encriptedPass = sha1($pwd);

        $userId = Selectors::selectSingleRecordOrNull($conn, "
            
        ");

        return new JsonResponse(array(
            "code" =>self::RESPONSE_OK,
        ));
    }

}