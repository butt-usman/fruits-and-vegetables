<?php

namespace App\Tests\App\Service;

use App\Service\Collection\FruitsCollection;
use App\Service\Collection\VegetablesCollection;
use App\Service\Collection\Item;
use App\Service\StorageService;
use PHPUnit\Framework\TestCase;

class StorageServiceTest extends TestCase
{
    public function testProcessRequestWithFruits(): void
    {
        $requestJson = '[{"id":2,"name":"Apples","type":"fruit","quantity":20,"unit":"kg"}]';

        $fruitCollectionMock = $this->createMock(FruitsCollection::class);
        $vegetableCollectionMock = $this->createMock(VegetablesCollection::class);

        // Assertions to check if the item is added to the fruits collection only
        $fruitCollectionMock->expects($this->once())->method('add');
        $vegetableCollectionMock->expects($this->never())->method('add');

        $storageService = new StorageService($fruitCollectionMock, $vegetableCollectionMock);
        $storageService->processRequest($requestJson);

    }

    public function testProcessRequestWithVegetables(): void
    {
        $requestJson = '[{"id":1,"name":"Carrot","type":"vegetable","quantity":10922,"unit":"g"}]';

        $fruitCollectionMock = $this->createMock(FruitsCollection::class);
        $vegetableCollectionMock = $this->createMock(VegetablesCollection::class);

        // Assertions to check if the item is added to the vegetable collection only
        $vegetableCollectionMock->expects($this->once())->method('add');
        $fruitCollectionMock->expects($this->never())->method('add');

        $storageService = new StorageService($fruitCollectionMock, $vegetableCollectionMock);
        $storageService->processRequest($requestJson);

    }

    public function testProcessRequestWithKilogramsConversion(): void
    {
        $requestJson = '[{"id":3,"name":"Bananas","type":"fruit","quantity":2,"unit":"kg"}]';

        $fruitCollectionMock = new FruitsCollection();
        $vegetableCollectionMock = new VegetablesCollection();

        $storageService = new StorageService($fruitCollectionMock, $vegetableCollectionMock);
        $storageService->processRequest($requestJson);

        // Assertions to check if the item is added to the fruit collection after conversion
        $fruitsCollection = $storageService->getFruitsCollection()->list();
        
        $actualItem = $fruitsCollection[0];
        $this->assertEquals('Bananas', $actualItem->getName());
        $this->assertEquals(2000, $actualItem->getQuantity());

        $this->assertEquals([], $storageService->getVegetablesCollection()->list());
    }

    public function testProcessRequestWithActualFile(): void
    {
        // Read the content of the actual request.json file
        $requestJson = file_get_contents('request.json');

        // Mock your dependencies
        $fruitCollectionMock = new FruitsCollection();
        $vegetableCollectionMock = new VegetablesCollection();

        // Create an instance of StorageService
        $storageService = new StorageService($fruitCollectionMock, $vegetableCollectionMock);

        // Call the method to be tested
        $storageService->processRequest($requestJson);

        // Assertions to check if the items are added correctly
        $fruitsCollection = $storageService->getFruitsCollection()->list();
        $vegetablesCollection = $storageService->getVegetablesCollection()->list();

        // Assert that each collection has a count greater than 1
        $this->assertGreaterThan(1, count($fruitsCollection), 'Fruits collection should have a count greater than 1');
        $this->assertGreaterThan(1, count($vegetablesCollection), 'Vegetables collection should have a count greater than 1');
    }
}