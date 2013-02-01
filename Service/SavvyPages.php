<?php

namespace Savvy\PagesBundle\Service;

use Savvy\PagesBundle\Controller\BaseController;

class SavvyPages extends BaseController {

    protected $whiteLabel;

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