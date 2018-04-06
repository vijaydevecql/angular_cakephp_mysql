<?php

App::uses('Controller', 'Controller');

class AppController extends Controller {

    var $_admin_data = array();

    /*
     * beforeRender function is here
     */

    function beforeRender() {
        $_admin_data = $this->Session->read('Admin');
        // prx($_admin_data);
        unset($_admin_data['password']);

        $this->set('_admin_data', $_admin_data);
    }

    /*
     * beforFilter function is here
     */

    function beforeFilter() {
        $_admin_data = $this->Session->read('Admin');
        $this->_admin_data = $_admin_data;
    }

    /*
     * check the admin auth check
     */

    function _admin_auth_check() {
        $_user = $this->Session->read('Admin');
        if (isset($_user['id']) && is_numeric($_user['id'])) {
            $this->layout = 'admin_dashboard';
            $this->_admin_data = $this->Session->read('restaurant_admin.Admin');
            return true;
        } else {
            $this->layout = 'admin_login';
            return false;
        }
    }

    /*
     * _deny_url fucntions
     */

    function _deny_url() {
        $action = $this->params->params['action'];
        $admin = isset($this->params->params['admin']) && trim($this->params->params['admin']) == 1 ? 1 : 0;
        //prx($this->params->params);
        if ($admin) {
            // If method requires login then redirect to login page[if logged out] with referer URL, and to dashboard otherwise
            if (!empty($this->_deny['admin'])) {
                if (in_array($action, $this->_deny['admin'])) {
                    if (!$this->_admin_auth_check()) {
                        $this->Session->write('admin_redirect', $this->params->url);
                        return $this->redirect('login');
                    }
                }
            }
        }
    }

    function get_token($user_id) {
        $this->loadmodel('User');
        $data = $this->User->find('first', [
            'conditions' => [
                'User.id' => $user_id
            ]
        ]);
        // prx($data['User']);
        // die;
        return $data['User'];
    }

    /**
     * Send push notification to Android and iOS using device_token
     *
     * @param array $data
     */
    function _send_push($data = []) {
        $notifDbDetails = array(
            "message" => $data['message'],
            "title" => APP_NAME . " Notification",
            "msgcnt" => "1",
            "soundname" => "beep.wav",
            "timeStamp" => time(),
            "notification_code" => $data['notification_code'],
            "Unread" => '',
            "body" => $data['body']
        );
        $info = $this->get_token($data['user_id']);
        //prx($info);
        $device_id = $info['device_type'];
        $device_token = $info['device_token'];
        if (strlen(trim($device_token)) == 0) {
            return false;
        }
        if ($device_id == '152525') {

            $deviceToken = $device_token;
            $passphrase = '123456789';

            $message = $message;

            $ctx = stream_context_create();
            stream_context_set_option($ctx, 'ssl', 'local_cert', dirname(__FILE__) . '/playpush.pem');
            stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);

            // Open a connection to the APNS server
            $fp = stream_socket_client(
                    'ssl://gateway.push.apple.com:2195', $err, $errstr, 60, STREAM_CLIENT_CONNECT | STREAM_CLIENT_PERSISTENT, $ctx);

            if (!$fp)
                exit("Failed to connect: $err $errstr" . PHP_EOL);


            PHP_EOL;


            $body = $notifDbDetails;
            $body['aps'] = array(
                'alert' => 'you have new message',
                'sound' => 'default',
                'badge' => (int) $unread_messages
            );


            $payload = json_encode($body);
            // print_r($payload);
            $msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;

            $result = fwrite($fp, $msg, strlen($msg));
            // print_r($result);
            if (!$result)
                PHP_EOL;
            else
                PHP_EOL;

            fclose($fp);
        }
        else {

            if (count($device_token) > 0) {

                $url = 'https://fcm.googleapis.com/fcm/send';
                //$device_id;
                if($device_id==1){
                  $fields = array(
                      'registration_ids' => array($device_token),
                      'data' => $notifDbDetails,
                  );
                }else{

                        $fcmMsg = array(
                            'body' => $notifDbDetails,
                            'title' => $notifDbDetails['message'],
                            'sound' => "default",
                            'color' => "#203E78"
                        );

                        $fields = array(
                            'to' => $device_token,
                            'priority' => 'high',
                            'notification' => $fcmMsg
                        );
                }


                $key = GOOGLEKEY;
                $headers = array(
                    'Authorization: key=' . $key,
                    'Content-Type: application/json'
                );
            }

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
            $result = curl_exec($ch);
            //print_r($result);
            curl_close($ch);
        }
    }

    /*
     * twillo function is here
     */

    public function twilio_sms($to, $body) {
        $username = TWILIO_ACCOUNT_SID;
        $password = TWILIO_AUTH_TOKEN;

        $data = [
            'To' => $to,
            'From' => TWILIO_SENDING_NUMBER,
            'Body' => $body
        ];
        $req = '';
        foreach ($data as $key => $value) {
            $value = urlencode($value);
            $req .= "&$key=$value";
        }
        $_url = "https://api.twilio.com/2010-04-01/Accounts/" . TWILIO_ACCOUNT_SID . "/Messages.json";

        $ch = curl_init();
        $curlConfig = [
            CURLOPT_URL => $_url,
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POSTFIELDS => $req,
            CURLOPT_HTTPAUTH => CURLAUTH_BASIC,
            CURLOPT_USERPWD => "{$username}:{$password}"
        ];
        curl_setopt_array($ch, $curlConfig);
        $result = curl_exec($ch);


        curl_close($ch);
        if ($result) {

            return true;
        }
        return false;
    }

    /**
     *
     * Send email using mailgun API
     *
     * As of 2017-07-15 email account connected with the API credentials is <dinesh.cql@gmail.com>
     *
     * @param type $params
     * @return boolean
     */

    /**
     *
     * $mail = [];
     * $params['to'] = 'JD <jd.cqlsys@gmail.com>';
     * $params['from'] = 'Admin <admin@apphinge.com>';
     * $params['subject'] = 'Test Subject | ' . date('M d Y H:i:s');
     * $params['body'] = 'Test Body | ' . date('M d Y H:i:s');
     * mg_mail($params);
     *
     * NOTE - This function does not support attachments.
     * As of 2017-07-15 - attachment code is available with Harsh <harsh@cqlsys.co.uk>
     *
     * @param type $params
     * @return type
     */
    function mg_mail($params = []) {

        $_params = ['to' => 'to@apphinge.com', 'subject' => 'Test Subject | ' . date('Y m d H:i:s'), 'body' => 'Test Body'];
        foreach ($params as $k => $param) {
            if (!strlen(trim($param)) || !array_key_exists($k, $_params)) {
                $r = "$k is empty";
                return $r;
            }
        }


        $username = 'api';
        $password = MAILGUN_API_KEY;

        $params['from'] = 'admin@apphinge.com';

        $data = [
            'to' => $params['to'],
            'from' => $params['from'],
            'subject' => $params['subject'],
            'html' => $params['body']
        ];
        $req = '';
        foreach ($data as $key => $value) {
            $value = urlencode($value);
            $req .= "&$key=$value";
        }
        $_url = "https://api.mailgun.net/v3/mail.apphinge.com/messages";

        $ch = curl_init();
        $curlConfig = [
            CURLOPT_URL => $_url,
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POSTFIELDS => $req,
            CURLOPT_HTTPAUTH => CURLAUTH_BASIC,
            CURLOPT_USERPWD => "{$username}:{$password}"
        ];
        curl_setopt_array($ch, $curlConfig);
        $result = curl_exec($ch);

        curl_close($ch);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    /**
     *
     * @param type $status
     * @param type $body
     */
    public function json($status, $body) {

        $this->_code = (is_array($status)) ? $status['code'] : $status;
        if ($this->_code != 200) {
            if (count(array_intersect(explode(' ', $body), array('get', 'post', 'delete', 'put', 'GET', 'POST', 'PUT', 'DELETE')))) {
                $this->_code = 405;
            }
            if ($body == 'Invalid authorization_key') {
                $this->_code = 407;
            }
            header('message: ' . $body . '');
            $result['code'] = $this->_code;
            $result['success'] = false;
            $result['error_message'] = $body;
            $result['body'] = [];
        } else {
            header('message: ' . $status['message'] . '');
            $result['code'] = $status['code'];
            $result['success'] = true;
            $result['message'] = $status['message'];
            $result['body'] = $body;
        }
        $this->set_headers();
        echo trim(json_encode($result));
        exit;
    }

    /**
     *
     * @return type
     */
    private function get_status_message() {

        $status = array(
            100 => 'Continue',
            101 => 'Switching Protocols',
            200 => 'OK',
            201 => 'Created',
            202 => 'Accepted',
            203 => 'Non-Authoritative Information',
            204 => 'No Content',
            205 => 'Reset Content',
            206 => 'Partial Content',
            300 => 'Multiple Choices',
            301 => 'Moved Permanently',
            302 => 'Found',
            303 => 'See Other',
            304 => 'Not Modified',
            305 => 'Use Proxy',
            306 => '(Unused)',
            307 => 'Temporary Redirect',
            400 => 'Bad Request',
            401 => 'Unauthorized',
            402 => 'Payment Required',
            403 => 'Forbidden',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            406 => 'Not Acceptable',
            407 => 'Proxy Authentication Required',
            408 => 'Request Timeout',
            409 => 'Conflict',
            410 => 'Gone',
            411 => 'Length Required',
            412 => 'Precondition Failed',
            413 => 'Request Entity Too Large',
            414 => 'Request-URI Too Long',
            415 => 'Unsupported Media Type',
            416 => 'Requested Range Not Satisfiable',
            417 => 'Expectation Failed',
            500 => 'Internal Server Error',
            501 => 'Not Implemented',
            502 => 'Bad Gateway',
            503 => 'Service Unavailable',
            504 => 'Gateway Timeout',
            505 => 'HTTP Version Not Supported');
        return (isset($this->_code) && strlen(trim($this->_code)) && isset($status[$this->_code])) ? $status[$this->_code] : $status[500];
    }

    /**
     *  set header
     */
    private function set_headers() {
        //pr($this->get_status_message()); die;
        header("HTTP/1.1 " . $this->_code . " " . $this->get_status_message());
        header("Content-Type:" . $this->_content_type);
    }

    public function required($data) {
        $field = array();
        foreach ($data as $key => $value) {
            if (trim($data[$key]) == "") {
                $field[] = $key . " field is required";
            }
        }
        if (!empty($field)) {
            $status = 400;
            $body = implode(' , ', $field);
            return $this->json($status, $body);
        }
    }

    public function validarray($requr, $nonrequred) {
        try {
            $model_name = (isset($requr['model'])) ? $requr['model'] : 'User';
            if (@$requr['authorization_key']) {
                if (!$this->checkid($model_name, 'authorization_key', $requr['authorization_key'])) {
                    throw new Exception('Invalid authorization_key');
                } else {
                    $requr['user' . '_id'] = $this->userid($model_name, @$requr['authorization_key']);
                }
            }

            $checking = $this->required($requr);

            if (@$requr['password']) {
                $requr['password'] = sha1($requr['password']);
            }


            $Array = array_merge($requr, $nonrequred);
            if (@$Array['email']) {
                if (self::email($Array['email'])) {
                    throw new Exception("enter valid email address");
                }
            }
            if (@$Array['checking_exits'] == 1) {
                $this->auto_checking($Array);
                if (@$Array['email']) {
                    if ($this->checkid($model_name, 'email', $Array['email'])) {
                        throw new Exception('this email is already register kindly use another');
                    }
                }
                if (@$Array['username']) {
                    if ($this->checkid($model_name, 'username', $Array['username'])) {
                        throw new Exception('this username is already register kindly use another');
                    }
                }
                if (@$Array['mobile']) {
                    if ($this->checkid($model_name, 'mobile', $Array['mobile'])) {
                        throw new Exception('this mobile number  is already register kindly use another');
                    }
                }
                if (@$Array['phone']) {
                    if ($this->checkid($model_name, 'phone', $Array['phone'])) {
                        throw new Exception('this mobile number  is already register kindly use another');
                    }
                }
                // checking token here ; note-> checking where token is store in table
            }
            unset($Array['checking_exits']);
            return $Array;
        } catch (Exception $e) {
            $status = FAILURE_CODE;
            $body = $e->getMessage();
            return $this->json($status, $body);
        }
    }

    /*
     * parameters @array
     * this function is auto check send id is exites the data base or not
     * author @pankaj vashisht
     * email @sharmapankaj688@gmail.com
     */

    public function auto_checking($array) {
        try {
            if (is_array($array)) {
                foreach ($array as $key => $value) {
                    if (substr($key, -3) == '_id') {
                        $model = ucwords(str_replace('_id', '', $key));
                        if ($model == "Friend") {
                            $model = "User";
                        }
                        if (!$this->checkid($model, 'id', $value)) {
                            $status = 401;
                            throw new Exception('Invalid ' . $model);
                        }
                    }
                }
            } else {
                return false;
            }
        } catch (Exception $e) {
            $body = $e->getMessage();
            return $this->json($status, $body);
        }
    }

    public static function email($email) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
            return true;
        }
    }

    private function userid($model_name, $value) {
        App::uses($model_name, 'Model');
        $this->{$model_name} = new $model_name;
        $fn = "findByauthorization_key";
        $return = $this->$model_name->{$fn}($value);
        return $return[$model_name]['id'];
    }

    public function send_value($data, $dbdata) {
        return ( isset($data) || trim($data) != "") ? $data : $dbdata;
    }

    /**
     *
     * @param type $status
     * @param type $body
     */
    public function checkid($model_name, $field_name, $value, $data = 0) {
        App::uses($model_name, 'Model');
        $this->{$model_name} = new $model_name;
        $fn = "findBy{$field_name}";
        $return = $this->$model_name->{$fn}($value);
        if ($data == 0) {
            unset($this->{$model_name});
        }
        if ($return) {
            if ($data == 0) {
                return true;
            } else {
                return $return[$model_name];
            }
        }
        return false;
    }

    function _generate_random_number() {
        return sha1(rand() . time() . microtime() . rand() . sha1(time()));
    }

    function _get_random_name() {
        return sha1(time() . microtime() . rand() . rand());
    }

    public function sendmail($params = []) {
        $_parmas = ['to' => 'to@admin.com', 'from' => 'from@admin.com', 'subject' => 'Test Subject | ' . date('Y m d H:i:s'), 'body' => 'Test Body'];
        foreach ($params as $k => $param) {
            if (!strlen(trim($param)) || !array_key_exists($k, $_parmas)) {
                $r = "$k is empty";
                return $r;
            }
        }

        define('API', 'key-c58a069be6d91f94336037421eeb84fb');

        $username = 'api';
        $password = API;


        $data = [
            'to' => $params['to'],
            'from' => $params['from'],
            'subject' => $params['subject'],
            'html' => $params['body']
        ];
        $req = '';
        foreach ($data as $key => $value) {
            $value = urlencode($value);
            $req .= "&$key=$value";
        }
        $_url = "https://api.mailgun.net/v3/mail.apphinge.com/messages";

        $ch = curl_init();
        $curlConfig = [
            CURLOPT_URL => $_url,
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POSTFIELDS => $req,
            CURLOPT_HTTPAUTH => CURLAUTH_BASIC,
            CURLOPT_USERPWD => "{$username}:{$password}"
        ];
        curl_setopt_array($ch, $curlConfig);
        $result = curl_exec($ch);

        curl_close($ch);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function twilio($to, $body) {
        $username = TWILIO_ACCOUNT_SID;
        $password = TWILIO_AUTH_TOKEN;

        $data = [
            'To' => '+' . $to,
            'From' => TWILIO_SENDING_NUMBER,
            'Body' => $body
        ];
        $req = '';
        foreach ($data as $key => $value) {
            $value = urlencode($value);
            $req .= "&$key=$value";
        }
        $_url = "https://api.twilio.com/2010-04-01/Accounts/AC84eb5711229b077437ca2993af0c51e4/Messages.json";

        $ch = curl_init();
        $curlConfig = [
            CURLOPT_URL => $_url,
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POSTFIELDS => $req,
            CURLOPT_HTTPAUTH => CURLAUTH_BASIC,
            CURLOPT_USERPWD => "{$username}:{$password}"
        ];
        curl_setopt_array($ch, $curlConfig);
        $result = curl_exec($ch);


        curl_close($ch);
        if ($result) {
            return true;
        }
        return false;
    }

    function _abs_url($path = '') {
        return 'http://' . $_SERVER['HTTP_HOST'] . $this->webroot . $path;
    }

    /*     * ******************************************************* api function over **************************************** */

    /**
     *
     *
     * @param type $type_name
     * @param type $field_name
     * @return type
     */
    function _make_images_array($field_name = 'image', $folder_name) {

        $_imgs = [];
        if (isset($_FILES) && is_array($_FILES) && count($_FILES) && count($_FILES[$field_name]) && count($_FILES[$field_name]['name'])) {
            if (is_array($_FILES[$field_name]['name'])) {
                foreach ($_FILES[$field_name]['name'] as $k => $v) {
                    $_imgs[$k] = [
                        'name' => $_FILES[$field_name]['name'][$k],
                        'type' => $_FILES[$field_name]['type'][$k],
                        'tmp_name' => $_FILES[$field_name]['tmp_name'][$k],
                        'error' => $_FILES[$field_name]['error'][$k],
                        'size' => $_FILES[$field_name]['size'][$k]
                    ];
                }
            } else {
                $k = 0;
                $_imgs[$k] = [
                    'name' => $_FILES[$field_name]['name'],
                    'type' => $_FILES[$field_name]['type'],
                    'tmp_name' => $_FILES[$field_name]['tmp_name'],
                    'error' => $_FILES[$field_name]['error'],
                    'size' => $_FILES[$field_name]['size']
                ];
            }
        }
        $imgs = $this->_upload_images($_imgs, $folder_name);

        return $imgs;
    }

    /**
     *
     * ############################################################
     * #                                                          #
     * #                                                          #
     * #            File uploading methods end here               #
     * #                                                          #
     * #                                                          #
     * ############################################################
     *
     */
    function _upload_images($images, $folder_name) {

        $_file_names = [];
        $_file_uploaded = FALSE;
        $_default = 1;
        $_i = 0;
        if (isset($images) && is_array($images) && count($images)) {
            foreach ($images as $k => $image) {

                $_file_uploaded = $this->_upload_file($image, '', $folder_name);

                if ($_file_uploaded) {
                    $_file_names[$_i]['name'] = $_file_uploaded;
                    $_file_uploaded = FALSE;
                    $_file_names[$_i]['default'] = $_default;
                    if ($_default) {
                        $_default = 0;
                    }
                }
                $_i++;
            }
        }

        return $_file_names;
    }

    function _upload_file($source, $destination = '', $folder = 'services', $unlink = '') {
        //  prx($source);
        if (trim($destination) == '') {
            $destination = APP . DS . 'webroot' . DS . 'uploads' . DS . $folder . DS;
        }
        if (substr($destination, -1, 1) != DS) {
            $destination .= DS;
        }
        if (!is_array($source) || $source['error'] != 0) {
            return false;
        }

        $random_name = $this->_get_random_name();
        $_name_fragments = explode('.', $source['name']);
        $extension = $_name_fragments[count($_name_fragments) - 1];
        $filename = $random_name . '.' . $extension;

        $upload_image = $destination . $filename;
        if (move_uploaded_file($source['tmp_name'], $destination . $filename)) {
            if (substr(strtolower($source['type']), 0, 5) == 'image') {
                // Process thumbnails
                $thumbnail_sizes = [['100', '100'], ['300', '300'], ['500', '500'], ['1000', '1000']];
                $file_ext = strtolower($extension);
                list($width, $height) = getimagesize($upload_image);
                if ($width == $height) {
                    $case = 1;
                }
                if ($width > $height) {
                    $case = 2;
                }
                if ($width < $height) {
                    $case = 3;
                }
                foreach ($thumbnail_sizes as $size) {


                    switch ($case) {

                        case 1:

                            $thumb_width = $size[0];
                            $thumb_height = $size[1];

                            break;

                        case 2:

                            $thumb_height = $size[1];
                            $ratio = $thumb_height / $height;
                            $thumb_width = round($width * $ratio);

                            break;

                        case 3:

                            $thumb_width = 100;
                            $ratio = $thumb_width / $width;
                            $thumb_height = round($height * $ratio);

                            break;
                    }
                    // $thumb_width=$size[0];
                    // $thumb_height=$size[1];

                    $thumbnail = $destination . DS . $size[0] . 'x' . $size[1] . $filename;
                    // prx($thumbnail);


                    $thumb_create = imagecreatetruecolor($thumb_width, $thumb_height);
                    switch ($file_ext) {
                        case 'jpg':
                        case 'jpeg':
                            $source = imagecreatefromjpeg($upload_image);
                            break;

                        case 'png':
                            $source = imagecreatefrompng($upload_image);
                            $background = imagecolorallocate($thumb_create, 0, 0, 0);
                            imagecolortransparent($thumb_create, $background);
                            imagealphablending($thumb_create, FALSE);
                            imagesavealpha($thumb_create, TRUE);
                            break;
                        case 'gif':
                            $source = imagecreatefromgif($upload_image);
                            break;
                        default:
                            $source = imagecreatefromjpeg($upload_image);
                            break;
                    }

                    //imagecopyresized($thumb_create, $source, 0, 0, 0, 0, $thumb_width, $thumb_height, $width, $height);
                    imagecopyresampled($thumb_create, $source, 0, 0, 0, 0, $thumb_width, $thumb_height, $width, $height);
                    switch ($file_ext) {
                        case 'jpg':
                        case 'jpeg':
                            imagejpeg($thumb_create, $thumbnail, 100);
                            break;
                        case 'png':
                            imagepng($thumb_create, $thumbnail, 9);
                            break;

                        case 'gif':
                            imagegif($thumb_create, $thumbnail, 100);
                            break;
                        default:
                            imagejpeg($thumb_create, $thumbnail, 100);
                            break;
                    }
                }
            }
            return $filename;
        }
        return false;
    }

    function _abs_url1($path = '') {
        return 'http://' . $_SERVER['HTTP_HOST'] . $this->webroot . $path;
    }

    /** new   PAYPAL;* */
    public function paypal($_params) {

        $sandbox = TRUE;
        $api_version = '86.0';
        $api_endpoint = $sandbox ? 'https://api-3t.sandbox.paypal.com/nvp' : 'https://api-3t.paypal.com/nvp';
        $api_username = $sandbox ? 'pankaj_api1.cqlsys.co.uk' : 'LIVE_USERNAME_GOES_HERE';
        $api_password = $sandbox ? 'UBNQ3BWDNBE7H65Q' : 'LIVE_PASSWORD_GOES_HERE';
        $api_signature = $sandbox ? 'AFcWxV21C7fd0v3bYYYRCpSSRl31AEiC7Zq5BkaVVEJfAHbgXrXQvFSL' : 'LIVE_SIGNATURE_GOES_HERE';

        $amount = number_format($_params['amount'], 2, '.', '');
        $card_number = $_params['card_number'];
        $card_type = isset($_params['card_type']) && strlen($_params['card_type']) ? $_params['card_type'] : 'VISA';
        $card_cvv2 = $_params['cvv'];
        $card_exp_month = $_params['expiry_month'];
        $card_exp_year = $_params['expiry_year'];
        $card_exp = $card_exp_month . '' . $card_exp_year;
        $request_params = array
            (
            'METHOD' => 'DoDirectPayment',
            'USER' => $api_username,
            'PWD' => $api_password,
            'SIGNATURE' => $api_signature,
            'VERSION' => $api_version,
            'PAYMENTACTION' => 'Sale',
            'IPADDRESS' => $_SERVER['REMOTE_ADDR'],
            'CREDITCARDTYPE' => $card_type,
            'ACCT' => $card_number,
            'EXPDATE' => $card_exp,
            'CVV2' => $card_cvv2,
            //  'FIRSTNAME' => 'Tester',
            //  'LASTNAME' => 'Testerson',
            //  'STREET' => '707 W. Bay Drive',
            //  'CITY' => 'Largo',
            //   'STATE' => 'FL',
            // 'COUNTRYCODE' => 'US',
            //'ZIP' => '33770',
            'AMT' => $amount,
            'CURRENCYCODE' => 'USD',
            'DESC' => 'Sloat booking payment'
        );

        $nvp_string = '';
        foreach ($request_params as $var => $val) {
            $nvp_string .= '&' . $var . '=' . urlencode($val);
        }

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_VERBOSE, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);

        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($curl, CURLOPT_URL, $api_endpoint);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $nvp_string);

        $result = curl_exec($curl);
        curl_close($curl);
        $d__ = $this->NVPToArray($result);
        return $d__;
    }

    function NVPToArray($NVPString) {
        $proArray = array();
        while (strlen($NVPString)) {
            $keypos = strpos($NVPString, '=');
            $keyval = substr($NVPString, 0, $keypos);
            $valuepos = strpos($NVPString, '&') ? strpos($NVPString, '&') : strlen($NVPString);
            $valval = substr($NVPString, $keypos + 1, $valuepos - $keypos - 1);
            $proArray[$keyval] = urldecode($valval);
            $NVPString = substr($NVPString, $valuepos + 1, strlen($NVPString));
        }
        return $proArray;
    }

}
