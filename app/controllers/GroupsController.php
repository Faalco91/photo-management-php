<?php
class GroupsController extends Controller {
    private $groupModel;
    private $photoModel;
    private $userModel;

    public function __construct() {
        if(!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . '/auth/login');
            exit();
        }
        $this->groupModel = $this->model('Group');
        $this->photoModel = $this->model('Photo');
        $this->userModel = $this->model('User'); // Ajout du modèle User
    }

    public function index() {
        header('Location: ' . BASE_URL . '/dashboard');
        exit();
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'name' => trim($_POST['name']),
                'description' => trim($_POST['description']),
                'owner_id' => $_SESSION['user_id'],
                'name_err' => ''
            ];

            if(empty($data['name'])) {
                $data['name_err'] = 'Veuillez entrer un nom de groupe';
            }

            if(empty($data['name_err'])) {
                if($this->groupModel->createGroup($data)) {
                    $_SESSION['success_msg'] = 'Groupe créé avec succès';
                    header('Location: ' . BASE_URL . '/dashboard');
                    exit();
                } else {
                    $data['name_err'] = 'Une erreur est survenue lors de la création du groupe';
                }
            }

            $this->view('groups/create', $data);
        } else {
            $data = [
                'name' => '',
                'description' => '',
                'name_err' => ''
            ];

            $this->view('groups/create', $data);
        }
    }

    public function show($id = null) {
        if($id === null) {
            header('Location: ' . BASE_URL . '/dashboard');
            exit();
        }

        if(!$this->groupModel->isMember($id, $_SESSION['user_id'])) {
            $_SESSION['error_msg'] = "Vous n'avez pas accès à ce groupe";
            header('Location: ' . BASE_URL . '/dashboard');
            exit();
        }

        $group = $this->groupModel->getGroupById($id);
        $members = $this->groupModel->getGroupMembers($id);
        $photos = $this->photoModel->getPhotosByGroup($id);
        $isOwner = $this->groupModel->isOwner($id, $_SESSION['user_id']);

        if($group) {
            $data = [
                'group' => $group,
                'members' => $members,
                'photos' => $photos,
                'isOwner' => $isOwner
            ];

            $this->view('groups/show', $data);
        } else {
            header('Location: ' . BASE_URL . '/dashboard');
            exit();
        }
    }

    public function addMember($groupId) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = trim($_POST['email']);

            // Validation de l'email
            if (empty($email)) {
                $_SESSION['error_msg'] = "Veuillez entrer une adresse email";
                header('Location: ' . BASE_URL . '/groups/show/' . $groupId);
                exit();
            }

            // Vérifier si l'utilisateur existe
            $userToAdd = $this->userModel->findUserByEmail($email);
            if (!$userToAdd) {
                $_SESSION['error_msg'] = "Aucun utilisateur trouvé avec cette adresse email";
                header('Location: ' . BASE_URL . '/groups/show/' . $groupId);
                exit();
            }

            // Vérifier si l'utilisateur n'est pas déjà membre
            if ($this->groupModel->isMember($groupId, $userToAdd->id)) {
                $_SESSION['error_msg'] = "Cet utilisateur est déjà membre du groupe";
                header('Location: ' . BASE_URL . '/groups/show/' . $groupId);
                exit();
            }

            // Ajouter le membre
            if ($this->groupModel->addMember($groupId, $userToAdd->id, 'member')) {
                $_SESSION['success_msg'] = "Membre ajouté avec succès";
            } else {
                $_SESSION['error_msg'] = "Erreur lors de l'ajout du membre";
            }

            header('Location: ' . BASE_URL . '/groups/show/' . $groupId);
            exit();
        }
    }

    public function removeMember($groupId, $memberId) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (!$this->groupModel->isOwner($groupId, $_SESSION['user_id'])) {
                $_SESSION['error_msg'] = "Vous n'avez pas les droits pour retirer des membres";
                header('Location: ' . BASE_URL . '/groups/show/' . $groupId);
                exit();
            }

            if ($this->groupModel->removeMember($groupId, $memberId)) {
                $_SESSION['success_msg'] = "Membre retiré avec succès";
            } else {
                $_SESSION['error_msg'] = "Erreur lors du retrait du membre";
            }

            header('Location: ' . BASE_URL . '/groups/show/' . $groupId);
            exit();
        }
    }

    public function delete($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (!$this->groupModel->isOwner($id, $_SESSION['user_id'])) {
                $_SESSION['error_msg'] = "Vous n'avez pas les droits pour supprimer ce groupe";
                header('Location: ' . BASE_URL . '/groups/show/' . $id);
                exit();
            }

            if ($this->groupModel->deleteGroup($id)) {
                $_SESSION['success_msg'] = 'Groupe supprimé avec succès';
                header('Location: ' . BASE_URL . '/dashboard');
            } else {
                $_SESSION['error_msg'] = 'Une erreur est survenue lors de la suppression du groupe';
                header('Location: ' . BASE_URL . '/groups/show/' . $id);
            }
            exit();
        }
    }
}