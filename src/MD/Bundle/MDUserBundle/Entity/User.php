<?php

namespace MD\Bundle\MDUserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;

/**
 * MD\Bundle\MDUserBundle\Entity\User
 *
 * @ORM\Table(name="md_user")
 * @ORM\Entity(repositoryClass="MD\Bundle\MDUserBundle\Repository\UserRepository")
 */
class User implements AdvancedUserInterface, \Serializable {

   
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=25, unique=true)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $salt;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=60, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $active;
    
    
    private $roles;

    public function __construct() {
        $this->active = true;
        $this->salt = md5(uniqid(null, true));
        $this->roles = array('ROLE_ADMIN');
    }

    /**
     * @inheritDoc
     */
    public function getUsername() {
        return $this->username;
    }
    
    public function getAdminRolls() {
        return array('ROLE_ADMIN','ROLE_SUPER_ADMIN');
    }

    /**
     * @inheritDoc
     */
    public function getSalt() {
        return $this->salt;
    }

    /**
     * @inheritDoc
     */
    public function getPassword() {
        return $this->password;
    }

    /**
     * @inheritDoc
     */
    public function getRoles() {
        return $this->roles;
//        return array('ROLE_ADMIN');
    }

    /**
     * @inheritDoc
     */
    public function eraseCredentials() {
        
    }

    /**
     * @see \Serializable::serialize()
     */
    public function serialize() {
        return serialize(array(
            $this->id,
        ));
    }

    /**
     * @see \Serializable::unserialize()
     */
    public function unserialize($serialized) {
        list (
                $this->id,
                ) = unserialize($serialized);
    }

    public function equals(\Symfony\Component\Security\Core\User\UserInterface $user) { 
        return $this->id === $user->getId();
    }
    
    public function isAccountNonLocked(){
        return true;
    }
    
    public function isCredentialsNonExpired(){
        return true;
    }
    
    public function isAccountNonExpired(){
        return true;
    }
    
    public function isEnabled(){
        return $this->isActive();
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function isActive() {
        return $this->active;
    }

    public function setActive($isActive) {
        $this->active = $isActive;
    }
    
    public function setRoles($roles) {
        $this->roles = $roles;
    }


    public function setUsername($username) {
        $this->username = $username;
    }

    public function setSalt($salt) {
        $this->salt = $salt;
    }

    public function setPassword($password) {
        $this->password = $password;
    }


}