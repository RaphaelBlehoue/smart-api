<?php
namespace Labs\FacturationBundle\Twig\Extensions;

use Symfony\Component\DependencyInjection\ContainerInterface;

class QuantityOutRestExtension extends \Twig_Extension
{
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;

    }
    public function getFunctions()
    {
        return array(
            'RestQuantity' => new \Twig_Function_Method($this, 'getRestQuantity'),
        );
    }

    public function getRestQuantity($product_id, $command_ref, $qteCmd)
    {
        $serviceStock = $this->container->get('inventaire.stock.test.quantity');
        $inventor = $serviceStock->getQuantityInventorSumProduct($product_id, $command_ref);
        $qte_rest = ($qteCmd - $inventor);
        return $qte_rest;
    }

    public function getName()
    {
        return 'rest_quantity_extension';
    }

}