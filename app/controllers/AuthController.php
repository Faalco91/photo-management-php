<?php
class AuthController extends Controller {
    private $userModel;

    public function __construct() {
        $this->userModel = $this->model('User');
    }

    public function register() {
        // Si c'est une soumission de formulaire
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Activer le debug
            error_log('Données POST reçues : ' . print_r($_POST, true));

            // Récupérer les données du formulaire
            $data = [
                'username' => trim($_POST['username']),
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'confirm_password' => trim($_POST['confirm_password']),
                'username_err' => '',
                'email_err' => '',
                'password_err' => '',
                'confirm_password_err' => ''
            ];

            // Validation
            if(empty($data['username'])) {
                $data['username_err'] = 'Veuillez entrer un nom d\'utilisateur';
            }

            if(empty($data['email'])) {
                $data['email_err'] = 'Veuillez entrer un email';
            } elseif($this->userModel->findUserByEmail($data['email'])) {
                $data['email_err'] = 'Email déjà utilisé';
            }

            if(empty($data['password'])) {
                $data['password_err'] = 'Veuillez entrer un mot de passe';
            } elseif(strlen($data['password']) < 6) {
                $data['password_err'] = 'Le mot de passe doit faire au moins 6 caractères';
            }

            if(empty($data['confirm_password'])) {
                $data['confirm_password_err'] = 'Veuillez confirmer le mot de passe';
            } elseif($data['password'] != $data['confirm_password']) {
                $data['confirm_password_err'] = 'Les mots de passe ne correspondent pas';
            }

            // Debug des erreurs
            error_log('Erreurs de validation : ' . print_r(array_filter($data, function($key) {
                return strpos($key, '_err') !== false;
            }, ARRAY_FILTER_USE_KEY), true));

            // S'il n'y a pas d'erreurs
            if(empty($data['username_err']) && empty($data['email_err']) && 
               empty($data['password_err']) && empty($data['confirm_password_err'])) {
                
                try {
                    // Inscription réussie
                    if($this->userModel->register($data)) {
                        // Message de succès
                        $_SESSION['success_msg'] = 'Vous êtes inscrit, vous pouvez maintenant vous connecter';
                        
                        // Redirection
                        header('Location: ' . BASE_URL . '/auth/login');
                        exit();
                    } else {
                        error_log('Échec de l\'inscription dans la base de données');
                        throw new Exception('Échec de l\'inscription');
                    }
                } catch (Exception $e) {
                    error_log('Erreur lors de l\'inscription : ' . $e->getMessage());
                    $data['register_err'] = 'Une erreur est survenue lors de l\'inscription';
                    $this->view('auth/register', $data);
                }
            } else {
                // Charger la vue avec les erreurs
                $this->view('auth/register', $data);
            }
        } else {
            // Initialiser les données
            $data = [
                'username' => '',
                'email' => '',
                'password' => '',
                'confirm_password' => '',
                'username_err' => '',
                'email_err' => '',
                'password_err' => '',
                'confirm_password_err' => ''
            ];
            
            // Charger la vue
            $this->view('auth/register', $data);
        }
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Traitement de la connexion
            $data = [
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'email_err' => '',
                'password_err' => ''
            ];

            // Valider l'email
            if (empty($data['email'])) {
                $data['email_err'] = 'Veuillez entrer votre email';
            }

            // Valider le mot de passe
            if (empty($data['password'])) {
                $data['password_err'] = 'Veuillez entrer votre mot de passe';
            }

            // Vérifier si l'utilisateur existe
            if ($this->userModel->findUserByEmail($data['email'])) {
                // Vérifier le mot de passe
                $loggedInUser = $this->userModel->login($data['email'], $data['password']);
                if ($loggedInUser) {
                    // Créer la session
                    $this->createUserSession($loggedInUser);
                    header('Location: ' . BASE_URL);
                    exit();
                } else {
                    $data['password_err'] = 'Mot de passe incorrect';
                }
            } else {
                $data['email_err'] = 'Aucun utilisateur trouvé avec cet email';
            }

            // S'il y a des erreurs, recharger la vue
            if (!empty($data['email_err']) || !empty($data['password_err'])) {
                $this->view('auth/login', $data);
            }
        } else {
            // Initialiser le formulaire
            $data = [
                'email' => '',
                'password' => '',
                'email_err' => '',
                'password_err' => ''
            ];

            $this->view('auth/login', $data);
        }
    }

    public function createUserSession($user) {
        $_SESSION['user_id'] = $user->id;
        $_SESSION['user_email'] = $user->email;
        $_SESSION['user_name'] = $user->username;
    }

    public function logout() {
        unset($_SESSION['user_id']);
        unset($_SESSION['user_email']);
        unset($_SESSION['user_name']);
        session_destroy();
        header('Location: ' . BASE_URL);
        exit();
    }
}