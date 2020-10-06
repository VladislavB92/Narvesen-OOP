<?php

declare(strict_types=1);

require_once 'Sellers/Store.php';
require_once 'Sellers/Product.php';
require_once 'Sellers/CurrencyFormater.php';
require_once 'Customers/Client.php';
require_once 'Customers/Bag.php';
require_once 'Customers/BagsContent.php';

$narvesen = new Store('Narvesen Krasta');
$narvesen->add(new Product('Snikers', 69, 70));
$narvesen->add(new Product('Orbit', 49, 30));
$narvesen->add(new Product('Malboro', 359, 60));
$narvesen->add(new Product("Frankfurt's hotdog", 159, 20));
$narvesen->add(new Product("Caffe Latte S", 179, 100));
$narvesen->add(new Product("E-Talons", 125, 100));
$narvesen->add(new Product("Coca-Cola 0.5l", 79, 20));

$client = new Client('Voldemars');
// Add clients funds manualy in the 'Wallet.txt'.

$voldemarsBag = new Bag();

$productsAtNarvesen = $narvesen->all();

echo "\nClerk: Greetings, sir!\n";

sleep(1);
echo "\nClient: Hello! I have only €" .
    CurrencyFormater::formatToDecimal($client->getClientsFunds()) .
    ". What can you offer?\n";
sleep(1);

echo "\nClerk: Today at " .
    $narvesen->displayStoreName() . "..." . PHP_EOL;

while ($client->getClientsFunds() > 0) {

    $productId = "";
    $buyAgain = "";
    $amount = 0;
    $itemSold = false;

    echo "\nClerk: We still have following " .
        $narvesen->countProductTypes() . " items: \n";
    echo $narvesen->displaySortiment();

    echo "\nClerk: Would you like to buy something, sir?\n";

    while (array_key_exists($productId, $productsAtNarvesen) === false) {

        $productId = readline(
            "\nClerk: Tell me the number of the product's ID from the list: "
        );

        if (array_key_exists($productId, $productsAtNarvesen)) {
            echo "\nClient: " .
                $productsAtNarvesen[$productId]->getName() .
                ", please.\n";
        } else {
            echo "\nClerk: That might be the wrong ID number...";
            echo "\nChoose something else.\n";
        }
    }

    while ($amount < 1) {

        $amount = intval(readline(
            "\nClerk: How much you would like of those? "
        ));

        while ($amount < 1) {

            echo "\nClient: $amount, please.\n";

            if ($amount === 0) {
                echo "\nClerk: Umm... What?!\n";
                $amount = intval(readline(
                    "\nClerk: Once again... How much you would like of those? "
                ));
            }
        }

        if ($amount <= $productsAtNarvesen[$productId]->getStockAmount()) {

            echo "\nClerk: Here you go, $amount " .
                $narvesen->sellProduct(
                    $productsAtNarvesen[$productId],
                    $amount
                ) . " for you, sir!\n";

            $client->buyProduct(
                $productsAtNarvesen[$productId]->getName(),
                $productsAtNarvesen[$productId]->getPricePerUnit(),
                $amount
            );

            $voldemarsBag->putProductInBag(
                $productsAtNarvesen[$productId]->getName(),
                $amount
            );

            $itemSold = true;
        } else {
            echo "\n" . $narvesen->sellProduct(
                $productsAtNarvesen[$productId],
                $amount
            );
        }
    }

    if ($itemSold === true) {

        echo "\nClient: Now I have €" .
            CurrencyFormater::formatToDecimal($client->getClientsFunds()) .
            " left and " . BagsContent::showBagsContent(
                $voldemarsBag->getBag()
            ) . " in my bag. Nice!\n";;
    }

    while ($buyAgain !== "y" || $buyAgain !== "n") {

        $buyAgain = readline("\nClerk: Anything else? (y/n) ");
        if ($buyAgain === "y") {
            echo "\nClient: Yes, what else do you have?\n";

            break;
        } elseif ($buyAgain === "n") {
            echo "\nClient: No, that'll be enough. Thanks! Bye!\n";
            exit("\nClerk: Bye! Hope to see you soon again!\n");
        } else {
            echo "\nClerk: Sorry, what?\n";
        }
    }
}
