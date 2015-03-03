<?php

class UploadController extends Controller {

    public function __construct()
    {
        parent::__construct();
    }

    public function indexAction()
    {
        $this->view->render('index/uploadForm', true);
    }

    public function testuploadAction()
    {
        $this->view->render('upload/testupload', true);
    }

    public function proccesstestuploadAction()
    {
        header("Content-Type: application/json");

        $uploaded = array();

        if (!empty($_FILES['file']['name'][0]))
        {
            foreach ($_FILES['file']['name'] as $position => $name)
            {
                if (move_uploaded_file($_FILES['file']['tmp_name'][$position], 'uploads/' . $name))
                {
                    $uploaded[] = array(
                            'name' => $name,
                            'file' => 'uploads/' . $name
                    );
                }
            }
        }

        echo json_encode($uploaded);
    }

    public function testupload2Action()
    {
        $this->view->render('upload/testupload2', true);
    }

    public function proccesstestupload2Action()
    {
        header("Content-Type: application/json");

        $uploaded = array();

        if (!empty($_FILES['file']['name'][0]))
        {
            foreach ($_FILES['file']['name'] as $position => $name)
            {
                if (move_uploaded_file($_FILES['file']['tmp_name'][$position], 'uploads/' . $name))
                {
                    $uploaded[] = array(
                            'name' => $name,
                            'file' => 'uploads/' . $name
                    );
                }
            }
        }

        echo json_encode($uploaded);
    }

    public function uploadAction()
    {
        header('Content-Type: application/json');
        $uploaded = [];
        $allowed = ['mp4', 'png', 'txt', 'jpg', 'mp3'];
        $succedeed = [];
        $failed = [];
        if (!empty($_FILES['file']))
        {
            foreach ($_FILES['file']['name'] as $key => $name)
            {
                if ($_FILES['file']['error'][$key] === 0)
                {
                    $temp = $_FILES['file']['tmp_name'][$key];
                    $ext = explode('.', $name);
                    $ext = strtolower(end($ext));

                    $file = md5_file($temp) . time() . '.' . $ext;

                    if (move_uploaded_file($temp, "uploads/{$file}") === true && in_array($ext, $allowed) === true)
                    {
                        $succedeed[] = array(
                                "name" => $name,
                                "file" => $file
                        );
                    } else
                    {
                        $failed[] = array(
                                "name" => $name,
                        );
                    }
                }
            }
        }
        if (!empty($_POST['ajax']))
        {
            echo json_encode(array(
                    "succeeded" => $succedeed,
                    "failed" => $failed
            ));
        }

// разрешенные форматы
//        $allowed = array('png', 'jpg', 'gif', 'zip');
//
//        if (isset($_FILES['upl']) && $_FILES['upl']['error'] == 0)
//        {
//
//            $extension = pathinfo($_FILES['upl']['name'], PATHINFO_EXTENSION);
//
//            if (!in_array(strtolower($extension), $allowed))
//            {
//                echo '{"status":"error"}';
//                exit;
//            }
//
//            if (move_uploaded_file($_FILES['upl']['tmp_name'], 'uploads/' . $_FILES['upl']['name']))
//            {
//                echo '{"status":"success"}';
//                exit;
//            }
//        }
//
//        echo '{"status":"error"}';
//        exit;
///////////////////////////////////////////////////////
        /*  if (isset($_POST['upload']))
          {
          //Список разрешенных файлов
          $whitelist = array(".gif", ".jpeg", ".png");
          $data = array();
          $error = true;

          //Проверяем разрешение файла
          foreach ($whitelist as $item)
          {
          if (preg_match("/$item\$/i", $_FILES['userfile']['name']))
          $error = false;
          }

          //если нет ошибок, грузим файл
          if (!$error)
          {

          $folder = 'test/'; //директория в которую будет загружен файл

          $uploadedFile = $folder . basename($_FILES['userfile']['name']);

          if (is_uploaded_file($_FILES['userfile']['tmp_name']))
          {

          if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadedFile))
          {

          $data = $_FILES['userfile'];
          } else
          {
          $data['errors'] = "Во время загрузки файла произошла ошибка";
          }
          } else
          {
          $data['errors'] = "Файл не  загружен";
          }
          } else
          {

          $data['errors'] = 'Вы загружаете запрещенный тип файла';
          }


          //Формируем js-файл
          $res = '<script type="text/javascript">';
          $res .= "var data = new Object;";
          foreach ($data as $key => $value)
          {
          $res .= 'data.' . $key . ' = "' . $value . '";';
          }
          $res .= 'window.parent.handleResponse(data);';
          $res .= "</script>";

          echo $res;
          } else
          {
          die("ERROR");
          } */
    }

}
