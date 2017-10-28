<?php

namespace AppBundle\Service;

use DateTime;
use DateInterval;
use Doctrine\ORM\EntityManager;

class BlockchainGenerator
{
    const GENESIS_BLOCK_DATE = '2017-10-28 00:00:00';
    const BLOCK_TIME = 6;

    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var \AppBundle\Repository\BlockRepository
     */
    private $blockRepository;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
        $this->blockRepository = $em->getRepository('AppBundle:Block');
    }

    public function generate() : DateTime
    {
        $lastBlock = $this->getLastBlock();

        /* @var $lastBlockTime DateTime */
        $lastBlockTime = ($lastBlock)
            ? $lastBlock->getCreatedAt()
            : new DateTime(static::GENESIS_BLOCK_DATE);

        $interval = DateInterval::createFromDateString(sprintf(
            '+%d seconds',
            static::BLOCK_TIME
        ));

        $nextBlockTime = clone $lastBlockTime;
        $nextBlockTime->add($interval);

        while ($nextBlockTime < new DateTime()) {
            $this->em->persist($this->generateBlock($nextBlockTime));

            $nextBlockTime->add($interval);
        }

        $this->em->flush();

        return $nextBlockTime;
    }

    /**
     * @return \AppBundle\Entity\Block
     */
    private function getLastBlock()
    {
        return $this->blockRepository->findLast();
    }

    private function generateBlock(DateTime $time)
    {
        $block = new \AppBundle\Entity\Block();

        $hash = $this->generateHash($time);

        $block
            ->setCreatedAt(clone $time)
            ->setHash($hash)
            ->setSignature($this->generateSignature($hash))
            ->setOperationsCount($this->generateOperationsCount());

        return $block;
    }

    private function generateHash(DateTime $time) : string
    {
        return sha1($time->getTimestamp().'wow, so hashish'.rand(9999, 9999999999));
    }

    private function generateSignature(string $hash) : string
    {
        return hash('sha512', $hash).substr($hash, rand(0, 30), 2);
    }

    private function generateOperationsCount() : int
    {
        return (rand(0, 15) === 11)
            ? rand(0, 10)
            : 0;
    }
}
