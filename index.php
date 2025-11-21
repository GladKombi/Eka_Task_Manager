<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Eka_Consulting</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Tailwind CSS CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

</head>

<body class="bg-gradient-to-br from-blue-50 to-blue-100 min-h-screen flex items-center justify-center font-sans">

  <main class="w-full max-w-4xl p-6">
    <div class="bg-white shadow-2xl rounded-2xl p-8">
      <!-- Titre -->
      <h1 class="text-center text-2xl md:text-3xl font-bold text-blue-700 mb-6">
        Bienvenue sur l'application de <span class="text-orange-500">Eka_Consulting</span>
      </h1>

      <!-- Logo -->
      <div class="flex justify-center mb-6">
        <img src="assets/img/logo/EKA_logo.png" alt="EKA Logo" class="h-32 object-contain">
      </div>

      <!-- Choix des fonctions -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <a href="login.php?Admin"
          class="group bg-blue-50 hover:bg-orange-500 text-blue-700 hover:text-white rounded-xl shadow-md p-6 flex flex-col items-center transition-all duration-300">
          <i class="bi bi-person-circle text-4xl mb-3 group-hover:scale-110 transform transition"></i>
          <h3 class="text-lg font-semibold">Admin</h3>
        </a>

        <a href="login.php?ceo"
          class="group bg-blue-50 hover:bg-orange-500 text-blue-700 hover:text-white rounded-xl shadow-md p-6 flex flex-col items-center transition-all duration-300">
          <i class="bi bi-briefcase-fill text-4xl mb-3 group-hover:scale-110 transform transition"></i>
          <h3 class="text-lg font-semibold">CEO</h3>
        </a>

        <a href="login.php?Agent"
          class="group bg-blue-50 hover:bg-orange-500 text-blue-700 hover:text-white rounded-xl shadow-md p-6 flex flex-col items-center transition-all duration-300">
          <i class="bi bi-people-fill text-4xl mb-3 group-hover:scale-110 transform transition"></i>
          <h3 class="text-lg font-semibold">Agents</h3>
        </a>
      </div>

      <!-- Note explicative -->
      <p class="text-center text-gray-600">
        Avant d’accéder au système, veuillez <span class="font-semibold text-blue-700">spécifier votre fonction</span>.
        <br>
        Cela nous permettra de vous identifier correctement.
      </p>
    </div>
  </main>

</body>
</html>
