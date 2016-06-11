<?php
/**
 * Created by PhpStorm.
 * User: Quentin Gangler
 * Date: 09/06/2016
 * Time: 13:02
 */
namespace API\V1\Model;

class User{
    private $id;
    private $nom;
    private $role;
    private $prenom;
    private $login;
    private $email;

    public function __construct($data){
        $this->id = isset($data['id'])? $data['id'] : 0;
        $this->nom = $data['nom'];
        $this->role = $data['role'];
        $this->prenom = $data['prenom'];
        $this->login = $data['login'];
        $this->email = $data['email'];
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param string $nom
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    /**
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * @param string $prenom
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
    }

    /**
     * @return string
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * @param string $login
     */
    public function setLogin($login)
    {
        $this->login = $login;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @param mixed $role
     */
    public function setRole($role)
    {
        $this->role = $role;
    }

    public function isValid(){
        return !empty($this->login)
        && !empty($this->nom)
        && !empty($this->prenom)
        && !empty($this->role)
        && !empty($this->email);
    }

    public function isPlayer(){
        return $this->role == "player" || $this->isJournalist();
    }

    public function isJournalist(){
        return $this->role == "journalist" || $this->isGuard();
    }

    public function isGuard(){
        return $this->role == "guard" || $this->isAuthor();
    }

    public function isAuthor(){
        return $this->role == "author" || $this->isAdmin();
    }

    public function isAdmin(){
        return $this->role == "admin";
    }
}