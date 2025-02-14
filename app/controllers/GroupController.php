<?php
class GroupController extends Controller {
    private $groupModel;

    public function __construct() {
        // V�rifier si l'utilisateur est connect�
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . '/auth/login');
            exit();
        }
        $this->groupModel = $this->model('Group');
    }

    public function index() {
        // R�cup�rer tous les groupes de l'utilisateur
        $groups = $this->groupModel->getUserGroups($_SESSION['user_id']);
        $data = [
            'groups' => $groups
        ];
        $this->view('groups/index', $data);
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Traiter le formulaire
            $data = [
                'name' => trim($_POST['name']),
                'description' => trim($_POST['description']),
                'owner_id' => $_SESSION['user_id'],
                'name_err' => ''
            ];

            // Validation
            if (empty($data['name'])) {
                $data['name_err'] = 'Veuillez entrer un nom de groupe';
            }

            // S'il n'y a pas d'erreurs
            if (empty($data['name_err'])) {
                if ($this->groupModel->createGroup($data)) {
                    $_SESSION['success_msg'] = 'Groupe cr�� avec succ�s!';
                    header('Location: ' . BASE_URL . '/groups');
                    exit();
                } else {
                    die('Une erreur est survenue');
                }
            } else {
                // Charger la vue avec les erreurs
                $this->view('groups/create', $data);
            }
        } else {
            // Initialiser le formulaire
            $data = [
                'name' => '',
                'description' => '',
                'name_err' => ''
            ];
            $this->view('groups/create', $data);
        }
    }

    // Afficher un groupe sp�cifique
    public function show($id) {
        // V�rifier si l'utilisateur a acc�s � ce groupe
        if (!$this->groupModel->isMember($id, $_SESSION['user_id'])) {
            $_SESSION['error_msg'] = 'Vous n\'avez pas acc�s � ce groupe';
            header('Location: ' . BASE_URL . '/groups');
            exit();
        }

        $group = $this->groupModel->getGroupById($id);
        $members = $this->groupModel->getGroupMembers($id);
        $data = [
            'group' => $group,
            'members' => $members
        ];
        $this->view('groups/show', $data);
    }
}