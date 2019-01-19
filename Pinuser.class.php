<?php

namespace FreePBX\modules;


use Exception;
use FreePBX\BMO;
use FreePBX_Helpers;
use PDO;
use PDOException;

class Pinuser extends FreePBX_Helpers implements BMO
{

    /**
     * Pinuser constructor.
     *
     * @param null $freepbx
     *
     * @throws Exception
     */
    public function __construct($freepbx = null)
    {
        if ($freepbx == null) {
            throw new Exception("Not given a FreePBX Object");
        }
        $this->FreePBX = $freepbx;
        $this->db = $freepbx->Database;
    }

    public function install()
    {
        // TODO: Implement install() method.
    }

    public function uninstall()
    {
        // TODO: Implement uninstall() method.
    }

    public function doConfigPageInit($page)
    {
        $action = $this->getReq('action','');
        $id = $this->getReq('id','');

        switch ($page) {
            case 'pinuser':
                switch ($action) {
                    case 'sync':
                        return $this->syncPinuser();
                        break;
                    case 'delete':
                        return $this->deletePinuser($id);
                        break;
                    case 'edit':
                        $this->updatePinuser($_REQUEST);
                        break;
                }
                break;
        }
    }

    public function getActionBar($request)
    {
        switch($request['display']) {
            case 'pinuser':
                $buttons = [
                    'delete' => ['name' => 'delete', 'id' => 'delete', 'value' => _('Delete'),],
                    'reset' => ['name' => 'reset', 'id' => 'reset', 'value' => _("Reset"),],
                    'submit' => ['name' => 'submit', 'id' => 'submit', 'value' => _("Submit"),],
                ];

                if (!isset($request['id']) || trim($request['id']) == '') {
                    unset($buttons['delete']);
                }
                if (empty($request['view']) || $request['view'] != 'form') {
                    $buttons = [];
                }
                break;
        }
        return $buttons;
    }

    public function ajaxRequest($command, &$setting)
    {
        //The ajax request
        if ("getJSON" == $command ) {
            return true;
        }
        return false;
    }

    public function ajaxHandler()
    {
        if('getJSON' == $_REQUEST['command'] && 'grid' == $_REQUEST['jdata']){
            $page = !empty($_REQUEST['page']) ? $_REQUEST['page'] : '';
            switch ($page) {
                case 'pinuser':
                    return $this->getListPinuser();
                    break;
            }
        }
        return json_encode(['status' => false, 'message' => _("Invalid Request")]);
    }

    public function showPage($page)
    {
        switch ($page) {
            case 'pinuser':
                $content = load_view(__DIR__ . '/views/pinuser/grid.php');
                if('form' == $_REQUEST['view']){
                    $content = load_view(__DIR__ . '/views/pinuser/form.php');
                    if(isset($_REQUEST['id']) && !empty($_REQUEST['id'])){
                        $content = load_view(__DIR__.'/views/pinuser/form.php', $this->getOnePinuser($_REQUEST['id']));
                    }
                }
                return load_view(__DIR__.'/views/pinuser/default.php', ['content' => $content]);
                break;
        }
    }

    public function getRightNav($request)
    {
        return load_view(__DIR__."/views/pinuser/rnav.php",array());
    }

    private function deletePinuser($id)
    {
        $sql = "DELETE FROM pinuser WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        try {
            $stmt->execute();
        } catch (PDOException $e) {
            die_freepbx($stmt->getMessage()."<br><br>".$sql);
        }
        return redirect('config.php?display=pinuser');
    }

    private function updatePinuser($post)
    {
        $sql = "UPDATE pinuser SET user = :user, department = :department WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $post['id'], PDO::PARAM_INT);
        $stmt->bindParam(':user', $post['user'], PDO::PARAM_STR);
        $stmt->bindParam(':department', $post['department'], PDO::PARAM_STR);
        try {
            $stmt->execute();
        } catch (PDOException $e) {
            if ($e->errorInfo[1] == 1062) {
                echo "<script>javascript:alert('"._("Error! Duplicate pin.")."')</script>";
                return false;
            } else {
                die_freepbx($stmt->getMessage()."<br><br>".$sql);
            }
        }
        return redirect('config.php?display=pinuser');
    }

    private function addPinuser($data)
    {
        $sql = "INSERT INTO pinuser (pin, user, department, enabled) VALUES (:pin, :user, :department, :enabled)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':pin', $data['pin'], PDO::PARAM_STR);
        $stmt->bindParam(':user', $data['user'], PDO::PARAM_STR);
        $stmt->bindParam(':department', $data['department'], PDO::PARAM_STR);
        $stmt->bindParam(':enabled', $data['enabled'], PDO::PARAM_INT);
        try {
            $stmt->execute();
        } catch (PDOException $e) {
            if ($e->errorInfo[1] == 1062) {
                $sql = "UPDATE pinuser SET enabled = 1 WHERE pin = :pin";
                $stmt = $this->db->prepare($sql);
                $stmt->bindParam(':pin', $data['pin'], PDO::PARAM_STR);
                $stmt->execute();
            }
        }
    }

    private function syncPinuser()
    {
        $sql = "UPDATE pinuser SET enabled = 0 ";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        $sql = "SELECT * FROM pinsets";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (is_array($data)) {
            foreach ($data as $d) {
                if ($d['passwords'] != "") {
                    $passwords = explode("\n", $d['passwords']);
                    foreach ($passwords as $key => $value) {
                        $this->addPinuser([
                            'pin' => $value,
                            'user' => '---',
                            'department' => '---',
                            'enabled' => 1,
                            'pinsets_id' => $d['pinsets_id'],
                        ]);
                    }
                }
            }
        }
        return redirect('config.php?display=pinuser');
    }

    private function getListPinuser()
    {
        $sql = 'SELECT * FROM pinuser';
        $data = $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        if (!is_array($data)) {
            return null;
        }
        return $data;
    }

    private function getOnePinuser($id)
    {
        $sql = "SELECT * FROM pinuser WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $pinuser = $stmt->fetchObject();

        $sql = "SELECT description FROM pinsets WHERE passwords LIKE :passwords";
        $stmt = $this->db->prepare($sql);
        $password = "%".$pinuser->pin."%";
        $stmt->bindParam(':passwords', $password, PDO::PARAM_STR);
        $stmt->execute();
        $pinsets = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return [
            'id' => $pinuser->id,
            'pin' => $pinuser->pin,
            'user' => $pinuser->user,
            'department' => $pinuser->department,
            'enabled' => $pinuser->enabled,
            'pinsets' => $pinsets,
        ];
    }
}