class Translations {
  getMessage(message, language) {
    switch (message) {
      case "Email required." :
        return language === "fr" ? "Email requis." : message;
      case "Password required." :
        return language === "fr" ? "Mot de passe requis." : message;
      case "Confirmation required." :
        return language === "fr" ? "Confirmation requise." : message;
      case "Incorrect email or password." :
        return language === "fr" ? "Email ou mot de passe incorrect." : message;
      case "User logged in." :
        return language === "fr" ? "Utilisateur connecté." : message;
      case "Invalid email." :
        return language === "fr" ? "Email invalide." : message;
      case "Invalid password." :
        return language === "fr" ? "Mot de passe invalide." : message;
      case "Password and confirmation are different." :
        return language === "fr" ? "Le mot de passe et la confirmation sont différents." : message;
      case "Email already taken." :
        return language === "fr" ? "Email déjà enregistré." : message;
      case "User created." :
        return language === "fr" ? "Utilisateur crée." : message;
      case "Id required." :
        return language === "fr" ? "Id requis." : message;
      case "User not found." :
        return language === "fr" ? "Utilisateur non trouvé." : message;
      case "Invalid phone number." :
        return language === "fr" ? "Numéro de téléphone invalide." : message;
      case "Invalid image format." :
        return language === "fr" ? "Format d'image invalide." : message;
      case "User updated." :
        return language === "fr" ? "Utilisateur mis à jour." : message;
      case "User deleted." :
        return language === "fr" ? "Utilisateur supprimé." : message;
      case "Token required." :
        return language === "fr" ? "Token requis." : message;
      case "Email confirmed" :
        return language === "fr" ? "Email confirmé." : message;
      case "Password updated." :
        return language === "fr" ? "Mot de passe mis à jour." : message;
      case "Name required." :
        return language === "fr" ? "Nom requis." : message;
      case "Item created." :
        return language === "fr" ? "Objet créé." : message;
      case "Item not found." :
        return language === "fr" ? "Objet non trouvé." : message;
      case "Item updated." :
        return language === "fr" ? "Objet mis à jour." : message;
      case "Item deleted." :
        return language === "fr" ? "Objet supprimé." : message;
      default :
        return null;
    }
  }
}

export default Translations;
