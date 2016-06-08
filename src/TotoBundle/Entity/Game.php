<?php

namespace TotoBundle\Entity;

/**
 * Game
 */
class Game
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @var \TotoBundle\Entity\Team
     */
    private $homeTeam;

    /**
     * @var \TotoBundle\Entity\Team
     */
    private $awayTeam;


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
     * Set createdAt
     *
     * @return Game
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
     * @return Game
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
     * Set homeTeam
     *
     * @param \TotoBundle\Entity\Team $homeTeam
     *
     * @return Game
     */
    public function setHomeTeam(\TotoBundle\Entity\Team $homeTeam = null)
    {
        $this->homeTeam = $homeTeam;

        return $this;
    }

    /**
     * Get homeTeam
     *
     * @return \TotoBundle\Entity\Team
     */
    public function getHomeTeam()
    {
        return $this->homeTeam;
    }

    /**
     * Set awayTeam
     *
     * @param \TotoBundle\Entity\Team $awayTeam
     *
     * @return Game
     */
    public function setAwayTeam(\TotoBundle\Entity\Team $awayTeam = null)
    {
        $this->awayTeam = $awayTeam;

        return $this;
    }

    /**
     * Get awayTeam
     *
     * @return \TotoBundle\Entity\Team
     */
    public function getAwayTeam()
    {
        return $this->awayTeam;
    }
}
