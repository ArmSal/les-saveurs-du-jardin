<?php
// tests/Controller/ContactControllerTest.php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Test fonctionnel pour valider le formulaire de contact.
 * Ce test s'inscrit dans la démarche DevOps d'assurance qualité (CI/CD).
 */
class ContactControllerTest extends WebTestCase
{
    public function testContactFormSubmission(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/contact');

        // Vérifier que la page se charge correctement (Status 200)
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Contact'); // Supposant un <h1> ou titre spécifique

        // Sélectionner le formulaire
        // On cherche le bouton submit qui a la classe btn-primary (défini dans ContactType)
        $form = $crawler->selectButton('Envoyer')->form();

        // Remplir le formulaire avec des données valides
        $form['contact[name]'] = 'Test User';
        $form['contact[email]'] = 'test@example.com';
        $form['contact[message]'] = 'Ceci est un message de test pour valider l\'environnement.';

        // Soumettre le formulaire
        $client->submit($form);

        // Vérifier la redirection (302) suite au succès formulé dans le contrôleur
        $this->assertResponseRedirects('/contact');

        // Suivre la redirection
        $client->followRedirect();

        // Vérifier la présence du message Flash de succès
        $this->assertSelectorExists('.alert-success');
        $this->assertSelectorTextContains('.alert-success', 'Votre message a été envoyé avec succès');
    }

    public function testInvalidFormSubmission(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/contact');

        $form = $crawler->selectButton('Envoyer')->form();

        // Remplir avec des données invalides (message trop court)
        $form['contact[name]'] = 'J';
        $form['contact[email]'] = 'invalid-email';
        $form['contact[message]'] = 'Short';

        $client->submit($form);

        // La soumission invalide renvoie la page avec les erreurs
        $this->assertResponseIsSuccessful();
        
        // Vérifier que le message d'erreur est présent dans la page
        $this->assertSelectorTextContains('body', 'au moins 2');
    }
}
