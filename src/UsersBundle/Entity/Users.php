<?php

namespace UsersBundle\Entity;

/**
 * Users
 */
class Users
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $nombre;

    /**
     * @var string
     */
    private $apPat;

    /**
     * @var string
     */
    private $apMat;

    /**
     * @var string
     */
    private $nombreUsuario;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $password;

    /**
     * @var int
     */
    private $telefono;

    /**
     * @var int
     */
    private $celular;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Users
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set apPat
     *
     * @param string $apPat
     *
     * @return Users
     */
    public function setApPat($apPat)
    {
        $this->apPat = $apPat;

        return $this;
    }

    /**
     * Get apPat
     *
     * @return string
     */
    public function getApPat()
    {
        return $this->apPat;
    }

    /**
     * Set apMat
     *
     * @param string $apMat
     *
     * @return Users
     */
    public function setApMat($apMat)
    {
        $this->apMat = $apMat;

        return $this;
    }

    /**
     * Get apMat
     *
     * @return string
     */
    public function getApMat()
    {
        return $this->apMat;
    }

    /**
     * Set nombreUsuario
     *
     * @param string $nombreUsuario
     *
     * @return Users
     */
    public function setNombreUsuario($nombreUsuario)
    {
        $this->nombreUsuario = $nombreUsuario;

        return $this;
    }

    /**
     * Get nombreUsuario
     *
     * @return string
     */
    public function getNombreUsuario()
    {
        return $this->nombreUsuario;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Users
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return Users
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set telefono
     *
     * @param integer $telefono
     *
     * @return Users
     */
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;

        return $this;
    }

    /**
     * Get telefono
     *
     * @return int
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * Set celular
     *
     * @param integer $celular
     *
     * @return Users
     */
    public function setCelular($celular)
    {
        $this->celular = $celular;

        return $this;
    }

    /**
     * Get celular
     *
     * @return int
     */
    public function getCelular()
    {
        return $this->celular;
    }
}
