# Sequence 5 - Front office : les 2 pieces manquantes

Le reste de la sequence 5 (accueil, services, a propos, navigation,
responsive) etait deja fait en meme temps que l'architecture MVC.
Cette archive ajoute :

  1. Le TRAITEMENT du formulaire de prise de rendez-vous
     (jusqu'ici il s'affichait mais n'enregistrait rien)
  2. La page de DETAIL d'un article d'actualite

## 1. Extraire l'archive

    unzip -o front_office.zip -d ~/cabinet-dentaire

Fichiers remplaces / ajoutes :
  controllers/PageController.php   (remplace : traitement du RDV + detail article)
  views/front/rendezvous.php       (remplace : messages d'erreur et de succes)
  views/front/actualites.php       (remplace : extrait + lien "Lire l'article")
  views/front/actualite_detail.php (nouveau)
  public/index.php                 (remplace : ajoute la route ?page=actualite)

## 2. Ajouter le CSS

Colle le contenu de css_article.txt a la FIN de public/css/style.css.

## 3. Tester le parcours complet

    cd ~/cabinet-dentaire/public && php -S localhost:8000

  a) Va sur ?page=rendezvous et remplis le formulaire
  b) Tu dois voir le message vert de confirmation
  c) Connecte-toi au back office (?page=admin_connexion)
  d) Rubrique "Rendez-vous" : ta demande apparait en "en attente"
  e) Rubrique "Patients" : la fiche a ete creee automatiquement

  f) Va sur ?page=actualites et clique sur "Lire l'article"

## Tests d'erreur a essayer (pour la soutenance)

  - Une date passee            -> "La date choisie est deja passee."
  - Un dimanche                -> "Le cabinet est ferme le dimanche."
  - Un email invalide          -> "Adresse email invalide."
  - Le MEME email deux fois    -> une seule fiche patient, deux rendez-vous
  - ?page=actualite&id=9999    -> page 404

## Le mecanisme trouver-ou-creer

Quand un patient prend rendez-vous :

    $patient = new Patient([...donnees du formulaire...]);
    $patient = $patientManager->trouverOuCreer($patient);
    // -> si l'email existe deja : on recupere la fiche existante
    // -> sinon : la fiche est creee
    // dans les deux cas, $patient->getId() est disponible

    $rdv = new RendezVous([... 'patient_id' => $patient->getId() ...]);
    $rdvManager->ajouter($rdv);

C'est ce qui evite les fiches en double quand un patient
reprend rendez-vous plusieurs fois.

## La double validation (a savoir expliquer)

Le formulaire a des attributs HTML (required, type="email", min).
C'est du confort pour l'utilisateur, mais ca se contourne facilement.

C'est pourquoi TOUT est revalide cote serveur dans le controleur :
champs obligatoires, format de l'email, service existant en base,
date dans le futur, jour d'ouverture du cabinet.

Regle a retenir : ne jamais faire confiance aux donnees envoyees
par le navigateur.
