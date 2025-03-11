<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-equip</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
</head>
<body>
<header>
    <input type="checkbox" id="menu-toggle" class="menu-toggle">
    <label for="menu-toggle" class="bx bx-menu menu-icon"></label>
    <div class="container">
        <div class="logo">
            <video autoplay muted loop id="logo-video">
                <source src="images/E-.mp4" type="video/mp4">
                Votre navigateur ne prend pas en charge la vidéo.
            </video>
            <h1>E-equip</h1>
        </div>
        <nav class="navmenu">
            <a href="#">Accueil</a>
            <a href="#a-propos">À propos</a>
            <div class="nav-item">
                <a href="#">Catégories</a>
                <ul class="dropdown">
                    <li><a href="page_categorie.php?categorie=ordinateur">Ordinateur</a></li>
                    <li><a href="page_categorie.php?categorie=telephone">Téléphone</a></li>
                    <li><a href="page_categorie.php?categorie=peripherique">Périphérique</a></li>
                    <li><a href="page_categorie.php?categorie=composant">Composant PC</a></li>
                </ul>
            </div>
            <a href="contact.php">Contacts</a>
        </nav>
        <div class="nav-icons">
            <a href="login.php"><i class='bx bx-user-circle'></i></a>
            <a href="mes_commandes.php"><i class='bx bx-cart'></i></a>
        </div>
    </div>
</header>

<main>
    <div class="welcome-section">
        <div class="welcome-content">
            <div>
                <h1>Bienvenue sur E-equip !</h1>
                <p>Nous sommes ravis de vous voir ici. Explorez notre site pour découvrir nos produits et services.</p>
                <a href="#produit" class="btn">Acheter maintenant</a>
            </div>
        </div>
    </div>
</main>
<section class="icon-container">
    <div class="icon">
        <img src="images/image13.png" alt="">
        <div class="info">
            <h3>Livraison gratuite</h3>
            <span> sur toutes les commandes</span>
        </div>
    </div>

    <div class="icon">
        <img src="images/image16.png" alt="">
        <div class="info">
            <h3>10 jours de retours</h3>
            <span> garantie de remboursement</span>
        </div>
    </div>

    <div class="icon">
        <img src="images/image15.png" alt="">
        <div class="info">
            <h3>Offre et cadeau</h3>
            <span> sur toutes les commandes</span>
        </div>
    </div>
    
    <div class="icon">
        <img src="images/image17.png" alt="">
        <div class="info">
            <h3>Paiement à la livraison</h3>
            <span>cash ou virtuelle</span>
        </div>
    </div>
</section>

<section class="categories-section" id="produit">
        <h2>Catégories de Produits</h2>
        <div class="categories-container">
            <!--a href="page_categorie.php?categorie=gaming">
            <div class="category-card">
                <img src="images/gaming.png" alt="Gaming">
                <h3>Gaming</h3>
            </div>
            </a-->
            <a href="page_categorie.php?categorie=ordinateur">
                <div class="category-card">
                    <img src="images/ordinateur_pc.png" alt="Ordinateur">
                    <h3>Ordinateur</h3>
                </div>
            </a>
            <a href="page_categorie.php?categorie=telephone">
            <div class="category-card">
                <img src="images/telephone.jpg" alt="Téléphone">
                <h3>Téléphone</h3>
            </div>
            </a>
            <a href="page_categorie.php?categorie=peripherique">
            <div class="category-card">
                <img src="images/périphérique.png" alt="Périphérique">
                <h3>Périphérique</h3>
            </div>
            </a>
            <a href="page_categorie.php?categorie=composant">
            <div class="category-card">
                <img src="images/composant.png" alt="composant">
                <h3>Composant</h3>
            </div>
            </a>
            
        </div>
    </section>
<!--about section-->
<section class="a-propos" id="a-propos">
      <h2 class="rubrique" > A propos de nous</h2> 
    
    <div class="row">
       
       <div class="image-container" >
        <img src="images/backg.jpg" alt="">
        <h3>Meilleurs qualités</h3>
       </div>

       <div class="content">
            <h3>Pourquoi choisir E-equip?</h3>
            <p>Chez E-equip, nous sommes passionnés par les technologies informatiques et nous nous engageons à vous offrir les meilleurs équipements pour répondre à vos besoins. Que vous soyez un gamer exigeant, un professionnel en quête de performance ou simplement à la recherche de périphériques fiables, nous avons ce qu'il vous faut.</p>
            <p>Notre équipe sélectionne avec soin des produits de qualité supérieure pour garantir une expérience utilisateur optimale. Avec un service client dédié, une livraison rapide et des conseils personnalisés, nous faisons tout pour vous satisfaire. Découvrez notre large gamme de produits et trouvez la solution qui correspond parfaitement à vos attentes.</p>
            <a href="#produit" class="main-btn">Découvrir nos produits</a>
        </div>
    </div>
</section>

<section class="product-list best-sellers">
    <h2>Meilleures Ventes</h2>
    <div class="product-grid">
    <div class="produit-container">
        <a href="produit_détail.php?produit_id=18"> <!-- Remplacez 1 par l'ID réel du produit -->
        <div class="product-item">
                <img src="images/assecoire.jpg" alt="Produit 1">
                <div class="discount">
                    <i class="fa-regular fa-star"></i>
                    <i class="fa-regular fa-star"></i>
                    <i class="fa-regular fa-star"></i>
                </div>
                <div class="product-icons">
                    <i class="fas fa-heart"></i>
                    <i class="fas fa-shopping-cart"></i>
                </div>
            </div>
        </a>
            <div class="produit-info">
               <br> <center><h3>Kit combiné</h3></center>
            </div>
        </div>

       <div class="produit-container">
        <a href="produit_détail.php?produit_id=6">
        <div class="product-item">
                <img src="images/ordi/macbook.jpg" alt="Produit 1">
                <div class="discount">
                    <i class="fa-regular fa-star"></i>
                    <i class="fa-regular fa-star"></i>
                    <i class="fa-regular fa-star"></i>
                </div>
                <div class="product-icons">
                    <i class="fas fa-heart"></i>
                    <i class="fas fa-shopping-cart"></i>
                </div>
            </div>
        </a>
            <div class="produit-info">
               <br> <center><h3>Apple MacBook Air M3 15 pouces</h3></center>
            </div>
        </div>
       <div class="produit-container">
        <a href="produit_détail.php?produit_id=19">
        <div class="product-item">
                <img src="images/tel/15Pro.jpg" alt="Produit 1">
                <div class="discount">
                    <i class="fa-regular fa-star"></i>
                    <i class="fa-regular fa-star"></i>
                    <i class="fa-regular fa-star"></i>
                </div>
                <div class="product-icons">
                    <i class="fas fa-heart"></i>
                    <i class="fas fa-shopping-cart"></i>
                </div>
            </div>
        </a>
            <div class="produit-info">
               <br> <center><h3>Apple iPhone 15 Pro</h3></center>
            </div>
        </div>
       <div class="produit-container">
        <a href="produit_détail.php?produit_id=3">
        <div class="product-item">
                <img src="images/peri/souris.jpg" alt="Produit 1">
                <div class="discount">
                    <i class="fa-regular fa-star"></i>
                    <i class="fa-regular fa-star"></i>
                    <i class="fa-regular fa-star"></i>
                </div>
                <div class="product-icons">
                    <i class="fas fa-heart"></i>
                    <i class="fas fa-shopping-cart"></i>
                </div>
            </div>
        </a>
            <div class="produit-info">
               <br> <center><h3>Razer DeathAdder Essent(Souris Gamer)</h3></center>
            </div>
        </div>
        <!-- Ajouter plus de produits ici -->
    </div>
</section>

<section class="product-list available-products">
    <h2>Nouveautés</h2>
    <div class="product-grid">
        <div class="produit-container">
           <a href="produit_détail.php?produit_id=8">
                <div class="product-item">
                <img src="images/ordi/pc.jpg" alt="Produit 3">
                <div class="discount">-20%</div>
                </div>
           </a>
           <div class="produit-info">
               <br> <center><h3> Backstab - PC Gamer</h3></center>
           </div>
        </div>
 
        <div class="produit-container">
           <a href="produit_détail.php?produit_id=10">
                <div class="product-item">
                <img src="images/1724250232-poco.jpg" alt="Produit 3">
                <div class="discount">-10%</div>
                </div>
           </a>
           <div class="produit-info">
               <br> <center><h3>Poco C65</h3></center>
           </div>
        </div>
        <div class="produit-container">
           <a href="produit_détail.php?produit_id=17">
                <div class="product-item">
                <img src="images/compo/server qnap.jpg" alt="Produit 3">
                <div class="discount">-7.4%</div>
                </div>
           </a>
           <div class="produit-info">
               <br> <center><h3>QNAP NAS TS-433_boitier</h3></center>
           </div>
        </div>
        <div class="produit-container">
           <a href="produit_détail.php?produit_id=1">
                <div class="product-item">
                <img src="images/1724079123-msi_optix.jpg" alt="Produit 3">
                <div class="discount">-50%</div>
                </div>
           </a>
           <div class="produit-info">
               <br> <center><h3>MSI Optix</h3></center>
           </div>
        </div>
        <!-- Ajouter plus de produits ici -->
    </div>
</section>

<!-- section avis-->
<section class="revue" id="revue">
<h1 class="rubrique">Avis de quelques clients</h1>

<div class="box-container">

<div class="box">
    <div class="stars">
        <i class='bx bxs-star'></i>
        <i class='bx bxs-star'></i>
        <i class='bx bxs-star'></i>
        <i class='bx bxs-star'></i>
        <i class='bx bxs-star-half' ></i>
    </div>
    <p>"Je suis vraiment contente de mon achat chez E-equip ! La commande a été traitée rapidement et l'expédition a été efficace. Le produit correspond parfaitement à la description et fonctionne très bien. Je recommande vivement ce site pour sa fiabilité et ses bons produits !"</p>
     <div class="user">
        <img src="images/avis1.jpg" alt="">
        <div class="user-info">
            <h3>Amen</h3>
            <span>client satsfait</span>
        </div>
     </div>
     <span class='bx bxs-quote-right' ></span>
</div>


<div class="box">
    <div class="stars">
        <i class='bx bxs-star'></i>
        <i class='bx bxs-star'></i>
        <i class='bx bxs-star'></i>
        <i class='bx bxs-star'></i>
        <i class='bx bxs-star' ></i>
    </div>
    <p>"Je suis extrêmement ravie de mon expérience avec E-equip ! Non seulement la livraison a été super rapide, mais la qualité des produits est exceptionnelle. Ce qui m'a vraiment impressionnée, c'est l'attention portée au service client : ils ont répondu à toutes mes questions avec professionnalisme et gentillesse!"</p>
     <div class="user">
        <img src="images/avis2.jpg" alt="">
        <div class="user-info">
            <h3>Dave</h3>
            <span>client très satsfait</span>
        </div>
     </div>
     <span class='bx bxs-quote-right' ></span>
</div>


<div class="box">
    <div class="stars">
        <i class='bx bxs-star'></i>
        <i class='bx bxs-star'></i>
        <i class='bx bxs-star'></i>
        <i class='bx bxs-star'></i>
        <i class='bx bx-star'></i>
    </div>
    <p>"J'ai acheté un ordinateur portable sur E-equip et je suis très satisfait du service. Le produit est arrivé dans les délais annoncés et en parfait état. Le suivi de la commande était clair et précis. Bon rapport qualité/prix et service client réactif. Je reviendrai pour d'autres achats."</p>
     <div class="user">
        <img src="images/avis5.jpg" alt="">
        <div class="user-info">
            <h3>Fred</h3>
            <span>client satsfait</span>
        </div>
     </div>
     <span class='bx bxs-quote-right' ></span>
</div>

</div>
</section>


<footer>
    <div class="footer-container">
        <div class="footer-top">
            <div class="footer-section logo-section">
                <div class="logo">
                    <video autoplay muted loop id="logo-video">
                        <source src="images/E-.mp4" type="video/mp4">
                        Votre navigateur ne prend pas en charge la vidéo.
                    </video>
                    <h1>E-equip</h1>
                </div>
            </div>
            <div class="footer-section">
                <h3>Liens Pratiques</h3>
                <ul>
                    <li><a href="">Points de Fidélité</a></li>
                    <li><a href="">Mentions légales</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h3>À propos</h3>
                <ul>
                    <li><a href="">SAV</a></li>
                    <li><a href="">Services Clients</a></li>
                    <li><a href="">Livraison et Retours</a></li>
                </ul>
            </div>
            <div class="footer-section newsletter-section">
                <h3>Newsletter</h3>
                <p>Découvrez en Avant Première Nos Tendances !</p>
                <input type="email" placeholder="Saisissez votre e-mail">
                <button>Transmettre</button>
            </div>
        </div>
        <div class="footer-bottom">
            <p>Suivez-nous</p>
            <div class="social-icons">
                <a href="#" aria-label="Facebook" class="social-icon fa-brands fa-facebook"></a>
                <a href="#" aria-label="Twitter" class="social-icon fa-brands fa-twitter"></a>
                <a href="#" aria-label="Instagram" class="social-icon fa-brands fa-instagram"></a>
            </div>
            <p>&copy; 2024 E-equip. Tous droits réservés.</p>
        </div>
    </div>
</footer>
</body>
</html>
