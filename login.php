<?php
include('connexion/connexion.php');
if (isset($_GET['Admin'])) {
    $fonction = "Admin";
    $_SESSION['User'] = $fonction;
} elseif (isset($_GET['ceo'])) {
    $fonction = "ceo";
    $_SESSION['User'] = $fonction;
} elseif (isset($_GET['Agent'])) {
    $fonction = "Agent";
    $_SESSION['User'] = $fonction;
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Connexion | Eka_Consulting</title>

  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- Icônes Bootstrap -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-50 to-blue-100 font-sans">

  <!-- Formulaire de connexion -->
  <form method="POST" action="models/login.php"
    class="bg-white shadow-xl rounded-lg w-full max-w-md p-8 relative transition-transform transform hover:scale-105 duration-300">

    <!-- Bouton retour -->
    <a href="index.php" class="absolute top-4 right-4 text-gray-400 hover:text-red-500 transition">
      <i class="bi bi-x-circle text-2xl"></i>
    </a>

    <!-- Logo -->
    <div class="flex justify-center mb-4">
      <img src="assets/img/logo/EKA_logo.png" alt="EKA Logo" class="h-20 w-auto object-contain transition-transform transform hover:scale-110 duration-300">
    </div>

    <!-- Titre -->
    <h2 class="text-3xl font-semibold text-center text-blue-700 mb-6">Connexion</h2>

    <!-- Email -->
    <div class="mb-4">
      <label class="block text-gray-600 mb-2">Adresse e-mail</label>
      <input type="text" name="username" placeholder="exemple@eka.com"
        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:outline-none transition duration-200 ease-in-out">
    </div>

    <!-- Mot de passe -->
    <div class="mb-4">
      <label class="block text-gray-600 mb-2">Mot de passe</label>
      <input type="password" name="password" placeholder="•••••••"
        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:outline-none transition duration-200 ease-in-out">
    </div>

    <!-- Message d'erreur -->
    <?php if (isset($_SESSION['msg']) && !empty($_SESSION['msg'])) { ?>
      <div class="mb-4 p-3 rounded-lg bg-red-100 text-red-700 text-center">
        <?= $_SESSION['msg'] ?>
      </div>
    <?php }
    unset($_SESSION['msg']); ?>

    <!-- Bouton -->
    <div class="mb-4">
      <input type="submit" name="connect" value="Se connecter"
        class="w-full bg-blue-700 text-white py-3 rounded-lg hover:bg-orange-500 transition duration-200 ease-in-out">
    </div>

    <!-- Options -->
    <div class="flex items-center justify-between text-sm text-gray-600">
      <label class="flex items-center gap-2">
        <input type="checkbox" class="w-4 h-4 border rounded focus:ring-2 focus:ring-orange-500"> Se souvenir de moi
      </label>
      <!-- <a href="#" class="text-blue-600 hover:underline">Mot de passe oublié ?</a> -->
    </div>
  </form>

  <!-- Footer -->
  <div class="absolute bottom-4 text-center text-gray-500 text-sm">
    &copy; <?= date("Y") ?> Eka_Consulting — Tous droits réservés
  </div>

</body>

</html>