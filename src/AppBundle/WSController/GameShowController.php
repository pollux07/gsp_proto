<?php
namespace AppBundle\WSController;

use AppBundle\AppBundle;
use AppBundle\Utils\Selectors;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/gs/1.0")
 * Class GameShowController
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
        $email = $request->get("email");
        $psw = $request->get("pwd");

        $psw = sha1($psw);

        if (Selectors::exists($conn, "SELECT 1 FROM users WHERE email = '$email'")) {
            return new JsonResponse(array(
                "code" =>self::RESPONSE_OK,
                "status" => "USER_EXISTS",
            ));
        }
        /**************************
         * BEGIN TRANSACTION
         **************************/
        $conn->beginTransaction();

        Selectors::execute($conn, "
            INSERT INTO users (email, password) 
            VALUES ('$email', '$psw')
        ");

        /**************************
         * COMMIT
         **************************/
        $conn->commit();

        return new JsonResponse(array(
            "code" =>self::RESPONSE_OK,
            "status" => "OK",
        ));
    }

    /**
     * @Route("/login", name="gs_login")
     * @param Request $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function loginAction(Request $request) {
        $conn = $this->getDoctrine()->getConnection();
        $email = $request->get("email");
        $pwd = $request->get("pwd");
        $psw = sha1($pwd);

        $userId = Selectors::selectSingleRecordOrNull($conn, "
            SELECT id
            FROM users
            WHERE email = '$email'
            AND password = '$psw'
        ");

        if (is_null($userId)) {
            return new JsonResponse(array(
                "code" => self::RESPONSE_OK,
                "status" => "USER_NOT_FOUND"
            ));
        }

        return new JsonResponse(array(
            "code" =>self::RESPONSE_OK,
            "status" => "OK",
            "user_id" => $userId["id"],
        ));
    }

    /**
     * Se realizara la busqueda de los datos del perfil del usuario que lo este solicitando.
     * @Route("/loadProfile", name="gs_load_profile")
     * @param Request $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function loadProfileAction(Request $request) {
        $conn = $this->getDoctrine()->getConnection();
        $userId = $request->get("user_id");

        $user = Selectors::selectSingleRecordOrNull($conn, "
            SELECT * FROM users
            WHERE id = $userId
            
        ");

        return new JsonResponse(array(
            "code" => self::RESPONSE_OK,
            "status" => "OK",
            "name" => $user["nombre"],
        ));
    }

    /**
     * Realiza la actualización de los datos del perfil del usuario.
     * @Route("/updateUserProfile", name="gs_update_user_profile")
     * @param Request $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function updateUserProfileAction(Request $request) {
        $conn = $this->getDoctrine()->getConnection();
        $userId = $request->get("user_id");
        $view = $request->get("view");

        /**************************
         * BEGIN TRANSACTION
         **************************/
        $conn->beginTransaction();

        switch ($view) {
            case 1:
                $name = $request->get("name");
                $lastName = $request->get("last_name");
                $userName = $request->get("username");
                $phone = $request->get("phone");
                $cellPhone = $request->get("cellphone");

                Selectors::execute($conn, "
                UPDATE users SET 
                  name = '$name',
                  last_name = '$lastName',
                  username = '$userName',
                  phone = $phone,
                  cellphone = $cellPhone
                WHERE id = $userId
                ");

                break;
            case 2:
                $email = $request->get("email");
                $password = $request->get("psw");
                $password = sha1($password);

                Selectors::execute($conn, "
                UPDATE users SET
                  email = '$email',
                  password = '$password'
                WHERE id = $userId
                ");
                break;
            default:
                break;
        }

        /**************************
         * COMMIT
         **************************/
        $conn->commit();

        return new JsonResponse(array(
            "code" => self::RESPONSE_OK,
            "status" => "OK",
        ));
    }

}