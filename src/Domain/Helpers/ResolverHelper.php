<?php


namespace App\Domain\Helpers;


use Doctrine\ORM\EntityManagerInterface;

final class ResolverHelper
{

	/** @var EntityManagerInterface */
	protected $em;

	public function __construct(EntityManagerInterface $em)
	{
		$this->em = $em;
	}

	/**
	 * Persist every item contained in items array
	 * @param array $items
	 */
	public function saveItems(array $items)
	{
		foreach($items as $item) {
			$this->em->persist($item);
		}
	}

	/**
	 * Remove every item contained in items array
	 * @param array $items
	 */
	public function removeItems(array $items)
	{
		foreach($items as $item) {
			$this->em->remove($item);
		}
	}

	/**
	 * Check if items is not empty and if not remove every item
	 * @param array $items
	 */
	public function checkIfNotEmptyAndRemove(array $items)
	{
		if (!empty($items)) {
			$this->removeItems($items);
		}
	}
}