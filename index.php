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
        echo "</head>\n<body>\n"; 
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
    <div class="container" style = "position: relative">
        <div class="logo-container">
            <h1>Drenica GunShop</h1>
            <img src="drenica.jpg" alt="Drenica GunShop Logo" class="logo">
        </div>
        <nav class="nav" style = "position: absolute; right: 20px">
            <a href="index.php" style = "color: orange">Home</a>
            <a href="products.php">Products</a>
            <a href="About-Us.html">About Us</a>
            <a href="Contact-Us.html">Contact</a>
            <a href="Krijimi i Login-form.php">Login <img src="login1.png" style="height: 20px; position: relative; top: 5px; left: 2px"></a>
        </nav>

        <div style="position: relative;">
                <div class="page-container">
                    <div class="sidebar">
                 <a href="products.php">Products</a>
            <a href="About-Us.html">About Us</a>
            <a href="Contact-Us.html">Contact</a>
            <a href="Krijimi i Login-form.php">Login <img src="login1.png" style="height: 20px;  position: relative;  top: 5px; left: 2px"></a>
                    </div>
                </div>
            <span class="list" style="margin-left: 40px;">MORE</span>
        </div>
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
    const images = [
        "backgournd.jpg",
        "background2.jpg",
        "background3.jpg"
    ]; 

    let index = 0;
    function changeBackground() {
        document.body.style.backgroundImage = `url(${images[index]})`;
        index = (index + 1) % images.length; 
    }

    setInterval(changeBackground, 5000); 
    changeBackground();

      const list = document.querySelector(".list");
        const sidebar = document.querySelector(".sidebar");
        let i = 0;

        list.addEventListener('click', function () {
            sidebar.classList.toggle("sidebar-special");
            if(i == 0){
                list.innerHTML = 'LESS';
                i++;
            }else {
                list.innerHTML = 'MORE';
                i = 0;
            }
        });
</script>

<style>
   
    

   .sidebar {
    position: absolute;
    right: 50px;
    width: 200px;
    background-color: rgb(0, 0, 0);
    padding: 20px 15px;
    overflow: visible;
    font-family: "Poppins", Arial, sans-serif;
    z-index: 999;
    visibility: hidden;
    opacity: 0;
    transform: translateX(120px);
    transition: visibility 0s, opacity 0.3s ease, transform 0.3s ease;
}


.sidebar a {
    display: block;
    color: rgb(255,255,255);
    text-decoration: none;
    padding: 10px 16px;
    margin: 6px 0;
    border-radius: 4px;
    font-size: 16px;
    font-weight: 500;
    transition: all 0.3s ease;
}

.sidebar a.active {
    color: #007aff;
    font-weight: bold;
    border-left: 4px solid #007aff;
    padding-left: 18px;
    background-color: #eef6ff;
}

.sidebar a:hover {
    background-color: #eef6ff;
    color: #007aff;
    transform: scale(1.02);
}


.sidebar-special {
    visibility: visible !important;
    opacity: 1;
    transform: translateX(0px);
}

.list {
    cursor: pointer;
    display: none;
}
.lista-navbar {
    align-self: center;
}

html,body {
    overflow-x: hidden; 
    width: 100%;
    background: center;
}




@media (max-width: 768px) {
    .header {
        flex-direction: column;
        text-align: center;
        padding: 1rem 0.5rem;
    }

    .nav {
        flex-direction: column;
        gap: 5px;
       min-width: 100% !important;
    }

    .logo {
        height: 50px;
    }

    .list {
        display: inline;
    }

    header .nav {
        display: none !important;
    }
}

</style>


<?php
$page->renderFooter();
?>
