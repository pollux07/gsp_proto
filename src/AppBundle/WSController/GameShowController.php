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

        $cost = ['cost' =>12,];

        $encriptedPsw = password_hash($psw, PASSWORD_BCRYPT, $cost)."\n";
        /**************************
         * BEGIN TRANSACTION
         **************************/
        $conn->beginTransaction();

        Selectors::execute($conn, "
            INSERT INTO users (username, email, password, disabled)
            VALUES ('$username', '$email', '$encriptedPsw', 0)
        ");

        /**************************
         * COMMIT
         **************************/
        $conn->commit();

        return new JsonResponse(array(
            "code" =>self::RESPONSE_OK,
        ));
    }

}