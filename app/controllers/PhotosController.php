<?php

class PhotosController extends Controller {
    private $photoModel;
    private $groupModel;

    public function __construct() {
        if(!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . '/auth/login');
            exit();
        }
        $this->photoModel = $this->model('Photo');
        $this->groupModel = $this->model('Group');
    }

    public function upload() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'user_id' => $_SESSION['user_id'],
                'group_id' => trim($_POST['group_id']),
                'title' => trim($_POST['title']),
                'description' => trim($_POST['description']),
                'is_public' => isset($_POST['is_public']) ? 1 : 0,
                'filename' => '',
                'title_err' => '',
                'group_id_err' => '',
                'photo_err' => ''
            ];

            // Validation
            if(empty($data['title'])) {
                $data['title_err'] = 'Veuillez entrer un titre';
            }

            if(empty($data['group_id'])) {
                $data['group_id_err'] = 'Veuillez sélectionner un groupe';
            }

            // Validation du fichier
            if(isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
                $allowed = ['jpg', 'jpeg', 'png', 'gif'];
                $filename = $_FILES['photo']['name'];
                $filetype = $_FILES['photo']['type'];
                $filesize = $_FILES['photo']['size'];

                $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
                if(!in_array($ext, $allowed)) {
                    $data['photo_err'] = 'Format de fichier non autorisé. Formats acceptés : ' . implode(', ', $allowed);
                }

                if($filesize > 5 * 1024 * 1024) {
                    $data['photo_err'] = 'Le fichier est trop volumineux. Taille maximum : 5MB';
                }

                if(empty($data['photo_err'])) {
                    $data['filename'] = uniqid() . '.' . $ext;
                }
            } else {
                $data['photo_err'] = 'Veuillez sélectionner une photo';
            }

            if(empty($data['title_err']) && empty($data['group_id_err']) && empty($data['photo_err'])) {
                $uploadDir = 'uploads/photos/';
                if(!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                $uploadPath = $uploadDir . $data['filename'];

                if(move_uploaded_file($_FILES['photo']['tmp_name'], $uploadPath)) {
                    if($this->photoModel->addPhoto($data)) {
                        $_SESSION['success_msg'] = 'Photo uploadée avec succès';
                        header('Location: ' . BASE_URL . '/groups/show/' . $data['group_id']);
                        exit();
                    } else {
                        if(file_exists($uploadPath)) {
                            unlink($uploadPath);
                        }
                        $data['photo_err'] = 'Erreur lors de l\'enregistrement de la photo';
                    }
                } else {
                    $data['photo_err'] = 'Erreur lors de l\'upload du fichier';
                }
            }

            $this->loadUploadView($data);
        } else {
            $data = [
                'user_id' => $_SESSION['user_id'],
                'group_id' => '',
                'title' => '',
                'description' => '',
                'is_public' => 0,
                'filename' => '',
                'title_err' => '',
                'group_id_err' => '',
                'photo_err' => ''
            ];

            $this->loadUploadView($data);
        }
    }

    private function loadUploadView($data) {
        $data['groups'] = $this->groupModel->getUserGroups($_SESSION['user_id']);
        $this->view('photos/upload', $data);
    }
}