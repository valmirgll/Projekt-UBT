<?php
class Page {
    private $title;
    private $stylesheets = [];
    private $scripts = [];
    
    public function __construct($title) {
        $this->title = $title;
    }
    
    public function addStylesheet($stylesheet) {
        $this->stylesheets[] = $stylesheet;
    }
    
    public function addScript($script) {
        $this->scripts[] = $script;
    }
    
    public function renderHeader() {
        echo "<!DOCTYPE html>\n<html lang='en'>\n<head>\n";
        echo "<meta charset='UTF-8'>\n<meta name='viewport' content='width=device-width, initial-scale=1.0'>\n";
        echo "<title>{$this->title}</title>\n";
        foreach ($this->stylesheets as $stylesheet) {
            echo "<link rel='stylesheet' href='{$stylesheet}'>\n";
        }
        echo "</head>\n<body style='background-image: url(backgournd.jpg);'>\n";
    }
    
    public function renderFooter() {
        echo "<footer class='footer'>\n";
        echo "<p>&copy; 2024 Drenica Gun Shop. All rights reserved.</p>\n";
        echo "<p>Contact us: <a href='mailto:info@drenicagunshop.com' style='color: orange;'>info@drenicagunshop.com</a> | (+383) 49 163040</p>\n";
        echo "</footer>\n";
        foreach ($this->scripts as $script) {
            echo "<script src='{$script}'></script>\n";
        }
        echo "</body>\n</html>";
    }
}

$page = new Page("Gun Shop");
$page->addStylesheet("projekti.css");
$page->renderHeader();
?>

<header class="header">
    <div class="container">
        <div class="logo-container">
            <h1>Drenica GunShop</h1>
            <img src="drenica.jpg" alt="Drenica GunShop Logo" class="logo">
        </div>
        <nav class="nav">
            <a href="Projekti.html">Home</a>
            <a href="Products.html">Products</a>
            <a href="About-Us.html">About Us</a>
            <a href="Contact-Us.html">Contact</a>
            <a href="Login-form.html">Login <img src="login1.png" style="height: 20px;"></a>
        </nav>
    </div>
</header>

<section id="home" class="hero">
    <div class="hero-content">
        <h2>Quality Firearms, Unmatched Service</h2>
        <p>Best shop for all firearm needs.</p>
        <p>Discover a variety of guns, shotguns, pistols & rifles from top brands like Sig Sauer, Beretta, Smith & Wesson & more. You must be +21 years old and have an available license to buy a gun from us. For more, come and visit our shop and you will have a great time.</p>
    </div>
</section>

<form class="search-form" action="Products.html">
    <input type="text" id="searchInput" name="query" placeholder="Search for products..." class="search-input">
    <button type="submit" class="btn">Search Products</button>
</form>

<script>
document.querySelector('.search-form').addEventListener('submit', function(e) {
    const searchInput = document.getElementById('searchInput').value.trim();
    if (!searchInput) {
        e.preventDefault();
        alert("Please enter a product name to search.");
    }
});
</script>

<?php
$page->renderFooter();
?>