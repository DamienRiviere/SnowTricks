<?php

namespace App\Domain\Trick\Helpers;

use Doctrine\ORM\PersistentCollection;

final class UpdateTrick
{

    /**
     * Get all items to remove from the Video or Picture entity when the form is updated
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
     * @param array $updateItems
     * @return array
     */
    public static function addNewItemToUpdateItems(array $newItems, array $updateItems): array
    {
        foreach ($newItems as $newItem) {
            $updateItems[] = $newItem;
        }

        return $updateItems;
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

    /**
     * Search an item in array by his id
     * @param int|null $id
     * @param array $items
     * @return array
     */
    public static function searchById(?int $id, array $items)
    {
        $newItems = [];

        foreach ($items as $key => $value) {
            if ($value->getId() === $id) {
                $newItems[] = $items[$key];
            }
        }

        return $newItems;
    }
}
