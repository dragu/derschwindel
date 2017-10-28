<?php

namespace AppBundle\Repository;

class BlockRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * @return \AppBundle\Entity\Block[]
     */
    public function findLastBlocks()
    {
        return $this->findBy([], ['id' => 'desc'], 16);
    }

    /**
     * @return \AppBundle\Entity\Block|null
     */
    public function findLast()
    {
        return $this->findOneBy([], ['id' => 'desc']);
    }
}
