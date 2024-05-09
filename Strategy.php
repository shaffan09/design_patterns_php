<?php

interface ArraySortingStrategy
{
    public function execute(array $arr): array;
}

class BubbleSort implements ArraySortingStrategy
{
    public function execute(array $arr): array
    {
        echo "Bubble Sort:\n";
        $n = count($arr);
        for ($i = 0; $i < $n - 1; $i++) {
            for ($j = 0; $j < $n - $i - 1; $j++) {
                if ($arr[$j] > $arr[$j + 1]) {
                    $temp = $arr[$j];
                    $arr[$j] = $arr[$j + 1];
                    $arr[$j + 1] = $temp;
                }
            }
        }

        return $arr;
    }
}

class DefaultSort implements ArraySortingStrategy
{
    public function execute(array $arr): array
    {
        echo "PHP Default Sort:\n";
        sort($arr);
        return $arr;
    }
}

class DefaultReverseSort implements ArraySortingStrategy
{
    public function execute(array $arr): array
    {
        echo "PHP Default Sort Reverse:\n";
        rsort($arr);
        return $arr;
    }
}

class Client
{
    protected ArraySortingStrategy $sortingStrategy;

    public function setSortingStrategy(ArraySortingStrategy $arraySortingStrategy)
    {
        $this->sortingStrategy = $arraySortingStrategy;
    }

    public function sortArray(array $arr)
    {
        $sortedArray = $this->sortingStrategy->execute($arr);
        foreach ($sortedArray as $item) {
            echo $item . "\n";
        }
    }
}

// test client code
$nums = [4, 6, 2, 10, 9, 1, -2, -8];

$bubbleSort = new BubbleSort();
$defaultSort = new DefaultSort();
$defaultReverseSort = new DefaultReverseSort();

$client = new Client();

$client->setSortingStrategy($bubbleSort);
$client->sortArray($nums);

echo "\n";

$client->setSortingStrategy($defaultSort);
$client->sortArray($nums);

echo "\n";

$client->setSortingStrategy($defaultReverseSort);
$client->sortArray($nums);
