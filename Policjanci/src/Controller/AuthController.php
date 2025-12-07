<?php

namespace App\Controller;

use App\Service\Database; // <--- To jest kluczowe, żeby widział Twoją klasę bazy
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;

class AuthController extends AbstractController
{
    #[Route('/login', name: 'app_login')]
    public function login(Request $request, Database $db, SessionInterface $session): Response
    {
        // 1. Jeśli użytkownik jest już zalogowany, wyrzuć go na stronę główną
        if ($session->get('user_id')) {
            return $this->redirectToRoute('app_home');
        }

        // 2. Obsługa wysłania formularza (POST)
        if ($request->isMethod('POST')) {
            $username = $request->request->get('username');
            $password = $request->request->get('password');

            // 3. Pobieramy użytkownika z bazy (LIMIT 1 dla optymalizacji)
            // Używamy tablicy [$username] dla bezpieczeństwa przed SQL Injection
            $result = $db->query("SELECT * FROM users WHERE username = ? LIMIT 1", [$username]);
            $user = $result[0] ?? null;

            // 4. Weryfikacja hasła (porównanie wpisanego z hashem w bazie)
            if ($user && password_verify($password, $user['password'])) {

                // Sukces: Zapisujemy dane w sesji
                $session->set('user_id', $user['id']);
                $session->set('username', $user['username']);

                // Dekodujemy role z JSON-a (np. '["ROLE_ADMIN"]') na tablicę PHP
                $roles = json_decode($user['roles'], true);
                $session->set('roles', $roles);

                $this->addFlash('success', 'Zalogowano pomyślnie!');
                return $this->redirectToRoute('app_home');
            } else {
                // Porażka
                $this->addFlash('error', 'Nieprawidłowy login lub hasło.');
            }
        }

        // 5. Wyświetlenie widoku logowania (GET)
        return $this->render('auth/login.html.twig');
    }

    #[Route('/logout', name: 'app_logout')]
    public function logout(SessionInterface $session): Response
    {
        // Czyszczenie sesji = wylogowanie
        $session->clear();
        return $this->redirectToRoute('app_home');
    }
}
