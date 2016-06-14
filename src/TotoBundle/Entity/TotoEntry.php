<?php

namespace TotoBundle\Entity;

/**
 * TotoEntry
 */
class TotoEntry
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $homeScore;

    /**
     * @var integer
     */
    private $awayScore;

    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @var \TotoBundle\Entity\Toto
     */
    private $toto;

    /**
     * @var \TotoBundle\Entity\Game
     */
    private $game;

    private $points;

    public function __toString()
    {
        return $this->getGame()->__toString();
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
     * Set homeScore
     *
     * @param integer $homeScore
     *
     * @return TotoEntry
     */
    public function setHomeScore($homeScore)
    {
        $this->homeScore = $homeScore;

        return $this;
    }

    /**
     * Get homeScore
     *
     * @return integer
     */
    public function getHomeScore()
    {
        return $this->homeScore;
    }

    /**
     * Set awayScore
     *
     * @param integer $awayScore
     *
     * @return TotoEntry
     */
    public function setAwayScore($awayScore)
    {
        $this->awayScore = $awayScore;

        return $this;
    }

    /**
     * Get awayScore
     *
     * @return integer
     */
    public function getAwayScore()
    {
        return $this->awayScore;
    }

    /**
     * Set createdAt
     *
     * @return TotoEntry
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
     * @return TotoEntry
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
     * Set toto
     *
     * @param \TotoBundle\Entity\Toto $toto
     *
     * @return TotoEntry
     */
    public function setToto(\TotoBundle\Entity\Toto $toto = null)
    {
        $this->toto = $toto;

        return $this;
    }

    /**
     * Get toto
     *
     * @return \TotoBundle\Entity\Toto
     */
    public function getToto()
    {
        return $this->toto;
    }

    /**
     * Set game
     *
     * @param \TotoBundle\Entity\Game $game
     *
     * @return TotoEntry
     */
    public function setGame(\TotoBundle\Entity\Game $game = null)
    {
        $this->game = $game;

        return $this;
    }

    /**
     * Get game
     *
     * @return \TotoBundle\Entity\Game
     */
    public function getGame()
    {
        return $this->game;
    }

    /**
     * @return mixed
     */
    public function getPoints()
    {
        return $this->points;
    }

    /**
     * @param mixed $points
     * @return \TotoBundle\Entity\TotoEntry
     */
    public function setPoints($points)
    {
        $this->points = $points;

        return $this;
    }

}

