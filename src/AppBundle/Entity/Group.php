<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use AppBundle\Exception\InvalidInputDataException;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\GroupRepository")
 * @ORM\Table(name="groups", options={"collate"="utf8_unicode_ci"})
 */
class Group extends Entity
{
    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", name="name", length=64)
     **/
    protected $name;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="User", mappedBy="groups")
     */
    protected $users;

    /**
     * Group constructor
     */
    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Group
     */
    public function setName($name)
    {
        $name = (string) $name;
        if (strlen($name) > 60) {
            throw new InvalidInputDataException(
                'Group name must be a string that is less than 60 characters in length'
            );
        }

        $this->name = $name;
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * Assigns a user to the group
     *
     * @param User $user
     * @return Group
     */
    public function assignUser(User $user)
    {
        $user->assignToGroup($this);
        return $this;
    }

    /**
     * Removes a user from the group
     *
     * @param User $user
     * @return Group
     */
    public function removeUser(User $user)
    {
        $user->removeFromGroup($this);
        return $this;
    }
}