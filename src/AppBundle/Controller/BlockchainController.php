<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Block;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class BlockchainController extends Controller
{
    /**
     * @Route("/find/{id}", name="find")
     */
    public function indexAction(Block $block)
    {
        return new JsonResponse($this->getBlockArray($block));
    }

    /**
     * @Route("/api/blockDigest", name="dig")
     */
    public function getBlockAction()
    {
        $nextRewardTime = $this->get('blockchain_generator')->generate();

        $blocks = $this->getDoctrine()
            ->getRepository('AppBundle:Block')
            ->findLastBlocks();

        $arrayBlocks = [];

        foreach ($blocks as $block) {
            $arrayBlocks[] = $this->getBlockArray($block);
        }

        return new JsonResponse([
            'success' => true,
            'result' => [
                'blocks' => $arrayBlocks,
                'nextRewardTime' => $nextRewardTime->format(DATE_ISO8601),
            ]
        ]);
    }

    private function getBlockArray(Block $block) : array
    {
        return [
            'id' => $block->getId(),
            'createdAt' => $block->getCreatedAt()->format(DATE_ISO8601),
            'hash' => $block->getHash(),
            'signature' => $block->getSignature(),
            'operationsCount' => $block->getOperationsCount(),
         ];
    }
}
