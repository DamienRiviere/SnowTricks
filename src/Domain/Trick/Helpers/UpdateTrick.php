<?php

namespace App\Domain\Trick\Helpers;

use Doctrine\ORM\PersistentCollection;

final class UpdateTrick
{

    /**
     * Get all items to remove from the Video or Picture entity when the form is edited
     * @param array $dto
     * @param PersistentCollection $trick
     * @return array
     */
    public static function getItemsToRemove(array $dto, PersistentCollection $trick): array
    {
        $items = self::getItems($trick);
        // Get the array key by items id
        $itemsId = self::getItemsById($items);

        $itemsDto = self::getItems($dto);
        // Get the array key by itemsDto id
        $itemsDtoId = self::getItemsById($itemsDto);

        foreach ($itemsId as $item) {
            foreach ($itemsDtoId as $itemDto) {
                if ($itemDto->getId() === $item->getId()) {
                    // Delete every item in ItemsId that is in both itemDto and item
                    unset($itemsId[$itemDto->getId()]);
                }
            }
        }

        return $itemsId;
    }

    /**
     * Add newItems to array editItems
     * @param array $newItems
     * @param array $editItems
     * @return array
     */
    public static function addNewItemToEditItems(array $newItems, array $editItems): array
    {
        foreach ($newItems as $newItem) {
            $editItems[] = $newItem;
        }

        return $editItems;
    }

    public static function getItemsById($items)
    {
        $itemsById = [];

        foreach ($items as $item) {
            $itemsById[$item->getId()] = $item;
        }

        return $itemsById;
    }

    public static function getItems($items)
    {
        $itemsArr = [];

        foreach ($items as $item) {
            $itemsArr[] = $item;
        }

        return $itemsArr;
    }
}
