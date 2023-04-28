<?php

class ConsoleApp
{
    public static function command(string $filename, string $action, $arg1 = null, $arg2 = null, $arg3 = null) {

        switch ($action) {
            case 'calculate':
                self::calculate($filename);
                break;
            case 'add_product':
                self::addProduct($filename, $arg1, $arg2);
                break;
            case 'edit_product':
                self::editProduct($filename, $arg1, $arg2, $arg3);
                break;
            case 'delete_product':
                self::deleteProduct($filename, $arg1);
                break;
            default:
                echo 'Unknown action';
        }
    }

    private static function calculate(string $filename): void {
        $productList = self::getProductsFromFile($filename);

        $amount = 0;
        foreach($productList as $product) {
            $amount += $product->getAmount();
        }
        echo "Total product amount: $amount\n";
    }

    private static function addProduct(string $filename, string $name, float $amount): void {
        $productList = self::getProductsFromFile($filename);

        $product = new Product();
        $product->setName($name);
        $product->setAmount($amount);

        $productList[] = $product;

        $newFileData = self::createFileData($productList);
        file_put_contents($filename, $newFileData);
        echo "Product $name added to list\n";
    }

    private static function editProduct(string $filename, string $oldName, string $newName, float $amount): void {
        $productList = self::getProductsFromFile($filename);

        foreach($productList as $product) {
            if ($product->getName() === $oldName) {
                $product->setName($newName);
                $product->setAmount($amount);
            }
        }

        $newFileData = self::createFileData($productList);
        file_put_contents($filename, $newFileData);
        echo "Product $oldName has been changed to $newName with amount $amount\n";
    }

    private static function deleteProduct(string $filename, string $name): void {
        $productList = self::getProductsFromFile($filename);

        foreach($productList as $key => $product) {
            if ($product->getName() === $name) {
                unset($productList[$key]);
            }
        }

        $newFileData = self::createFileData($productList);
        file_put_contents($filename, $newFileData);
        echo "Product $name has been removed from list\n";
    }

    private static function getProductsFromFile(string $filename): array {
        $fileContent = file_get_contents($filename);

        $products = [];
        $rows = explode("\n", $fileContent);
        foreach($rows as $row) {
            if ($row === '') {
                continue;
            }
            $rowInfo = explode(' - ', $row);
            $product = new Product();
            $product->setName($rowInfo[0]);
            $product->setAmount($rowInfo[1]);

            $products[] = $product;
        }

        return $products;
    }

    /**
     * @param \Product[] $products
     * @return string
     */
    private static function createFileData(array $products): string {
        $response = "";
        foreach($products as $product) {
            $response .= $product->getName() . " - " . $product->getAmount() . "\n";
        }
        return $response;
    }
}