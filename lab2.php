<?php
class Book {
    public $title;
    protected $author;
    private $price;

    public function __construct($title, $author, $price) {
        $this->title = $title;
        $this->author = $author;
        $this->price = $price;
    }

    public function getDetails() {

        return "Title: $this->title, Author: $this->author, Price: $" . number_format($this->price, 2);
    }

    protected function setPrice($price) {
        $this->price = $price;
    }

    public function __call($method, $arguments) {

        if ($method === 'updateStock') {
            echo "Stock updated for '$this->title' with arguments: " . implode(', ', $arguments) . "\n";
        } elseif ($method === 'setPrice') {
            $this->setPrice($arguments[0]);
        } else {
            throw new BadMethodCallException("Method '$method' does not exist.");
        }
    }
}

class Library {
    private $books = [];
    public $name;

    public function __construct($name) {
        $this->name = $name;
    }

    public function addBook(Book $book) {
        $this->books[] = $book;
    }

    public function removeBook($title) {

        foreach ($this->books as $index => $book) {
            if ($book->title === $title) {
                unset($this->books[$index]);
                echo "Book '$title' removed from the library.\n";
                return;
            }
        }
        echo "Book '$title' not found in the library.\n";
    }

    public function listBooks() {
        echo "Books in the library:\n";
        foreach ($this->books as $book) {
            echo $book->getDetails() . "\n";
        }
    }

    public function __destruct() {
        $this->books = [];
        echo "The Library '$this->name' is now closed.\n";
    }
}
$book1 = new Book('The Great Gatsby', 'F. Scott Fitzgerald', 12.99);
$book2 = new Book('1984', 'George Orwell', 8.99);
$library = new Library('City Library');

$library->addBook($book1);
$library->addBook($book2);

$book1->setPrice(12.99);
$book1->updateStock(50);

$library->listBooks();
$library->removeBook('1984');

echo "Books in the library after removal:\n";
$library->listBooks();

unset($library);
?>