<?php

namespace TotoBundle\Entity;

/**
 * Team
 */
class Team
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $homeGames;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $awayGames;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->homeGames = new \Doctrine\Common\Collections\ArrayCollection();
        $this->awayGames = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Team
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set createdAt
     *
     * @return Team
     */
    public function setCreatedAt()
    {
        $this->createdAt = new \DateTime();

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Team
     */
    public function setUpdatedAt()
    {
        $this->updatedAt = new \DateTime();

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Add homeGame
     *
     * @param \TotoBundle\Entity\Game $homeGame
     *
     * @return Team
     */
    public function addHomeGame(\TotoBundle\Entity\Game $homeGame)
    {
        $this->homeGames[] = $homeGame;

        return $this;
    }

    /**
     * Remove homeGame
     *
     * @param \TotoBundle\Entity\Game $homeGame
     */
    public function removeHomeGame(\TotoBundle\Entity\Game $homeGame)
    {
        $this->homeGames->removeElement($homeGame);
    }

    /**
     * Get homeGames
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getHomeGames()
    {
        return $this->homeGames;
    }

    /**
     * Add awayGame
     *
     * @param \TotoBundle\Entity\Game $awayGame
     *
     * @return Team
     */
    public function addAwayGame(\TotoBundle\Entity\Game $awayGame)
    {
        $this->awayGames[] = $awayGame;

        return $this;
    }

    /**
     * Remove awayGame
     *
     * @param \TotoBundle\Entity\Game $awayGame
     */
    public function removeAwayGame(\TotoBundle\Entity\Game $awayGame)
    {
        $this->awayGames->removeElement($awayGame);
    }

    /**
     * Get awayGames
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAwayGames()
    {
        return $this->awayGames;
    }
    /**
     * @var \TotoBundle\Entity\Group
     */
    private $group;


    /**
     * Set group
     *
     * @param \TotoBundle\Entity\Group $group
     *
     * @return Team
     */
    public function setGroup(\TotoBundle\Entity\Group $group = null)
    {
        $this->group = $group;

        return $this;
    }

    /**
     * Get group
     *
     * @return \TotoBundle\Entity\Group
     */
    public function getGroup()
    {
        return $this->group;
    }
}
