<?php

namespace Coyote\BaseBundle\Entity;

use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 * @ORM\Entity(repositoryClass="UserRepository")
 * @Constraints\UniqueEntity(
 * 		fields={"email"},
 * 		message="The email is already registered!"
 * )
 * @Constraints\UniqueEntity(
 * 		fields={"usernameCanonical"},
 * 		message="The username is already taken!"
 * )
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
	
   /**
    * @Assert\NotBlank(message="Username cannot be blank!")
    * @Assert\Regex(pattern="/^[a-zA-Z0-9]{2,}$/", message="{{ value }} is not valid! Only alphanumeric characters are allowed, and a minimum of 2 characters!")
    */
	protected $usernameCanonical;
	
	/**
	 * @Assert\NotBlank(message="Email address is required!", groups={"create", "Default"})
	 * @Assert\Email(message="{{ value }} is not a valid email address!")
	 */
	protected $emailCanonical;
	
	/**
	 * @Assert\NotBlank(message="Password required!", groups={"create", "register"})
	 */
	protected $plainPassword;
	
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
}