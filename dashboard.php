<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashbord</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="style.css"> 
</head>
<body> 
<input type="checkbox" id="menu-toggle">
<div class="sidebar">
    <div class="sidebar-brand">
        <h2><span class='bx bxs-dashboard'></span>Dashbord</h2>
    </div>
    <div class="sidebar-menu">
        <ul>
            <li>
                 <a href="index.php" ><span class="bx bxs-home"></span>
                    <span>Acceuil</span></a>
            </li>

            <li>
                <a href="details_clients.php" ><span class="bx bxs-user"></span>
                   <span>Utilisateurs</span></a>
           </li>
           
           <li>
            <a href="gestion_produits.php" ><span class="bx bxs-package"></span>
               <span>Produits</span></a>
       </li>

       <li>
        <a href="gestion_des_commandes.php"><span class="bx bx-task"></span>
           <span>Tâches</span></a>
      </li>

      <li>
        <a href="" ><span class="bx bxs-cog"></span>
           <span>Paramètre</span></a>
      </li>

      <li>
        <a href=""><span class="bx bxs-help-circle"></span>
           <span>Aide</span></a>
      </li>

      <li>
        <a href="logout.php" class="logout"><span class="bx bxs-log-out"></span>
           <span>Déconnexion</span></a>
      </li>
        </ul>
    </div>
</div>

<div class="main-content">
    <header>

            <h2>
            <div class="header-menu-icon">
        <span class="menu-toggle" onclick="toggleMenu()">☰</span>
    </div>
    <nav class="header-menu">
        <ul>
            <li><a href="index.php">Accueil</a></li>
            <li><a href="page_produits.php">Produits</a></li>
            <li><a href="#">Déconnexion</a></li>
        </ul>
    </nav>
            E-Equip
        </h2>

         <div class="search-wrapper">
            <i class='bx bx-search'></i>
            <input type="search" placeholder="Chercher ici" />
         </div>

          <div class="user-wrapper">
            <img src="images/homme.png" width="40px" height="40px" alt="">
          <div>
            <h4>Danic Walter</h4>
            <small>Super admin</small>
          </div>
        </div>

    </header>
    <main>

        <div class="main-service">
            <div class="card">
                <i class='bx bx-bar-chart-alt-2'></i>
                <h3>Gestion des produits</h3>
                <p>Modifier ou supprimer un produit ajouter</p>
                <a href="gestion_produits.php"><button>Consulter</button></a>
            </div>
            <div class="card">
                <i class='bx bxs-user-plus'></i>
                <h3>Inventaire des Clients</h3>
                <p>Clientel journalier,nouveaux clients</p>
                <a href="details_clients.php"><button>Consulter</button>
                </div></a>
            <div class="card">
                <i class='bx bx-line-chart'></i>
                <h3>Résumé des ventes</h3>
                <p>Chiffre d'affaire,nombre de commande</p>
                <a href="résumé_ventes.php"><button>Consulter</button></a>
            </div>
            <div class="card">
                <i class='bx bxs-shopping-bag-alt'></i>
                <h3>Gestion des commandes</h3>
                <p>Commande en attente, livrée</p>
                <a href="gestion_des_commandes.php"><button>Consulter</button></a>
            </div>
            <div class="card">
                <i class='bx bx-cycling'></i>
                <h3>Gestion des livraisons</h3>
                <p>Livraison à domicle,en cour</p>
                <a href="gestion_livraisons.php"><button>Consulter</button></a>
          </div>
          <div class="card">
            <i class='bx bx-plus'></i>
            <h3>Ajouter un produit</h3>
            <p>AJouté un nouveau produit</p>
            <a href="ajoutprod.php"><button>Ajouter</button></a>
    </div>
     
     

    </main>
</div>
<script>
    function toggleMenu() {
    const menu = document.querySelector('.header-menu');
    menu.classList.toggle('show');
}

</script>
</body>
</html>