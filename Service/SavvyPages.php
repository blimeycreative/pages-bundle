<?php

namespace Savvy\PagesBundle\Service;

use Savvy\PagesBundle\Controller\BaseController;

class SavvyPages extends BaseController {

    protected $whiteLabel;
    /**
     * Container
     *
     * @var ContainerInterface
     */
    protected $container;

    /**
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function getAgentDetail($detail)
    {
        if(!$this->whiteLabel){
            $agent = $this->container
                ->get('doctrine')
                ->getRepository("PagesExtensionBundle:Agent")
                ->find($this->container->getParameter("agent_id"));
            $this->whiteLabel = $agent->getWhiteLabel();
        }

        return $this->whiteLabel->{"get$detail"}();
    }

}