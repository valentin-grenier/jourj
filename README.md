# Jour J - Système de cagnotte en ligne pour un mariage

Ce projet WordPress a pour objectif de faciliter la collecte de fonds pour un mariage en permettant aux mariés de présenter leurs idées de cadeaux et aux invités d’y participer facilement. Grâce à un thème sur-mesure et à plusieurs plugins dédiés, la plateforme offre une gestion complète des cadeaux (création, suivi des montants), des paiements sécurisés via PayPal et des notifications automatisées aux mariés.

## Roadmap

- [x] **V1 :** Création d’un site vitrine affichant la liste des cadeaux sans gestion de paiement.
- [x] **V1.1 :** Intégration de la liste des cadeaux sans gestion de paiement.
- [ ] **V2 :** Intégration du système de paiement via PayPal et automatisation du suivi des participations.


## Principales fonctionnalités

- **Gestion des cadeaux**  
  - Affichage d’une liste de cadeaux avec montant total et montant restant.  
  - Possibilité pour les invités de contribuer partiellement ou totalement à chaque cadeau.

- **Intégration de PayPal**  
  - Redirection automatique vers PayPal pour un paiement sécurisé.  
  - Réception et traitement des notifications IPN (Instant Payment Notification) pour confirmer le paiement du côté serveur.  
  - Retour automatique sur le site avec mise à jour en temps réel du montant restant.

- **Notifications automatisées**  
  - Envoi de courriels aux mariés dès qu’un paiement est confirmé.  
  - Configuration des messages et suivi des contributions via l’espace d’administration WordPress.

- **Gestion des utilisateurs**  
  - Attribution de rôles personnalisés (Invités et Mariés) pour simplifier l’accès et l’utilisation de la plateforme.  
  - Respect des contraintes RGPD avec suppression ou anonymisation des comptes une fois l’événement terminé.

## Workflow de paiement simplifié

1. L’invité sélectionne un cadeau dans la liste.  
2. Il indique le montant de sa contribution et est redirigé vers PayPal.  
3. Après paiement, PayPal notifie automatiquement la plateforme via IPN.  
4. Le montant restant du cadeau est mis à jour sur le site.  
5. Un courriel est envoyé aux mariés pour confirmer la participation.

Avec cette solution, l’organisation des cadeaux et la collecte des dons deviennent plus simples et sécurisées pour tous les participants.
